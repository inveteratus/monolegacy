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
 * File: staff_polls.php
 * Signature: e7064aaaec3bbd2ec4d879dc8f3ac30b
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('sglobals.php');
if ($ir['user_level'] != 2)
{
    echo 'You cannot access this area.<br />&gt; <a href="staff.php">Go Back</a>';
    die($h->endpage());
}
//This contains shop stuffs
if (!isset($_GET['action']))
{
    $_GET['action'] = '';
}
switch ($_GET['action'])
{
case 'spoll':
    startpoll();
    break;
case 'startpoll':
    startpollsub();
    break;
case 'endpoll':
    endpoll();
    break;
default:
    echo 'Error: This script requires an action.';
    break;
}

function startpoll()
{
    global $ir, $c, $userid, $db;
    $csrf = request_csrf_html('staff_startpoll');
    echo "
        Fill out question and choices to start a poll.
        <br />
        <form action='staff_polls.php?action=startpoll' method='post'>
        	Question: <input type='text' name='question' />
        	<br />
        	Choice 1: <input type='text' name='choice1' value='' />
        	<br />
        	Choice 2: <input type='text' name='choice2' value='' />
        	<br />
        	Choice 3: <input type='text' name='choice3' value='' />
        	<br />
        	Choice 4: <input type='text' name='choice4' value='' />
        	<br />
        	Choice 5: <input type='text' name='choice5' value='' />
        	<br />
        	Choice 6: <input type='text' name='choice6' value='' />
        	<br />
        	Choice 7: <input type='text' name='choice7' value='' />
        	<br />
        	Choice 8: <input type='text' name='choice8' value='' />
        	<br />
        	Choice 9: <input type='text' name='choice9' value='' />
        	<br />
        	Choice 10: <input type='text' name='choice10' value='' />
        	<br />
        	Results hidden till end:
        		<input type='radio' name='hidden' value='1' /> Yes
        		<input type='radio' name='hidden' value='0' checked='checked'> No
        	<br />
        	{$csrf}
        	<input type='submit' value='Submit' />
        </form>
           ";
}

function startpollsub()
{
    global $ir, $c, $userid, $db, $h;
    echo 'Starting new poll...';
    staff_csrf_stdverify('staff_startpoll', 'staff_polls.php?action=spoll');
    $question =
            (isset($_POST['question']))
                    ? $db->escape(strip_tags(stripslashes($_POST['question'])))
                    : '';
    $choice1 =
            (isset($_POST['choice1']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice1'])))
                    : '';
    $choice2 =
            (isset($_POST['choice2']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice2'])))
                    : '';
    $choice3 =
            (isset($_POST['choice3']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice3'])))
                    : '';
    $choice4 =
            (isset($_POST['choice4']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice4'])))
                    : '';
    $choice5 =
            (isset($_POST['choice5']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice5'])))
                    : '';
    $choice6 =
            (isset($_POST['choice6']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice6'])))
                    : '';
    $choice7 =
            (isset($_POST['choice7']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice7'])))
                    : '';
    $choice8 =
            (isset($_POST['choice8']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice8'])))
                    : '';
    $choice9 =
            (isset($_POST['choice9']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice9'])))
                    : '';
    $choice10 =
            (isset($_POST['choice10']))
                    ? $db->escape(strip_tags(stripslashes($_POST['choice10'])))
                    : '';
    if (empty($question) || empty($choice1) || empty($choice2))
    {
        echo 'You must input a question and atleast two answers.<br />
        &gt; <a href="staff_polls.php?action=spoll">Go Back</a>';
        die($h->endpage());
    }
    $poll =
            $db->query(
                    "INSERT INTO `polls`
                     (`active`, `question`, `choice1`, `choice2`, `choice3`,
                     `choice4`, `choice5`, `choice6`, `choice7`, `choice8`,
                     `choice9`, `choice10`, `hidden`)
                     VALUES('1', '$question', '$choice1', '$choice2',
                     '$choice3', '$choice4', '$choice5', '$choice6',
                     '$choice7', '$choice8', '$choice9' ,'$choice10',
                     '{$_POST['hidden']}')");
    echo 'New Poll Started.<br />
    &gt; <a href="staff.php">Go Home</a>';
    die($h->endpage());
}

function endpoll()
{
    global $ir, $c, $userid, $db, $h;
    $_POST['poll'] =
            (isset($_POST['poll']) && is_numeric($_POST['poll']))
                    ? abs(intval($_POST['poll'])) : '';
    if (empty($_POST['poll']))
    {
        $csrf = request_csrf_html('staff_endpoll');
        echo "
        Choose a poll to close
        <br />
        <form action='staff_polls.php?action=endpoll' method='post'>
           ";
        $q =
                $db->query(
                        "SELECT `id`, `question`
                         FROM `polls`
                         WHERE `active` = '1'");
        while ($r = $db->fetch_row($q))
        {
            echo '
					<input type="radio" name="poll" value="' . $r['id']
                    . '" /> Poll ID ' . $r['id'] . ' - ' . $r['question']
                    . '
					<br />
   			';
        }
        $db->free_result($q);
        echo $csrf
                . '
			<input type="submit" value="Close Selected Poll" />
		</form>
   		';
    }
    else
    {
        staff_csrf_stdverify('staff_endpoll', 'staff_polls.php?action=endpoll');
        $q =
                $db->query(
                        'SELECT COUNT(`id`)
                         FROM `polls`
                         WHERE `id` = ' . $_POST['poll']);
        if ($db->fetch_single($q) == 0)
        {
            $db->free_result($q);
            echo 'Invalid poll.<br />
            &gt; <a href="staff_polls.php?action=endpoll">Go Back</a>';
            die($h->endpage());
        }
        $db->free_result($q);
        $db->query(
                "UPDATE `polls`
                 SET `active` = '0'
                 WHERE `id` = {$_POST['poll']}");
        echo 'Poll closed.<br />
        &gt; <a href="staff.php">Go Home</a>';
        die($h->endpage());
    }
}
$h->endpage();
