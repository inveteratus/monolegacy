<?php

require __DIR__ . '/../includes/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

if ($ir['energy'] < 10)
{
    echo "Sorry, it costs 10 energy to bust someone. "
            . "You only have {$ir['energy']} energy. " . "Come back later.";
    die($h->endpage());
}
if ($ir['jail'])
{
    echo "You cannot bust out people while in jail.";
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
$mult = $r['level'] * $r['level'];
$chance = min(($ir['crimexp'] / $mult) * 50 + 1, 95);
if (rand(1, 100) < $chance)
{
    $gain = $r['level'] * 5;
    echo "You successfully busted {$r['username']} out of jail.<br />
  	&gt; <a href='jail.php'>Back</a>";
    $db->query(
            "UPDATE `users`
    		 SET `crimexp` = `crimexp` + {$gain}, `energy` = `energy` - 10
    		 WHERE `userid` = $userid");
    $db->query(
            "UPDATE `users`
    		 SET `jail` = 0
    		 WHERE `userid` = {$r['userid']}");
    addEvent($r['userid'],
            "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> busted you out of jail.",
            $c);
}
else
{
    echo "While trying to bust out your friend, a guard spotted you and dragged you into jail yourself. Unlucky!<br />
  	&gt; <a href='jail.php'>Back</a>";
    $time = min($mult, 100);
    $jail_reason = $db->escape("Caught trying to bust out {$r['username']}");
    $db->query(
            "UPDATE `users`
             SET `jail` = $time, `jail_reason` = '{$jail_reason}',
             `energy` = `energy` - 10
             WHERE `userid` = $userid");
    addEvent($r['userid'],
            "<a href='viewuser.php?u={$ir['userid']}'>{$ir['username']}</a> was caught trying to bust you out of jail.",
            $c);
}
$h->endpage();
