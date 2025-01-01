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
 * File: preferences.php
 * Signature: 5ef365cacecc5a3f8601e964d414a315
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
if (!isset($_GET['action']))
{
    $_GET['action'] = '';
}

function csrf_error($goBackTo)
{
    global $h;
    echo '<h3>Error</h3><hr />
    Your change has been blocked for your security.<br />
    Please make profile changes quickly after you open the form - do not leave it open in tabs.<br />
    &gt; <a href="preferences.php?action=' . $goBackTo . '">Try Again</a>';
    $h->endpage();
    exit;
}
switch ($_GET['action'])
{
case 'sexchange2':
    do_sex_change();
    break;
case 'sexchange':
    conf_sex_change();
    break;
case 'passchange2':
    do_pass_change();
    break;
case 'passchange':
    pass_change();
    break;
case 'namechange2':
    do_name_change();
    break;
case 'namechange':
    name_change();
    break;
case 'picchange2':
    do_pic_change();
    break;
case 'picchange':
    pic_change();
    break;
case 'forumchange2':
    do_forum_change();
    break;
case 'forumchange':
    forum_change();
    break;
default:
    prefs_home();
    break;
}

function prefs_home()
{
    global $db, $ir, $c, $userid, $h;
    echo "
	<h3>Preferences</h3>
	<a href='preferences.php?action=sexchange'>Sex Change</a><br />
	<a href='preferences.php?action=passchange'>Password Change</a><br />
	<a href='preferences.php?action=namechange'>Name Change</a><br />
	<a href='preferences.php?action=picchange'>Display Pic Change</a><br />
	<a href='preferences.php?action=forumchange'>Forum Info Change</a><br />
   ";
}

function conf_sex_change()
{
    global $ir, $c, $userid, $h;
    $code = request_csrf_code('prefs_sexchange');
    if ($ir['gender'] == "Male")
    {
        $g = "Female";
    }
    else
    {
        $g = "Male";
    }
    echo "
	Are you sure you want to become a $g?
	<br />
	<a href='preferences.php?action=sexchange2&amp;verf={$code}'>Yes</a> | <a href='preferences.php'>No</a>
   	";
}

function do_sex_change()
{
    global $db, $ir, $c, $userid, $h;
    if (!isset($_GET['verf'])
            || !verify_csrf_code('prefs_sexchange',
                    stripslashes($_GET['verf'])))
    {
        csrf_error('sexchange');
    }
    $g = ($ir['gender'] == "Female") ? 'Male' : 'Female';
    $db->query(
            "UPDATE `users`
    		 SET `gender` = '$g'
    		 WHERE `userid` = $userid");
    echo "
	Success, you are now $g!<br />
	<a href='preferences.php'>Back</a>
   	";
}

function pass_change()
{
    global $ir, $c, $userid, $h;
    $code = request_csrf_code('prefs_passchange');
    echo "
	<h3>Password Change</h3>
	<form action='preferences.php?action=passchange2' method='post'>
    	Current Password: <input type='password' name='oldpw' /><br />
    	New Password: <input type='password' name='newpw' /><br />
    	Confirm: <input type='password' name='newpw2' /><br />
    	<input type='hidden' name='verf' value='{$code}' />
    	<input type='submit' value='Change PW' />
	</form>
   	";
}

function do_pass_change()
{
    global $db, $ir, $c, $userid, $h;
    if (!isset($_POST['verf'])
            || !verify_csrf_code('prefs_passchange',
                    stripslashes($_POST['verf'])))
    {
        csrf_error('passchange');
    }
    $oldpw = stripslashes($_POST['oldpw']);
    $newpw = stripslashes($_POST['newpw']);
    $newpw2 = stripslashes($_POST['newpw2']);
    if (!verify_user_password($oldpw, $ir['pass_salt'], $ir['userpass']))
    {
        echo "
		The current password you entered was wrong.<br />
		<a href='preferences.php?action=passchange'>&gt; Back</a>
   		";
    }
    else if ($newpw !== $newpw2)
    {
        echo "The new passwords you entered did not match!<br />
		<a href='preferences.php?action=passchange'>&gt; Back</a>";
    }
    else
    {
        // Re-encode password
        $new_psw = $db->escape(encode_password($newpw, $ir['pass_salt']));
        $db->query(
                "UPDATE `users`
                 SET `userpass` = '{$new_psw}'
                 WHERE `userid` = {$ir['userid']}");
        echo "Password changed!<br />
        &gt; <a href='preferences.php'>Go Back</a>";
    }
}

function name_change()
{
    global $ir, $c, $userid, $h;
    $code = request_csrf_code('prefs_namechange');
    echo "
	<h3>Name Change</h3>
	Please note that you still use the same name to login, this procedure simply changes the name that is displayed.
	<form action='preferences.php?action=namechange2' method='post'>
    	New Name: <input type='text' name='newname' />
    	<br />
        <input type='hidden' name='verf' value='{$code}' />
    	<input type='submit' value='Change Name' />
	</form>
   	";
}

function do_name_change()
{
    global $db, $ir, $c, $userid, $h;
    if (!isset($_POST['verf'])
            || !verify_csrf_code('prefs_namechange',
                    stripslashes($_POST['verf'])))
    {
        csrf_error('namechange');
    }
    $_POST['newname'] =
            (isset($_POST['newname']) && is_string($_POST['newname']))
                    ? stripslashes($_POST['newname']) : '';
    if (empty($_POST['newname']))
    {
        echo '
		You did not enter a new username.<br />
		&gt; <a href="preferences.php?action=namechange">Back</a>
   		';
        die($h->endpage());
    }
    elseif (((strlen($_POST['newname']) > 32)
            OR (strlen($_POST['newname']) < 3)))
    {
        echo '
		Usernames can only be a max of 32 characters or a min of 3 characters.<br />
		&gt; <a href="preferences.php?action=namechange">Back</a>
   		';
        die($h->endpage());
    }
    if (!preg_match("/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])+$/i",
            $_POST['newname']))
    {
        echo '
		Your username can only consist of Numbers, Letters, underscores and spaces.<br />
		&gt; <a href="preferences.php?action=namechange">Back</a>
   		';
        die($h->endpage());
    }
    $check_ex =
            $db->query(
                    'SELECT `userid`
                     FROM `users`
                     WHERE `username` = "' . $db->escape($_POST['newname'])
                            . '"');
    if ($db->num_rows($check_ex) > 0)
    {
        echo '
		This username is already in use.<br />
		&gt; <a href="preferences.php">Back</a>
   		';
        die($h->endpage());
    }
    $_POST['newname'] =
            $db->escape(
                    htmlentities($_POST['newname'], ENT_QUOTES, 'ISO-8859-1'));
    $db->query(
            "UPDATE `users`
             SET `username` = '{$_POST['newname']}'
             WHERE `userid` = $userid");
    echo "Username changed!";
}

function pic_change()
{
    global $ir, $c, $userid, $h;
    $code = request_csrf_code('prefs_picchange');
    echo "
	<h3>Pic Change</h3>
	Please note that this must be externally hosted,
		<a href='http://www.photobucket.com'>Photobucket</a> is our recommendation.
	<br />
	Any images that are not 150x150 will be automatically resized
	<form action='preferences.php?action=picchange2' method='post'>
    	New Pic: <input type='text' name='newpic' value='{$ir['display_pic']}' />
    	<input type='hidden' name='verf' value='{$code}' />
    	<br />
    	<input type='submit' value='Change Picture' />
	</form>
   	";
}

function do_pic_change()
{
    global $db, $ir, $c, $userid, $h;
    if (!isset($_POST['verf'])
            || !verify_csrf_code('prefs_picchange',
                    stripslashes($_POST['verf'])))
    {
        csrf_error('picchange');
    }
    $npic =
            (isset($_POST['newpic']) && is_string($_POST['newpic']))
                    ? stripslashes($_POST['newpic']) : '';
    if (!empty($npic))
    {
        if (strlen($npic) < 8
                || !(substr($npic, 0, 7) == 'http://'
                        || substr($npic, 0, 8 == 'https://')))
        {
            echo 'Invalid Image.<br />
        	&gt; <a href="preferences.php?action=picchange">Go Back</a>';
            die($h->endpage());
        }
        $sz = get_filesize_remote($npic);
        if ($sz <= 0 || $sz >= 1048576)
        {
            echo "Invalid new pic entered.<br />
            &gt; <a href='preferences.php?action=picchange'>Back</a>";
            $h->endpage();
            exit;
        }
        $image = (@getimagesize($npic));
        if (!is_array($image))
        {
            echo 'Invalid Image.<br />
        	&gt; <a href="preferences.php?action=picchange">Go Back</a>';
            die($h->endpage());
        }
    }
    echo htmlentities($_POST['newpic'], ENT_QUOTES, 'ISO-8859-1') . '<br />';
    $db->query(
            'UPDATE `users`
             SET `display_pic` = "' . $db->escape($npic)
                    . '"
             WHERE `userid` = ' . $userid);
    echo 'Pic changed!<br />
        &gt; <a href="index.php">Go Home</a>';
}

function forum_change()
{
    global $ir, $c, $userid, $h;
    $code = request_csrf_code('prefs_forumchange');
    echo "
	<h3>Forum Info Change</h3>
	Please note that the avatar must be externally hosted,
		<a href='http://www.photobucket.com'>Photobucket</a> is our recommendation.
		<br />
	Any avatars that are not 150x150 will be automatically resized
	<form action='preferences.php?action=forumchange2' method='post'>
    	Avatar: <input type='text' name='forums_avatar' value='{$ir['forums_avatar']}' />
    	<br />
    	Signature (you may use BBcode):
    		<textarea rows='10' cols='50' name='forums_signature'>{$ir['forums_signature']}</textarea>
    	<br />
        <input type='hidden' name='verf' value='{$code}' />
    	<input type='submit' value='Change Info' />
	</form>
   ";
}

function do_forum_change()
{
    global $db, $ir, $c, $userid, $h;
    if (!isset($_POST['verf'])
            || !verify_csrf_code('prefs_forumchange',
                    stripslashes($_POST['verf'])))
    {
        csrf_error('forumchange');
    }
    $av =
            (isset($_POST['forums_avatar'])
                    && is_string($_POST['forums_avatar']))
                    ? stripslashes($_POST['forums_avatar']) : '';
    if (!empty($av))
    {
        if (strlen($av) < 8
                || !(substr($av, 0, 7) == 'http://'
                        || substr($av, 0, 8 == 'https://')))
        {
            echo 'Invalid Image.<br />
        	&gt; <a href="preferences.php?action=forumchange">Go Back</a>';
            die($h->endpage());
        }
        $sz = get_filesize_remote($av);
        if ($sz <= 0 || $sz >= 1048576)
        {
            echo "Invalid new pic entered.<br />
            &gt; <a href='preferences.php?action=picchange'>Back</a>";
            $h->endpage();
            exit;
        }
        $image = (@getimagesize($av));
        if (!is_array($image))
        {
            echo 'Invalid Image.<br />
        	&gt; <a href="preferences.php?action=forumchange">Go Back</a>';
            die($h->endpage());
        }
    }

    $_POST['forums_signature'] =
            $db->escape(strip_tags(stripslashes($_POST['forums_signature'])));
    if (strlen($_POST['forums_signature']) > 250)
    {
        echo 'You may only have a forums signature consisting of 250 characters or less.
        <br />&gt; <a href="preferences.php?action=forumchange">Go Back</a>';
        die($h->endpage());
    }
    $db->query(
            "UPDATE `users`
             SET `forums_avatar` = '" . $db->escape($av)
                    . "',
             `forums_signature` = '{$_POST['forums_signature']}'
             WHERE `userid` = $userid");
    echo 'Forum Info changed!<br />
    &gt; <a href="index.php">Go Home</a>';
}
$h->endpage();
