<?php

class headers
{

    function startheaders()
    {
        global $ir, $set;
        echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/game.css" type="text/css" rel="stylesheet" />
<title>{$set['game_name']}</title>
</head>
<body>
<center>
<table width="970" border="0" cellpadding="0" cellspacing="0" class="table2">
<tr>
<td class="lgrad"></td>
<td class="center">
EOF;
    }

    function userdata($ir, $lv, $fm, $cm, $dosessh = 1)
    {
        global $db, $c, $userid, $set;
        $IP = $db->escape($_SERVER['REMOTE_ADDR']);
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
        $enopp = 100 - $enperc;
        $wiopp = 100 - $wiperc;
        $exopp = 100 - $experc;
        $bropp = 100 - $brperc;
        $hpopp = 100 - $hpperc;
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
        global $staffpage;

        $bgcolor = 'FFFFFF';

        print 
                <<<OUT
<img src="title.jpg" alt="Mccodes Version 2" /><br />
<!-- Begin Main Content -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="20%" bgcolor="#$bgcolor" valign="top">
<!-- Side Panel -->
<b>Name:</b> $gn{$u} [{$ir['userid']}] $d<br />
<b>Money:</b> {$fm}<br />
<b>Level:</b> {$ir['level']}<br />
<b>Crystals:</b> {$ir['crystals']}<br />
[<a href='logout.php'>Emergency Logout</a>]
<hr />
<b>Energy:</b> {$enperc}%<br />
<img src='greenbar.png' width='$enperc' height='10' /><img src='redbar.png' width='$enopp' height='10' /><br />
<b>Will:</b> {$wiperc}%<br />
<img src='bluebar.png' width='$wiperc' height='10' /><img src='redbar.png' width='$wiopp' height='10' /><br />
<b>Brave:</b> {$ir['brave']}/{$ir['maxbrave']}<br />
<img src='yellowbar.png' width='$brperc' height='10' /><img src='redbar.png' width='$bropp' height='10' /><br />
<b>EXP:</b> {$experc}%<br />
<img src='navybar.png' width='$experc' height='10' /><img src='redbar.png' width='$exopp' height='10' /><br />
<b>Health:</b> {$hpperc}%<br />
<img src='greenbar.png' width='$hpperc' height='10' /><img src='redbar.png' width='$hpopp' height='10' /><br /><hr />
<!-- Links -->
OUT;
        if ($ir['fedjail'] > 0)
        {
            $q =
                    $db->query(
                            "SELECT *
                             FROM `fedjail`
                             WHERE `fed_userid` = $userid");
            $r = $db->fetch_row($q);
            die(
                    "<span style='font-weight: bold; color:red;'>
                    You have been put in the {$set['game_name']} Federal Jail
                     for {$r['fed_days']} day(s).<br />
                    Reason: {$r['fed_reason']}
                    </span></body></html>");
        }
        if (file_exists('ipbans/' . $IP))
        {
            die(
                    "<span style='font-weight: bold; color:red;'>
                    Your IP has been banned from {$set['game_name']},
                     there is no way around this.
                    </span></body></html>");
        }
    }

    function menuarea()
    {
        define('jdsf45tji', true);
        require __DIR__ . '/mainmenu.php';
        global $ir, $c;
        $bgcolor = 'FFFFFF';
        print 
                '</td><td width="2" class="linegrad" bgcolor="#' . $bgcolor
                        . '">&nbsp;</td><td width="80%"  bgcolor="#'
                        . $bgcolor . '" valign="top"><br /><center>';
        if ($ir['hospital'])
        {
            echo "<b>NB:</b> You are currently in hospital for {$ir['hospital']} minutes.<br />";
        }
        if ($ir['jail'])
        {
            echo "<b>NB:</b> You are currently in jail for {$ir['jail']} minutes.<br />";
        }
        echo "<a href='donator.php'><b>Donate to {$set['game_name']} now for game benefits!</b></a><br />";
    }

    function smenuarea()
    {
        define('jdsf45tji', true);
        require __DIR__ . '/smenu.php';
        global $ir, $c;
        $bgcolor = 'FFFFFF';
        print 
                '</td><td width="2" class="linegrad" bgcolor="#' . $bgcolor
                        . '">&nbsp;</td><td width="80%"  bgcolor="#'
                        . $bgcolor . '" valign="top"><center>';
    }

    function endpage()
    {
        print
                <<<OUT
</center>
</td>
</tr>
</table></td>
<td class="rgrad"></td>
</tr>
<tr>
<td colspan="3">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td class="dgradl">&nbsp;</td>
<td class="dgrad">&nbsp;</td>
<td class="dgradr">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
OUT;
    }
}
