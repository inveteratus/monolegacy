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
 * File: sendbank.php
 * Signature: 51f5df6ce0286687d43402ace9a6a055
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
if (!$set['sendbank_on'])
{
    die("Sorry, the game owner has disabled this feature.");
}
if (!isset($_GET['ID']))
{
    $_GET['ID'] = 0;
}
if (!isset($_POST['xfer']))
{
    $_POST['xfer'] = 0;
}
$_GET['ID'] = abs((int) $_GET['ID']);
$_POST['xfer'] = abs((int) $_POST['xfer']);
if (!((int) $_GET['ID']))
{
    echo "Invalid User ID";
}
else if ($_GET['ID'] == $userid)
{
    echo "Haha, what does sending money to yourself do anyway?";
}
else
{
    $it =
            $db->query(
                    "SELECT `bankmoney`, `lastip`, `username`
                     FROM `users`
                     WHERE `userid` = {$_GET['ID']}");
    if ($db->num_rows($it) == 0)
    {
        $db->free_result($it);
        echo "That user doesn't exist.";
        $h->endpage();
        exit;
    }
    $er = $db->fetch_row($it);
    $db->free_result($it);
    if ($er['bankmoney'] == -1 || $ir['bankmoney'] == -1)
    {
        die(
                "Sorry,you or the person you are sending to does not have a bank account.");
    }
    if ((int) $_POST['xfer'])
    {
        if (!isset($_POST['verf'])
                || !verify_csrf_code("sendbank_{$_GET['ID']}",
                        stripslashes($_POST['verf'])))
        {
            echo '<h3>Error</h3><hr />
    		This transaction has been blocked for your security.<br />
    		Please send money quickly after you open the form - do not leave it open in tabs.<br />
    		&gt; <a href="sendbank.php?ID=' . $_GET['ID'] . '">Try Again</a>';
            die($h->endpage());
        }
        else if ($_POST['xfer'] > $ir['bankmoney'])
        {
            echo "Not enough money to send.";
        }
        else
        {
            $db->query(
                    "UPDATE `users`
                     SET `bankmoney` = `bankmoney` - {$_POST['xfer']}
                     WHERE `userid` = $userid");
            $db->query(
                    "UPDATE `users`
                     SET `bankmoney` = `bankmoney` + {$_POST['xfer']}
                     WHERE `userid` = {$_GET['ID']}");
            echo "You Bank Transferred " . money_formatter($_POST['xfer'])
                    . " to {$er['username']} (ID {$_GET['ID']}).";
            event_add($_GET['ID'],
                    "You received " . money_formatter($_POST['xfer'])
                            . " into your bank account from {$ir['username']}.",
                    $c);

            $db->query(
                    "INSERT INTO `bankxferlogs`
                     VALUES (NULL, $userid, {$_GET['ID']},
                     {$_POST['xfer']}, " . time()
                            . ", '{$ir['lastip']}',
                     '{$er['lastip']}', 'bank')");
        }
    }
    else
    {
        $code = request_csrf_code("sendbank_{$_GET['ID']}");
        echo "<h3>Bank Xfer</h3>
		You are sending bank money to <b>{$er['username']}</b> (ID {$_GET['ID']}).
		<br />You have <b>" . money_formatter($ir['bankmoney'])
                . "</b> you can send.
		<form action='sendbank.php?ID={$_GET['ID']}' method='post'>
			Money: <input type='text' name='xfer' /><br />
			<input type='hidden' name='verf' value='{$code}' />
			<input type='submit' value='Send' />
		</form>";
    }
}
$h->endpage();
