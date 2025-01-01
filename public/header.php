<?php

class headers
{
    function startheaders()
    {
        global $db, $ir, $set, $userid;

        $format = fn ($value) => $value ? (' (' . number_format($value) . ')') : '';
        $hospital = $format($db->execute('SELECT COUNT(*) FROM users WHERE hospital > 0')->fetchColumn());
        $jail = $format($db->execute('SELECT COUNT(*) FROM users WHERE jail > 0')->fetchColumn());
        $events = $format($db->execute('SELECT COUNT(*) FROM events WHERE evUSER = :uid and evREAD = 0', ['uid' => $userid])->fetchColumn());
        $mail = $format($db->execute('SELECT COUNT(*) FROM mail WHERE mail_to = :uid and mail_read = 0', ['uid' => $userid])->fetchColumn());

        echo <<<HTML
            <!DOCTYPE html>
            <html lang="en-GB">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <title>Monolegacy</title>
                <script src="https://cdn.tailwindcss.com"></script>
                <script src="//unpkg.com/alpinejs" defer></script
                <link href="css/game.css" rel="stylesheet" />
            </head>
            <body class="bg-slate-200">
                <div class="max-w-5xl mx-auto shadow-xl">
                    <div class="bg-teal-500 h-16 flex justify-between items-center px-3">
                        <div class="flex items-center">
                            <a href="/" class="text-teal-900 hover:text-teal-200 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </a>
                            <a href="/explore.php" class="text-teal-900 hover:text-teal-200 p-3">Explore</a>
                            <a href="/inventory.php" class="text-teal-900 hover:text-teal-200 p-3">Inventory</a>
                            <span class="border-r border-teal-600 text-sm pl-1 mr-1">&nbsp;</span>
                            <a href="/hospital.php" class="text-teal-900 hover:text-teal-200 p-3">Hospital{$hospital}</a>
                            <a href="/jail.php" class="text-teal-900 hover:text-teal-200 p-3">Jail{$jail}</a>
                            <span class="border-r border-teal-600 text-sm pl-1 mr-1">&nbsp;</span>
                            <a href="/events.php" class="text-teal-900 hover:text-teal-200 p-3">Events{$events}</a>
                            <a href="/forums.php" class="text-teal-900 hover:text-teal-200 p-3">Forum</a>
                            <a href="/mailbox.php" class="text-teal-900 hover:text-teal-200 p-3">Mail{$mail}</a>
                        </div>
                        <div class="flex items-center">
                        </div>
                    </div>
                    <div class="flex">
        HTML;
    }

    function userdata($ir, $lv, $fm, $cm, $dosessh = true)
    {
        global $db, $c, $userid, $set;
        $IP = $db->escape($_SERVER['REMOTE_ADDR']);
        $db->query(
            "UPDATE `users`
                 SET `laston` = {$_SERVER['REQUEST_TIME']}, `lastip` = '$IP'
                 WHERE `userid` = $userid");
        if (!isset($_SESSION['attacking']))
        {
            $_SESSION['attacking'] = 0;
        }
        if ($dosessh && ($_SESSION['attacking'] || $ir['attacking']))
        {
            echo "You lost all your EXP for running from the fight.";
            $db->query(
                "UPDATE `users`
                     SET `exp` = 0, `attacking` = 0
                     WHERE `userid` = $userid");
            $_SESSION['attacking'] = 0;
        }

        $ep = ($ir['energy'] * 100) / $ir['maxenergy'];
        $ef = number_format($ep, 2) . ' %';
        $np = ($ir['brave'] * 100) / $ir['maxbrave'];
        $nf = number_format($ir['brave']) . ' / ' . number_format($ir['maxbrave']);
        $hp = ($ir['hp'] * 100) / $ir['maxhp'];
        $hf = number_format($hp, 2) . ' %';
        $dp = ($ir['will'] * 100) / $ir['maxwill'];
        $df = number_format($ir['will']) . ' / ' . number_format($ir['maxwill']);
        $xp = min(($ir['exp'] * 100) / $ir['exp_needed'], 100);
        $xf = $ir['exp'] >= $ir['exp_needed'] ? '<a href="/upgrade.php" class="text-blue-700 hover:underline">Upgrade</a>' : ('Level ' . number_format($ir['level']));
        $cr = number_format($ir['money']) . ' Cr';

        $d = "";
        $u = $ir['username'];
        if ($ir['donatordays'])
        {
            $u = "<span style='color: red;'>{$ir['username']}</span>";
            $d =
                "<img src='donator.gif'
                     alt='Donator: {$ir['donatordays']} Days Left'
                     title='Donator: {$ir['donatordays']} Days Left' />";
        }

        $gn = "";

        echo <<<HTML
            <aside class="bg-slate-100 border-r border-slate-300 flex-none p-4 text-center text-slate-700 w-72">
                <div class="grid grid-cols-2">
                    <span class="text-left">Name</span>
                    <span class="text-right">$gn{$u} [{$ir['userid']}] $d</span>
                    <span class="text-left">Money</span>
                    <span class="text-right">{$cr}</span>
                    <span class="text-left">Diamonds</span>
                    <span class="text-right">{$ir['crystals']}</span>
                </div>
                
                <hr class="my-2" />
                
                <div class="bg-slate-200 h-2.5 mt-2"><span class="bg-red-500 h-2.5 block" style="width:{$ep}%"></span></div>
                <p class="flex items-center justify-between"><span>Energy</span><span>{$ef}</span></p>

                <div class="bg-slate-200 h-2.5 mt-2"><span class="bg-yellow-500 h-2.5 block" style="width:{$np}%"></span></div>
                <p class="flex items-center justify-between"><span>Nerve</span><span>{$nf}</span></p>

                <div class="bg-slate-200 h-2.5 mt-2"><span class="bg-green-500 h-2.5 block" style="width:{$hp}%"></span></div>
                <p class="flex items-center justify-between"><span>Health</span><span>{$hf}</span></p>

                <div class="bg-slate-200 h-2.5 mt-2"><span class="bg-blue-500 h-2.5 block" style="width:{$dp}%"></span></div>
                <p class="flex items-center justify-between"><span>Drive</span><span>{$df}</span></p>

                <div class="bg-slate-200 h-2.5 mt-2"><span class="bg-indigo-500 h-2.5 block" style="width:{$xp}%"></span></div>
                <p class="flex items-center justify-between"><span>Experience</span><span>{$xf}</span></p>
        HTML;
    }

    function menuarea()
    {
        global $ir, $set;

        require __DIR__ . '/mainmenu.php';

        echo <<<HTML
            </aside>
            <main class="bg-slate-50 flex-grow p-4 text-center">
        HTML;

        if ($ir['hospital']) {
            echo '<p>You are in hospital for another ' . number_format($ir['hospital']) . ' minute' . ($ir['hospital'] == 1 ? '' : 's') . '</p>';
        }
        elseif ($ir['jail']) {
            echo '<p>You are in jail for another ' . number_format($ir['jail']) . ' minute' . ($ir['jail'] == 1 ? '' : 's') . '</p>';
        }
        else {
            echo '<p><a href="/donate.php">Donate to Monolegacy</a></p>';
        }
    }


    function smenuarea()
    {
        define('jdsf45tji', true);
        include 'smenu.php';

        echo <<<HTML
            </aside>
            <main class="bg-slate-50 flex-grow p-4 text-center">
        HTML;
    }

    function endpage()
    {
        echo <<<HTML
                        </main>
                    </div>
                </div>
            </body>
            </html>     
        HTML;
    }
}
