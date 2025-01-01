<?php

require __DIR__ . '/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

if ($ir['jail'])
{
    echo "You cannot bail out people while in jail.";
    die($h->endpage());
}
$_GET['ID'] =
        (isset($_GET['ID']) && is_numeric($_GET['ID']))
                ? abs(intval($_GET['ID'])) : 0;
$jail_q =
        $db->query(
                "SELECT `userid`, `jail`, `level`, `username`
				 FROM `users`
				 WHERE `userid` = {$_GET['ID']}");
if ($db->num_rows($jail_q) == 0)
{
    $db->free_result($jail_q);
    echo "Invalid user";
    die($h->endpage());
}
$r = $db->fetch_row($jail_q);
$db->free_result($jail_q);
if (!$r['jail'])
{
    echo "That user is not in jail!";
    die($h->endpage());
}
$cost = $r['level'] * 2000;
$cf = money_formatter($cost);
if ($ir['money'] < $cost)
{
    echo "Sorry, you do not have enough money to bail out {$r['username']}."
            . " You need {$cf}.";
    die($h->endpage());
}

echo "You successfully bailed {$r['username']} out of jail for $cf.<br />
  &gt; <a href='jail.php'>Back</a>";
$db->query(
        "UPDATE `users`
		 SET `money` = `money` - {$cost}
		 WHERE `userid` = $userid");
$db->query(
        "UPDATE `users`
		 SET `jail` = 0
		 WHERE `userid` = {$r['userid']}");
addEvent($r['userid'],
        "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> bailed you out of jail.",
        $c);
$h->endpage();
