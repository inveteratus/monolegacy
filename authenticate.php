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
 * File: authenticate.php
 * Signature: 9ebc026043b2177b1f0c4750da2ca558
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals_nonauth.php');
// Check CSRF input
if (!isset($_POST['verf'])
        || !verify_csrf_code('login', stripslashes($_POST['verf'])))
{
    die(
            "<h3>{$set['game_name']} Error</h3>
Your request has expired for security reasons! Please try again.<br />
<a href='login.php'>&gt; Back</a>");
}
// Check username and password input
$username =
        (array_key_exists('username', $_POST) && is_string($_POST['username']))
                ? $_POST['username'] : '';
$password =
        (array_key_exists('password', $_POST) && is_string($_POST['password']))
                ? $_POST['password'] : '';
if (empty($username) || empty($password))
{
    die(
            "<h3>{$set['game_name']} Error</h3>
	You did not fill in the login form!<br />
	<a href='login.php'>&gt; Back</a>");
}
$form_username = $db->escape(stripslashes($username));
$raw_password = stripslashes($password);
$uq =
        $db->query(
                "SELECT `userid`, `userpass`, `pass_salt`
                 FROM `users`
                 WHERE `login_name` = '$form_username'");
if ($db->num_rows($uq) == 0)
{
    $db->free_result($uq);
    die(
            "<h3>{$set['game_name']} Error</h3>
	Invalid username or password!<br />
	<a href='login.php'>&gt; Back</a>");
}
else
{
    $mem = $db->fetch_row($uq);
    $db->free_result($uq);
    $login_failed = false;
    // Pass Salt generation: autofix
    if (empty($mem['pass_salt']))
    {
        if (md5($raw_password) != $mem['userpass'])
        {
            $login_failed = true;
        }
        $salt = generate_pass_salt();
        $enc_psw = encode_password($mem['userpass'], $salt, true);
        $e_salt = $db->escape($salt); // in case of changed salt function
        $e_encpsw = $db->escape($enc_psw); // ditto for password encoder
        $db->query(
                "UPDATE `users`
        		 SET `pass_salt` = '{$e_salt}', `userpass` = '{$e_encpsw}'
        		 WHERE `userid` = {$mem['userid']}");
    }
    else
    {
        $login_failed =
                !(verify_user_password($raw_password, $mem['pass_salt'],
                        $mem['userpass']));
    }
    if ($login_failed)
    {
        die(
                "<h3>{$set['game_name']} Error</h3>
		Invalid username or password!<br />
		<a href='login.php'>&gt; Back</a>");
    }
    session_regenerate_id();
    $_SESSION['loggedin'] = 1;
    $_SESSION['userid'] = $mem['userid'];
    $IP = $db->escape($_SERVER['REMOTE_ADDR']);
    $db->query(
            "UPDATE `users`
             SET `lastip_login` = '$IP', `last_login` = "
                    . $_SERVER['REQUEST_TIME']
                    . "
             WHERE `userid` = {$mem['userid']}");
    if ($set['validate_period'] == "login" && $set['validate_on'])
    {
        $db->query(
                "UPDATE `users`
                 SET `verified` = 0
                 WHERE `userid` = {$mem['userid']}");
    }
    $loggedin_url = 'http://' . determine_game_urlbase() . '/loggedin.php';
    header("Location: {$loggedin_url}");
    exit;
}

