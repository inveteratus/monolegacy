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
 * File: docrime.php
 * Signature: 427d116f8a7253197c4364dd543771e6
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

if (!isset($_GET['c']))
{
    $_GET['c'] = 0;
}
$_GET['c'] = abs((int) $_GET['c']);
$macropage = "docrime.php?c={$_GET['c']}";
require_once('globals.php');
if ($ir['jail'] > 0 || $ir['hospital'] > 0)
{
    die("This page cannot be accessed while in jail or hospital.");
}
if ($_GET['c'] <= 0)
{
    echo "Invalid crime";
}
else
{
    $q =
            $db->query(
                    "SELECT *
    				 FROM `crimes`
    				 WHERE `crimeID` = {$_GET['c']}
    				 LIMIT 1");
    if ($db->num_rows($q) == 0)
    {
        echo 'Invalid crime.';
        $h->endpage();
        exit;
    }
    $r = $db->fetch_row($q);
    $db->free_result($q);
    if ($ir['brave'] < $r['crimeBRAVE'])
    {
        echo "You do not have enough Brave to perform this crime.";
    }
    else
    {
        $ec =
                "\$sucrate="
                        . str_replace(
                                array("LEVEL", "CRIMEXP", "EXP", "WILL", "IQ"),
                                array($ir['level'], $ir['crimexp'],
                                        $ir['exp'], $ir['will'], $ir['IQ']),
                                $r['crimePERCFORM']) . ";";
        eval($ec);
        print $r['crimeITEXT'];
        $ir['brave'] -= $r['crimeBRAVE'];
        $db->query(
                "UPDATE `users`
                 SET `brave` = {$ir['brave']}
                 WHERE `userid` = $userid");
        if (rand(1, 100) <= $sucrate)
        {
            print
                    str_replace("{money}", $r['crimeSUCCESSMUNY'],
                            $r['crimeSTEXT']);
            $ir['money'] += $r['crimeSUCCESSMUNY'];
            $ir['crystals'] += $r['crimeSUCCESSCRYS'];
            $ir['exp'] += (int) ($r['crimeSUCCESSMUNY'] / 8);
            $db->query(
                    "UPDATE `users`
                    SET `money` = {$ir['money']},
                    `crystals` = {$ir['crystals']}, `exp` = {$ir['exp']},
                    `crimexp` = `crimexp` + {$r['crimeXP']}
                    WHERE `userid` = $userid", $c);
            if ($r['crimeSUCCESSITEM'])
            {
                item_add($userid, $r['crimeSUCCESSITEM'], 1);
            }
        }
        else
        {
            if (rand(1, 2) == 1)
            {
                print $r['crimeFTEXT'];
            }
            else
            {
                print $r['crimeJTEXT'];
                $db->query(
                        "UPDATE `users`
                        SET `jail` = '{$r['crimeJAILTIME']}',
                        `jail_reason` = '{$r['crimeJREASON']}'
                        WHERE `userid` = $userid");
            }
        }

        echo "<br /><a href='docrime.php?c={$_GET['c']}'>Try Again</a><br />
<a href='criminal.php'>Crimes</a>";
    }
}

$h->endpage();
