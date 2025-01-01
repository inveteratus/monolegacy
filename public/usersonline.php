<?php

require __DIR__ . '/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

echo '<h3>Users Online</h3>';
$cn = 0;
$expiry_time = time() - 900;
$q =
        $db->query(
                'SELECT `userid`, `username`, `laston`
                 FROM `users`
                 WHERE `laston` > ' . $expiry_time
                        . '
                 ORDER BY `laston` DESC');
while ($r = $db->fetch_row($q))
{
    $cn++;
    echo $cn . '. <a href="viewuser.php?u=' . $r['userid'] . '">'
            . $r['username'] . '</a> (' . DateTime_Parse($r['laston'])
            . ')
	<br />
   	';
}
$db->free_result($q);
$h->endpage();
