<?php

require __DIR__ . '/sglobals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

if (in_array($ir['user_level'], array(2, 3, 5)))
{
    $_POST['ID'] =
            (isset($_POST['ID']) && is_numeric($_POST['ID']))
                    ? abs(intval($_POST['ID'])) : '';
    $_POST['staffnotes'] =
            (isset($_POST['staffnotes']) && !is_array($_POST['staffnotes']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['staffnotes'])))
                    : '';
    if (empty($_POST['ID']) || empty($_POST['staffnotes']))
    {
        echo 'You must enter data for this to work.
        <br />&gt; <a href="index.php">Go Home</a>';
        die($h->endpage());
    }
    $q =
            $db->query(
                    "SELECT `staffnotes`
    				 FROM `users`
    				 WHERE `userid` = {$_POST['ID']}");
    if ($db->num_rows($q) == 0)
    {
        $db->free_result($q);
        echo 'That user does not exist.
        <br />&gt; <a href="index.php">Go Home</a>';
        die($h->endpage());
    }
    $old = $db->escape($db->fetch_single($q));
    $db->free_result($q);
    $db->query(
            "UPDATE `users`
             SET `staffnotes` = '{$_POST['staffnotes']}'
             WHERE `userid` = '{$_POST['ID']}'");
    $db->query(
            "INSERT INTO `staffnotelogs`
             VALUES (NULL, $userid, {$_POST['ID']}, " . time()
                    . ", '$old',
              '{$_POST['staffnotes']}')");
    echo '
	User notes updated!
	<br />
	&gt; <a href="viewuser.php?u=' . $_POST['ID']
            . '">Back To Profile</a>
  	 ';
}
else
{
    echo 'You cannot access this file.
    <br />&gt; <a href="index.php">Go Home</a>';
}
$h->endpage();
