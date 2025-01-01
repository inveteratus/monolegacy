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
 * File: userlist.php
 * Signature: 59391462203b4bded53a86b1304f407e
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
$st =
        (isset($_GET['st']) && is_numeric($_GET['st']))
                ? abs(intval($_GET['st'])) : 0;
$allowed_by = array('userid', 'username', 'level', 'money');
$by =
        (isset($_GET['by']) && in_array($_GET['by'], $allowed_by, true))
                ? $_GET['by'] : 'userid';
$allowed_ord = array('asc', 'desc', 'ASC', 'DESC');
$ord =
        (isset($_GET['ord']) && in_array($_GET['ord'], $allowed_ord, true))
                ? $_GET['ord'] : 'ASC';
echo "<h3>Userlist</h3>";
$cnt = $db->query("SELECT COUNT(`userid`)
				   FROM `users`");
$membs = $db->fetch_single($cnt);
$db->free_result($cnt);
$pages = (int) ($membs / 100) + 1;
if ($membs % 100 == 0)
{
    $pages--;
}
echo "Pages: ";
for ($i = 1; $i <= $pages; $i++)
{
    $stl = ($i - 1) * 100;
    echo "<a href='userlist.php?st=$stl&amp;by=$by&amp;ord=$ord'>$i</a>&nbsp;";
}
echo "<br />
Order By:
	<a href='userlist.php?st=$st&by=userid&ord=$ord'>User ID</a>&nbsp;|
	<a href='userlist.php?st=$st&by=username&ord=$ord'>Username</a>&nbsp;|
	<a href='userlist.php?st=$st&by=level&ord=$ord'>Level</a>&nbsp;|
	<a href='userlist.php?st=$st&by=money&ord=$ord'>Money</a>
<br />
<a href='userlist.php?st=$st&by=$by&ord=asc'>Ascending</a>&nbsp;|
<a href='userlist.php?st=$st&by=$by&ord=desc'>Descending</a>
<br /><br />";
$q =
        $db->query(
                "SELECT `donatordays`, `username`, `userid`, `money`, `level`,
                `gender`, `gangPREF`, `laston`
                FROM `users` AS `u`
                LEFT JOIN `gangs` AS `g`
                ON `u`.`gang` = `g`.`gangID`
                ORDER BY `$by` $ord
                LIMIT $st, 100");
$no1 = $st + 1;
$no2 = min($st + 100, $membs);
echo "
Showing users $no1 to $no2 by order of $by $ord.
<table width='75%' cellspacing='1' cellpadding='1' class='table'>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Money</th>
			<th>Level</th>
			<th>Gender</th>
			<th>Online</th>
		</tr>
   ";
while ($r = $db->fetch_row($q))
{
    $r['username'] =
            ($r['donatordays'])
                    ? '<span style="color:red; font-weight:bold;">'
                            . $r['username']
                            . '</span> <img src="donator.gif" alt="Donator: '
                            . $r['donatordays']
                            . ' Days Left" title="Donator: '
                            . $r['donatordays'] . ' Days Left" />'
                    : $r['username'];
    echo '
		<tr>
			<td>' . $r['userid'] . '</td>
			<td><a href="viewuser.php?u=' . $r['userid'] . '">'
            . $r['gangPREF'] . ' ' . $r['username'] . '</a></td>
			<td>' . money_formatter($r['money']) . '</td>
			<td>' . $r['level'] . '</td>
			<td>' . $r['gender'] . '</td>
			<td>'
            . (($r['laston'] >= $_SERVER['REQUEST_TIME'] - 15 * 60)
                    ? '<span style="color: green; font-weight:bold;">Online</span>'
                    : '<span style="color: red; font-weight:bold;">Offline</span>')
            . '
			</td>
		</tr>
   ';
}
$db->free_result($q);
echo '</table>';
$h->endpage();
