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
 * File: halloffame.php
 * Signature: a7045d5e99b31e65253a262a0f741c76
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
$filters =
        array('nodon' => 'AND `donatordays` = 0',
                'don' => 'AND `donatordays` > 0', 'all' => '');
$hofheads =
        array('level', 'money', 'crystals', 'respect', 'total', 'strength',
                'agility', 'guard', 'labour', 'iq');
$_GET['action'] =
        (isset($_GET['action']) && in_array($_GET['action'], $hofheads))
                ? $_GET['action'] : 'level';
$filter =
        (isset($_GET['filter']) && isset($filters[$_GET['filter']]))
                ? $_GET['filter'] : 'all';
$myf = $filters[$filter];
$hofqone = array('level', 'money', 'crystals');
if (in_array($_GET['action'], $hofqone))
{
    $q =
            $db->query(
                    "SELECT `userid`, `laston`, `gender`, `donatordays`,
                     `username`, `level`, `money`, `crystals`, `gangPREF`
                     FROM `users` AS `u`
                     LEFT JOIN `gangs` AS `g`
                     ON `g`.`gangID` = `u`.`gang`
                     WHERE `u`.`user_level` != 0
                     $myf
                     ORDER BY `{$_GET['action']}` DESC, `userid` ASC
                     LIMIT 20");
}
$hofqtwo = array('total', 'strength', 'agility', 'guard', 'labour', 'iq');
if (in_array($_GET['action'], $hofqtwo))
{
    if ($_GET['action'] == 'total')
    {
        $us = '(`strength` + `agility` + `guard` + `labour` + `IQ`)';
    }
    else
    {
        $us = '`' . $_GET['action'] . '`';
    }
    $q =
            $db->query(
                    "SELECT u.`userid`, `laston`, `gender`, `donatordays`,
                     `level`, `money`, `crystals`, `username`, `gangPREF`,
                     `strength`, `agility`, `guard`, `labour`, `IQ`
                     FROM `users` AS `u`
                     INNER JOIN `userstats` AS `us`
                     ON `u`.`userid` = `us`.`userid`
                     LEFT JOIN `gangs` AS `g`
                     ON `g`.`gangID` = `u`.`gang`
                     WHERE `u`.`user_level` != 0
                     $myf
                     ORDER BY {$us} DESC, `u`.`userid` ASC
                     LIMIT 20");
}
if ($_GET['action'] != 'respect')
{
    $non_don =
            (($filter == 'nodon') ? '<b>' : '')
                    . '<a href="halloffame.php?action=' . $_GET['action']
                    . '&filter=nodon">Non-Donators</a>'
                    . (($filter == 'nodon') ? '</b>' : '');
    $is_don =
            (($filter == 'don') ? '<b>' : '')
                    . '<a href="halloffame.php?action=' . $_GET['action']
                    . '&filter=don">Donators</a>'
                    . (($filter == 'don') ? '</b>' : '');
    $all_us =
            (($filter == 'all') ? '<b>' : '')
                    . '<a href="halloffame.php?action=' . $_GET['action']
                    . '&filter=all">All Users</a>'
                    . (($filter == 'all') ? '</b>' : '');
}
echo "
<h3>Hall Of Fame</h3>
"
        . (($_GET['action'] != 'respect')
                ? '<hr />Filter: [' . $non_don . ' | ' . $is_don . ' | '
                        . $all_us . ']<hr />' : '')
        . "

<table width='75%' cellpadding='1' cellspacing='1' class='table'>
		<tr>
	<td><a href='halloffame.php?action=level&filter={$filter}'>LEVEL</a></td>
	<td><a href='halloffame.php?action=money&filter={$filter}'>MONEY</a></td>
	<td><a href='halloffame.php?action=crystals&filter={$filter}'>CRYSTALS</a></td>
	<td><a href='halloffame.php?action=respect&filter={$filter}'>RESPECT</a></td>
	<td><a href='halloffame.php?action=total&filter={$filter}'>TOTAL STATS</a></td>
		</tr>
		<tr>
	<td><a href='halloffame.php?action=strength&filter={$filter}'>STRENGTH</a></td>
	<td><a href='halloffame.php?action=agility&filter={$filter}'>AGILITY</a></td>
	<td><a href='halloffame.php?action=guard&filter={$filter}'>GUARD</a></td>
	<td><a href='halloffame.php?action=labour&filter={$filter}'>LABOUR</a></td>
	<td><a href='halloffame.php?action=iq&filter={$filter}'>IQ</a></td>
		</tr>
</table>
   ";
switch ($_GET['action'])
{
case "level":
    hof_level();
    break;
case "money":
    hof_money();
    break;
case "crystals":
    hof_crystals();
    break;
case "respect":
    hof_respect();
    break;
case "total":
    hof_total();
    break;
case "strength":
    hof_strength();
    break;
case "agility":
    hof_agility();
    break;
case "guard":
    hof_guard();
    break;
case "labour":
    hof_labour();
    break;
case "iq":
    hof_iq();
    break;
}

function hof_level()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest levels
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
			<th>Level</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
	<td>' . $r['level'] . '</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_money()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest amount of money
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
			<th>Money</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
	<td>' . money_formatter($r['money'], '$') . '</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_crystals()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest amount of crystals
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
			<th>Crystals</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
	<td>' . money_formatter($r['crystals'], '') . '</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_respect()
{
    global $db, $ir, $c, $userid;
    echo "
Showing the 20 gangs with the highest amount of respect
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>Gang</th>
			<th>Respect</th>
		</tr>
   ";
    $q =
            $db->query(
                    "SELECT `gangID`, `gangNAME`, `gangRESPECT`
                     FROM `gangs`
                     ORDER BY `gangRESPECT` DESC, `gangID` ASC
                     LIMIT 20");
    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['gangID'] == $ir['gang']) ? ' style="font-weight: bold;"'
                        : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangNAME'] . ' [' . $r['gangID'] . ']</td>
	<td>' . money_formatter($r['gangRESPECT'], '') . '</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_total()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest total stats
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_strength()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest strength
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_agility()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest agility
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_guard()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest guard
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_labour()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest labour
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}

function hof_iq()
{
    global $db, $ir, $c, $userid, $myf, $q;
    echo "
Showing the 20 users with the highest IQ
<br />
<table width='75%' cellspacing='1' class='table'>
		<tr style='background:gray'>
			<th>Pos</th>
			<th>User</th>
		</tr>
   ";

    $p = 0;
    while ($r = $db->fetch_row($q))
    {
        $p++;
        $bold_hof =
                ($r['userid'] == $userid) ? ' style="font-weight: bold;"' : '';
        echo '
		<tr ' . $bold_hof . '>
	<td>' . $p . '</td>
	<td>' . $r['gangPREF'] . ' ' . $r['username'] . ' [' . $r['userid']
                . ']</td>
		</tr>
   ';
    }
    $db->free_result($q);
    echo '</table>';
}
$h->endpage();
