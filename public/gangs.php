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
 * File: gangs.php
 * Signature: 92dce273deb1646013f261098b78903c
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
if (!isset($_GET['ID']))
{
    $_GET['ID'] = 0;
}
$_GET['ID'] = abs((int) $_GET['ID']);
if (!$_GET['ID'])
{
    echo "Invalid use of file";
}
else
{
    $gq =
            $db->query(
                    "SELECT `gangPRESIDENT`, `gangVICEPRES`, `gangNAME`,
                     `gangID`, `gangRESPECT`, `gangDESC`
    				 FROM `gangs`
    				 WHERE `gangID` = {$_GET['ID']}");
    $gangdata = $db->fetch_row($gq);
    if (!isset($_GET['action']))
    {
        $_GET['action'] = '';
    }
    switch ($_GET['action'])
    {
    case 'view':
        gang_view();
        break;

    case 'userlist':
        gang_userlist();
        break;

    case 'apply':
        gang_applyform();
        break;

    case 'applys':
        gang_applysubmit();
        break;

    default:
        gang_view();
        break;
    }
}

function gang_view()
{
    global $db, $ir, $c, $h, $gangdata;
    $pq =
            $db->query(
                    "SELECT `userid`, `username`
    				 FROM `users`
    				 WHERE `userid` = {$gangdata['gangPRESIDENT']}
    				 LIMIT 1");
    if ($db->num_rows($pq) == 0)
    {
        $ldr = array('userid' => 0);
    }
    else
    {
        $ldr = $db->fetch_row($pq);
    }
    $db->free_result($pq);
    $vpq =
            $db->query(
                    "SELECT `userid`, `username`
                     FROM `users`
                     WHERE `userid` = {$gangdata['gangVICEPRES']}");
    if ($db->num_rows($vpq) == 0)
    {
        $coldr = array('userid' => 0);
    }
    else
    {
        $coldr = $db->fetch_row($vpq);
    }
    $db->free_result($vpq);
    echo "<h3><u>{$gangdata['gangNAME']} Gang</u></h3><hr />";
    if ($ldr['userid'] > 0)
    {
        print
                "President: <a href='viewuser.php?u={$ldr['userid']}'>{$ldr['username']}</a><br />";
    }
    else
    {
        print "President: N/A<br />";
    }
    if ($coldr['userid'] > 0)
    {
        print
                "Vice-President: <a href='viewuser.php?u={$coldr['userid']}'>{$coldr['username']}</a><hr />";
    }
    else
    {
        print "Vice-President: N/A<hr />";
    }
    $cnt =
            $db->query(
                    "SELECT COUNT(`userid`)
                     FROM `users`
                     WHERE `gang` = {$gangdata['gangID']}");
    echo "<b>Members:</b> " . $db->fetch_single($cnt)
            . "<br />
		  <b>Description: </b> {$gangdata['gangDESC']}<br />
		  <b>Respect Level: </b> {$gangdata['gangRESPECT']}<br />
		 &gt; <a href='gangs.php?action=userlist&amp;ID={$gangdata['gangID']}'>
		  User List
		 </a><br />
		 &gt; <a href='gangs.php?action=apply&amp;ID={$gangdata['gangID']}'>
		  Apply
		 </a>";
    $db->free_result($cnt);
}

function gang_userlist()
{
    global $db, $ir, $c, $h, $gangdata;
    echo "<h3>Userlist for {$gangdata['gangNAME']}</h3>
		  <table>
		  	<tr style='background: gray;'>
		  		<th>User</th>
		  		<th>Level</th>
		  		<th>Days In Gang</th>
		  	</tr>";
    $q =
            $db->query(
                    "SELECT `userid`, `username`, `level`, `daysingang`
                     FROM `users`
                     WHERE `gang` = {$gangdata['gangID']}
                     ORDER BY `daysingang` DESC, `level` DESC");
    while ($r = $db->fetch_row($q))
    {
        echo "<tr>
        		<td><a href='viewuser.php?u={$r['userid']}'>
                 {$r['username']}
        		</a></td>
        		<td>{$r['level']}</td>
        		<td>{$r['daysingang']}</td>
        	  </tr>";
    }
    $db->free_result($q);
    echo "</table><br />
	&gt; <a href='gangs.php?action=view&amp;ID={$gangdata['gangID']}'>
	Back
	</a>";
}

function gang_applyform()
{
    global $ir, $c, $h, $gangdata;
    if ($ir['gang'] == 0)
    {
        $apply_csrf = request_csrf_code('gang_apply');
        echo "<form action='gangs.php?action=applys&amp;ID={$_GET['ID']}' method='post'>
Type the reason you should be in this faction.<br />
<textarea name='application' rows='7' cols='40'></textarea><br />
<input type='hidden' name='verf' value='{$apply_csrf}' />
<input type='submit' value='Apply' /></form>";
    }
    else
    {
        echo "You cannot apply for a gang when you are already in one.";
    }
}

function gang_applysubmit()
{
    global $db, $ir, $c, $h, $gangdata, $userid;
    $application =
            (isset($_POST['application']) && is_string($_POST['application']))
                    ? $db->escape(
                            htmlentities(
                                    stripslashes($_POST['application']),
                                    ENT_QUOTES, 'ISO-8859-1')) : '';
    if (!isset($_POST['verf'])
            || !verify_csrf_code('gang_apply', stripslashes($_POST['verf'])))
    {
        echo "
        Your request to apply to this gang has expired. Please try again.<br />
        &gt; <a href='gangs.php?action=apply&amp;ID={$_GET['ID']}'>Back</a>
           ";
        die($h->endpage());
    }
    if (!$ir['gang'])
    {
        $db->query(
                "INSERT INTO `applications`
                 VALUES(NULL, $userid, {$_GET['ID']}, '{$application}')");
        $gev =
                $db->escape(
                        "<a href='viewuser.php?u={$userid}'>{$ir['username']}</a>"
                                . " sent an application to join this gang.");
        $db->query(
                "INSERT INTO `gangevents`
                 VALUES(NULL, {$_GET['ID']}, " . time() . ", '{$gev}')");
        echo "You sent your application to the {$gangdata['gangNAME']} gang.";
    }
    else
    {
        echo "You cannot apply for a gang when you are already in one.";
    }
}
$h->endpage();
