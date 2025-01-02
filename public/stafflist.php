<?php

require __DIR__ . '/../includes/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

$staff = array();
$q =
        $db->query(
                "SELECT `userid`, `laston`, `username`, `level`, `money`,
 				 `user_level`
 				 FROM `users`
 				 WHERE `user_level` IN(2, 3, 5)
 				 ORDER BY `userid` ASC");
while ($r = $db->fetch_row($q))
{
    $staff[$r['userid']] = $r;
}
$db->free_result($q);
echo '
<b>Admins</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" class="table">
		<tr>
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';

foreach ($staff as $r)
{
    if ($r['user_level'] == 2)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>

<b>Secretaries</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" class="table">
		<tr>
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';
foreach ($staff as $r)
{
    if ($r['user_level'] == 3)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>

<b>Assistants</b>
<br />
<table width="75%" cellspacing="1" cellpadding="1" class="table">
		<tr>
			<th>User</th>
			<th>Level</th>
			<th>Money</th>
			<th>Last Seen</th>
			<th>Status</th>
		</tr>
   ';
foreach ($staff as $r)
{
    if ($r['user_level'] == 5)
    {
        $on =
                ($r['laston'] >= ($_SERVER['REQUEST_TIME'] - 900))
                        ? '<span style="color: green;">Online</span>'
                        : '<span style="color: green;">Offline</span>';
        echo '
		<tr>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
                . $r['username'] . '</a> [' . $r['userid'] . ']</td>
			<td>' . $r['level'] . '</td>
			<td>' . money_formatter($r['money'], '$') . '</td>
			<td>' . date("F j, Y, g:i:s a", $r['laston']) . '</td>
			<td>' . $on . '</td>
		</tr>
   		';
    }
}
echo '</table>';
$h->endpage();
