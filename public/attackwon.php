<?php
/**
 * MCCodes Version 2.0.5b
 * Copyright (C) 2005-2012 Dabomstew
 * All rights reserved.
 *
 * Redistribution of this code in any form is prohibited, except in
 * the specific cases set out in the MCCodes Customer License.
 *
 * This code license may be used to run one (1) game.
 * A game is defined as the set of users and other game database data,
 * so you are permitted to create alternative clients for your game.
 *
 * If you did not obtain this code from MCCodes.com, you are in all likelihood
 * using it illegally. Please contact MCCodes to discuss licensing options
 * in this case.
 *
 * File: attackwon.php
 * Signature: 5c075e11830adc5e0c417d7133201428
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

$atkpage = 1;
require_once('globals.php');
$_GET['ID'] =
        (isset($_GET['ID']) && is_numeric($_GET['ID']))
                ? abs((int) $_GET['ID']) : 0;
$_SESSION['attacking'] = 0;
$ir['attacking'] = 0;
$db->query("UPDATE `users` SET `attacking` = 0 WHERE `userid` = $userid");
$od =
        $db->query(
                "SELECT * FROM `users` WHERE `userid` = {$_GET['ID']}");
if (!isset($_SESSION['attackwon']) || $_SESSION['attackwon'] != $_GET['ID'])
{
    die("Cheaters don't get anywhere.");
}
if ($db->num_rows($od) > 0)
{
    $r = $db->fetch_row($od);
    $db->free_result($od);
    if ($r['hp'] == 1)
    {
        echo "What a cheater you are.";
    }
    else
    {
        $stole = round($r['money'] / (rand(200, 5000) / 10));
        echo "You beat {$r['username']}!!<br />
		You knock {$r['username']} on the floor a few times to make sure he is unconscious, "
                . "then open his wallet, snatch " . money_formatter($stole)
                . ", and run home happily.";
        $hosptime = rand(20, 40) + floor($ir['level'] / 8);
        $expgain = 0;
        $db->query(
                "UPDATE `users` SET `exp` = `exp` + $expgain, `money` = `money` + $stole WHERE `userid` = $userid");
        $hospreason =
                $db->escape(
                        "Mugged by <a href='viewuser.php?u={$userid}'>{$ir['username']}</a>");
        $db->query(
                "UPDATE `users`
                        SET `hp` = 1, `money` = `money` - $stole, `hospital` = $hosptime,
                        `hospreason` = '{$hospreason}' WHERE `userid` = {$r['userid']}");
        event_add($r['userid'],
                "<a href='viewuser.php?u=$userid'>{$ir['username']}</a> mugged you and stole "
                        . money_formatter($stole) . ".", $c);
        $atklog = $db->escape($_SESSION['attacklog']);
        $db->query(
                "INSERT INTO `attacklogs` VALUES(NULL, $userid, {$_GET['ID']},
                        'won', " . time() . ", $stole, '$atklog')");
        $_SESSION['attackwon'] = 0;
        if ($ir['gang'] > 0 && $r['gang'] > 0)
        {
            $gq =
                    $db->query(
                            "SELECT `gangRESPECT`, `gangID` FROM `gangs` WHERE `gangID` = {$r['gang']}");
            if ($db->num_rows($gq) > 0)
            {
                $ga = $db->fetch_row($gq);
                $warq =
                        $db->query(
                                "SELECT COUNT(`warDECLARER`) FROM `gangwars`
                                    WHERE (`warDECLARER` = {$ir['gang']} AND `warDECLARED` = {$r['gang']})
                                    OR (`warDECLARED` = {$ir['gang']} AND `warDECLARER` = {$r['gang']})");
                if ($db->fetch_single($warq) > 0)
                {
                    $db->query(
                            "UPDATE `gangs` SET `gangRESPECT` = `gangRESPECT` - 2 WHERE `gangID` = {$r['gang']}");
                    $ga['gangRESPECT'] -= 2;
                    $db->query(
                            "UPDATE `gangs` SET `gangRESPECT` = `gangRESPECT` + 2 WHERE `gangID` = {$ir['gang']}");
                    echo "<br />You earnt 2 respect for your gang!";

                }
                $db->free_result($warq);
                //Gang Kill
                if ($ga['gangRESPECT'] <= 0 && $r['gang'])
                {
                    $db->query(
                            "UPDATE `users` SET `gang` = 0 WHERE `gang` = {$r['gang']}");

                    $db->query("DELETE FROM `gangs` WHERE `gangRESPECT` <= 0");
                    $db->query(
                            "DELETE FROM `gangwars`
                                    WHERE `warDECLARER` = {$ga['gangID']} OR `warDECLARED` = {$ga['gangID']}");
                }
            }
            $db->free_result($gq);
        }

        if ($r['user_level'] == 0)
        {
            $q =
                    $db->query(
                            "SELECT `cb_money` FROM `challengebots` WHERE `cb_npcid` = {$r['userid']}");
            if ($db->num_rows($q) > 0)
            {
                $cb = $db->fetch_row($q);
                $qk =
                        $db->query(
                                "SELECT COUNT(`npcid`) FROM `challengesbeaten`
                                        WHERE `userid` = $userid AND `npcid` = {$r['userid']}");
                if ($db->fetch_single($qk) > 0)
                {
                    $m = $cb['cb_money'];
                    $db->query(
                            "UPDATE `users` SET `money` = `money` + $m WHERE `userid` = $userid");
                    echo "<br /> You gained " . money_formatter($m)
                            . " for beating the challenge bot {$r['username']}";
                    $db->query(
                            "INSERT INTO `challengesbeaten` VALUES($userid, {$r['userid']})");
                }
                $db->free_result($qk);
            }
            $db->free_result($q);
        }

    }
}
else
{
    $db->free_result($od);
    echo "You beat Mr. non-existant! Haha, pwned!";
}
$h->endpage();
