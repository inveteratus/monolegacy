<?php

class headers
{
    function startheaders()
    {
        global $ir, $set;
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
                    <img src="title.jpg" class="w-full" alt="Monolegacy" />
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
        $enperc = min((int) ($ir['energy'] / $ir['maxenergy'] * 100), 100);
        $wiperc = min((int) ($ir['will'] / $ir['maxwill'] * 100), 100);
        $experc = min((int) ($ir['exp'] / $ir['exp_needed'] * 100), 100);
        $brperc = min((int) ($ir['brave'] / $ir['maxbrave'] * 100), 100);
        $hpperc = min((int) ($ir['hp'] / $ir['maxhp'] * 100), 100);
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
            <aside class="bg-slate-100 border-r border-slate-300 flex-none p-4 text-center w-72">
                <b>Name:</b> $gn{$u} [{$ir['userid']}] $d<br />
                <b>Money:</b> {$fm}<br />
                <b>Level:</b> {$ir['level']}<br />
                <b>Crystals:</b> {$ir['crystals']}<br />
                [<a href='logout.php'>Emergency Logout</a>]
                <hr />
                <b>Energy:</b> {$enperc}%<br />
                <div class="bg-slate-200 h-2.5 mx-3"><span class="bg-red-500 h-2.5 block" style="width:{$enperc}%"></span></div>
                <b>Will:</b> {$wiperc}%<br />
                <div class="bg-slate-200 h-2.5 mx-3"><span class="bg-blue-500 h-2.5 block" style="width:{$wiperc}%"></span></div>
                <b>Brave:</b> {$ir['brave']}/{$ir['maxbrave']}<br />
                <div class="bg-slate-200 h-2.5 mx-3"><span class="bg-yellow-500 h-2.5 block" style="width:{$brperc}%"></span></div>
                <b>EXP:</b> {$experc}%<br />
                <div class="bg-slate-200 h-2.5 mx-3"><span class="bg-indigo-500 h-2.5 block" style="width:{$experc}%"></span></div>
                <b>Health:</b> {$hpperc}%<br />
                <div class="bg-slate-200 h-2.5 mx-3"><span class="bg-green-500 h-2.5 block" style="width:{$hpperc}%"></span></div>
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
