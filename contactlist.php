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
 * File: contactlist.php
 * Signature: f14fdf95387b60a0cd8ccc28a4f3832c
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
echo '
<h3>My Contacts</h3>
<table width="85%" class="table" cellspacing="1">
		<tr>
	<td><a href="mailbox.php?action=inbox">Inbox</a></td>
	<td><a href="mailbox.php?action=outbox">Sent Messages</a></td>
	<td><a href="mailbox.php?action=compose">Compose Message</a></td>
	<td><a href="mailbox.php?action=delall">Delete All Messages</a></td>
	<td><a href="mailbox.php?action=archive">Archive Messages</a></td>
	<td><a href="contactlist.php">My Contacts</a></td>
		</tr>
</table>
<br />
   ';

switch ($_GET['action'])
{
case "add":
    add_contact();
    break;
case "remove":
    remove_contact();
    break;
default:
    contacts_list();
    break;
}

function contacts_list()
{
    global $db, $ir, $c, $userid;
    echo "
<a href='contactlist.php?action=add'>&gt; Add a Contact</a><br />
These are the people on your contact list.
<br />
<table width='90%' class='table' cellspacing='1'>
		<tr style='background:gray'>
	<th>ID</th>
	<th>Name</th>
	<th>Mail</th>
	<th>Remove</th>
		</tr>
   ";
    $q =
            $db->query(
                    "SELECT `cl`.`cl_ID`, `u`.`donatordays`, `username`, `userid`
                     FROM `contactlist` AS `cl`
                     LEFT JOIN `users` AS `u` ON `cl`.`cl_ADDED` = `u`.`userid`
                     WHERE `cl`.`cl_ADDER` = $userid
                     ORDER BY `u`.`username` ASC");
    while ($r = $db->fetch_row($q))
    {
        $d = '';
        if ($r['donatordays'])
        {
            $r['username'] = "<font color=red>{$r['username']}</font>";
            $d =
                    "<img src='donator.gif' alt='Donator: {$r['donatordays']} Days Left' title='Donator: {$r['donatordays']} Days Left' />";
        }
        echo '
		<tr>
	<td>' . $r['userid'] . '</td>
	<td><a href="viewuser.php?u=' . $r['userid'] . '">' . $r['username']
                . '</a> ' . $d
                . '</td>
	<td><a href="mailbox.php?action=compose&ID=' . $r['userid']
                . '">Mail</a></td>
	<td><a href="contactlist.php?action=remove&contact=' . $r['cl_ID']
                . '">Remove</a></td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function add_contact()
{
    global $db, $ir, $c, $userid;
    $_POST['ID'] =
            (isset($_POST['ID']) && is_numeric($_POST['ID']))
                    ? abs(intval($_POST['ID'])) : '';
    if ($_POST['ID'])
    {
        $qc =
                $db->query(
                        "SELECT COUNT(`cl_ADDER`) FROM `contactlist` WHERE `cl_ADDER` = $userid AND `cl_ADDED` = {$_POST['ID']}");
        $dupe_count = $db->fetch_single($qc);
        $db->free_result($qc);
        $q =
                $db->query(
                        "SELECT `username` FROM `users` WHERE `userid` = {$_POST['ID']}");
        if ($dupe_count > 0)
        {
            echo "You cannot add the same person twice.";
        }
        else if ($userid == $_POST['ID'])
        {
            echo "There is no point in adding yourself to your own list.";
        }
        else if ($db->num_rows($q) == 0)
        {
            $db->free_result($q);
            echo "Oh no, you're trying to add a ghost.";
        }
        else
        {
            $db->query(
                    "INSERT INTO `contactlist` VALUES(NULL, $userid, {$_POST['ID']})");
            $r = $db->fetch_row($q);
            $db->free_result($q);
            echo "{$r['username']} was added to your contact list.<br />
<a href='contactlist.php'>&gt; Back</a>";
        }
    }
    else
    {
        echo "
Adding a contact!
<form action='contactlist.php?action=add' method='post'>
	Contact's ID: <input type='text' name='ID' value='{$_GET['ID']}' />
	<br />
	<input type='submit' value='Add Contact' />
</form>
   ";
    }
}

function remove_contact()
{
    global $db, $ir, $c, $userid, $h;
    $_GET['contact'] =
            (isset($_GET['contact']) && is_numeric($_GET['contact']))
                    ? abs(intval($_GET['contact'])) : '';
    if (empty($_GET['contact']))
    {
        echo '
You didn\'t select a real contact.<br />
&gt; <a href="contactlist.php">Back</a>
   ';
        die($h->endpage());
    }
    $qc =
            $db->query(
                    "SELECT COUNT(`cl_ADDER`) FROM `contactlist` WHERE `cl_ADDER` = $userid AND `cl_ID` = {$_GET['contact']}");
    $exist_count = $db->fetch_single($qc);
    $db->free_result($qc);
    if ($exist_count == 0)
    {
        echo 'Listing doesn\'t exist.<br />&gt; <a href="contactlist.php">Go Back</a>';
        die($h->endpage());
    }
    $db->query(
            "DELETE FROM `contactlist` WHERE `cl_ID` = {$_GET['contact']} AND `cl_ADDER` = $userid");
    echo "
Contact removed from your list.<br />
&gt; <a href='contactlist.php'>Go Back</a>
   ";
}
$h->endpage();
