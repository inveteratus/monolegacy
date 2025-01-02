<?php

require __DIR__ . '/../includes/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

if (!in_array($ir['user_level'], array(2, 3, 5)))
{
    echo 'You cannot access this area.<br />
    &gt; <a href="index.php">Go Home</a>';
    die($h->endpage());
}
$_POST['user'] =
        (isset($_POST['user']) && is_numeric($_POST['user']))
                ? abs(intval($_POST['user'])) : '';
$_POST['reason'] =
        (isset($_POST['reason'])
                && ((strlen($_POST['reason']) > 3)
                        && (strlen($_POST['reason']) < 50)))
                ? $db->escape(strip_tags(stripslashes($_POST['reason']))) : '';
$_POST['days'] =
        (isset($_POST['days']) && is_numeric($_POST['days']))
                ? abs(intval($_POST['days'])) : '';
if (!empty($_POST['user']) && !empty($_POST['reason'])
        && !empty($_POST['days']))
{
    if (!isset($_POST['verf'])
            || !verify_csrf_code('jailuser', stripslashes($_POST['verf'])))
    {
        echo '<h3>Error</h3><hr />
   			This operation has been blocked for your security.<br />
    		Please try again.<br />
    		&gt; <a href="jailuser.php?userid=' . $_POST['user']
                . '">Try Again</a>';
        die($h->endpage());
    }
    $q =
            $db->query(
                    'SELECT `user_level`
                     FROM `users`
                     WHERE `userid` = ' . $_POST['user']);
    if ($db->num_rows($q) == 0)
    {
        $db->free_result($q);
        echo 'Invalid user.<br />&gt; <a href="jailuser.php">Go Back</a>';
        die($h->endpage());
    }
    $f_q = $db->fetch_row($q);
    $db->free_result($q);
    if ($f_q['user_level'] == 2)
    {
        echo 'You cannot fed admins, please destaff them first.
        <br />&gt; <a href="jailuser.php">Go Back</a>';
        die($h->endpage());
    }
    $db->query(
            "UPDATE `users`
             SET `fedjail` = 1
             WHERE `userid` = {$_POST['user']}");
    $db->query(
            "INSERT INTO `fedjail`
             VALUES(NULL, {$_POST['user']}, {$_POST['days']}, $userid,
             '{$_POST['reason']}')");
    $db->query(
            "INSERT INTO `jaillogs`
             VALUES(NULL, $userid, {$_POST['user']}, {$_POST['days']},
             '{$_POST['reason']}', " . time() . ")");
    echo 'User was fedded.<br />
    &gt; <a href="index.php">Go Home</a>';
}
else
{
    $jail_csrf = request_csrf_code('jailuser');
    $_GET['userid'] =
            (isset($_GET['userid']) && is_numeric($_GET['userid']))
                    ? abs(intval($_GET['userid'])) : -1;
    echo "
	<h3>Jailing User</h3>
	The user will be put in fed jail and will be unable to do anything in the game.
	<br />
	<form action='jailuser.php' method='post'>
		User: " . user_dropdown(NULL, 'user', $_GET['userid'])
            . "
		<br />
		Days: <input type='text' name='days' />
		<br />
		Reason: <input type='text' name='reason' />
		<br />
		<input type='hidden' name='verf' value='{$jail_csrf}' />
		<input type='submit' value='Jail User' />
	</form>
   	";
}
$h->endpage();
