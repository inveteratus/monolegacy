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
 * File: staff_crimes.php
 * Signature: d6f7b3e08025c35caa54144262d8bafe
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('sglobals.php');
if ($ir['user_level'] != 2)
{
    echo 'You cannot access this area.<br />
    &gt; <a href="staff.php">Go Back</a>';
    die($h->endpage());
}
//This contains crime stuffs
if (!isset($_GET['action']))
{
    $_GET['action'] = '';
}
switch ($_GET['action'])
{
case 'newcrime':
    new_crime_form();
    break;
case 'newcrimesub':
    new_crime_submit();
    break;
case 'editcrime':
    edit_crime_begin();
    break;
case 'editcrimeform':
    edit_crime_form();
    break;
case 'editcrimesub':
    edit_crime_sub();
    break;
case 'delcrime':
    delcrime();
    break;
case 'newcrimegroup':
    new_crimegroup_form();
    break;
case 'newcrimegroupsub':
    new_crimegroup_submit();
    break;
case 'editcrimegroup':
    edit_crimegroup_begin();
    break;
case 'editcrimegroupform':
    edit_crimegroup_form();
    break;
case 'editcrimegroupsub':
    edit_crimegroup_sub();
    break;
case 'delcrimegroup':
    delcrimegroup();
    break;
case 'reorder':
    reorder_crimegroups();
    break;
default:
    echo 'Error: This script requires an action.';
    break;
}

function new_crime_form()
{
    $csrf = request_csrf_html('staff_newcrime');
    echo "
    Adding a new crime.<br />
    <form action='staff_crimes.php?action=newcrimesub' method='post'>
    Name: <input type='text' name='name' />
    <br />
    	Brave Cost (1-9 chars only): <input type='text' name='brave' />
    <br />
    	Success % Formula: <input type='text' name='percform' value='((WILL*0.8)/2.5)+(LEVEL/4)' />
    <br />
    	Success Money (1-9 chars only): <input type='text' name='money' />
    <br />
    	Success Crystals (1-9 chars only): <input type='text' name='crys' />
    <br />
    	Success Item: " . item2_dropdown(NULL, 'item')
            . "
    <br />
    	Group: " . crimegroup_dropdown(NULL, 'group')
            . "
    <br />
    	Initial Text: <textarea rows='4' cols='40' name='itext'></textarea>
    <br />
    	Success Text: <textarea rows='4' cols='40' name='stext'></textarea>
    <br />
    	Failure Text: <textarea rows='4' cols='40' name='ftext'></textarea>
    <br />
    	Jail Text: <textarea rows='4' cols='40' name='jtext'></textarea>
    <br />
    	Jail Time (1-9 chars only): <input type='text' name='jailtime' />
    <br />
    	Jail Reason: <input type='text' name='jailreason' />
    <br />
    	Crime XP Given (1-9 chars only): <input type='text' name='crimexp' />
    <br />
    	{$csrf}
    	<input type='submit' value='Create Crime' />
    </form>
       ";
}

function new_crime_submit()
{
    global $c, $userid, $db, $h;
    $_POST['name'] =
            (isset($_POST['name'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])*$/i",
                            $_POST['name']))
                    ? $db->escape(strip_tags(stripslashes($_POST['name'])))
                    : '';
    $_POST['brave'] =
            (isset($_POST['brave']) && is_numeric($_POST['brave']))
                    ? abs(intval($_POST['brave'])) : '';
    $_POST['percform'] =
            (isset($_POST['percform']))
                    ? $db->escape(strip_tags(stripslashes($_POST['percform'])))
                    : '';
    $_POST['money'] =
            (isset($_POST['money']) && is_numeric($_POST['money']))
                    ? abs(intval($_POST['money'])) : '';
    $_POST['crys'] =
            (isset($_POST['crys']) && is_numeric($_POST['crys']))
                    ? abs(intval($_POST['crys'])) : '';
    $_POST['item'] =
            (isset($_POST['item']) && is_numeric($_POST['item']))
                    ? abs(intval($_POST['item'])) : 0;
    $_POST['group'] =
            (isset($_POST['group']) && is_numeric($_POST['group']))
                    ? abs(intval($_POST['group'])) : '';
    $_POST['itext'] =
            (isset($_POST['itext']))
                    ? $db->escape(strip_tags(stripslashes($_POST['itext'])))
                    : '';
    $_POST['stext'] =
            (isset($_POST['stext']))
                    ? $db->escape(strip_tags(stripslashes($_POST['stext'])))
                    : '';
    $_POST['ftext'] =
            (isset($_POST['ftext']))
                    ? $db->escape(strip_tags(stripslashes($_POST['ftext'])))
                    : '';
    $_POST['jtext'] =
            (isset($_POST['jtext']))
                    ? $db->escape(strip_tags(stripslashes($_POST['jtext'])))
                    : '';
    $_POST['jailtime'] =
            (isset($_POST['jailtime']) && is_numeric($_POST['jailtime']))
                    ? abs(intval($_POST['jailtime'])) : '';
    $_POST['jailreason'] =
            (isset($_POST['jailreason'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])*$/i",
                            $_POST['jailreason']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['jailreason'])))
                    : '';
    $_POST['crimexp'] =
            (isset($_POST['crimexp']) && is_numeric($_POST['crimexp']))
                    ? abs(intval($_POST['crimexp'])) : '';
    if (empty($_POST['name']) || empty($_POST['brave'])
            || empty($_POST['percform']) || empty($_POST['money'])
            || empty($_POST['crys']) || empty($_POST['group'])
            || empty($_POST['itext']) || empty($_POST['stext'])
            || empty($_POST['ftext']) || empty($_POST['jtext'])
            || empty($_POST['jailtime']) || empty($_POST['jailreason'])
            || empty($_POST['crimexp']))
    {
        echo 'One or more of the inputs seems to of the wrong format,
        		please go back and try again.<br />
        	  &gt; <a href="staff_crimes.php?action=newcrime">Go back</a>';
        die($h->endpage());
    }
    staff_csrf_stdverify('staff_newcrime', 'staff_crimes.php?action=newcrime');
    if (!empty($_POST['item']))
    {
        $qi =
                $db->query(
                        'SELECT COUNT(`itmid`)
                         FROM `items`
                         WHERE `itmid` = ' . $_POST['item']);
        $exist_check = $db->fetch_single($qi);
        $db->free_result($qi);
        if ($exist_check == 0)
        {
            echo 'Item you selected doesn\'t seem to exist.<br />
            &gt; <a href="staff_crimes.php?action=newcrime">Go back</a>';
            die($h->endpage());
        }
    }
    $db->query(
            "INSERT INTO `crimes`
             (`crimeNAME`, `crimeBRAVE`, `crimePERCFORM`, `crimeSUCCESSMUNY`,
             `crimeSUCCESSCRYS`, `crimeSUCCESSITEM`, `crimeGROUP`,
             `crimeITEXT`, `crimeSTEXT`, `crimeFTEXT`, `crimeJTEXT`,
             `crimeJAILTIME`, `crimeJREASON`, `crimeXP`)
             VALUES('{$_POST['name']}', '{$_POST['brave']}',
             '{$_POST['percform']}', '{$_POST['money']}', {$_POST['crys']},
             {$_POST['item']}, '{$_POST['group']}', '{$_POST['itext']}',
             '{$_POST['stext']}', '{$_POST['ftext']}', '{$_POST['jtext']}',
             {$_POST['jailtime']}, '{$_POST['jailreason']}',
             {$_POST['crimexp']})");
    echo 'Crime (' . $_POST['name']
            . ') created.<br />
            &gt; <a href="staff.php">Goto Main</a>';
    stafflog_add('Created crime ' . $_POST['name']);
}

function edit_crime_begin()
{
    $csrf = request_csrf_html('staff_editcrime1');
    echo "
    <h3>Editing Crime</h3>
    You can edit any aspect of this crime.
    <br />
    <form action='staff_crimes.php?action=editcrimeform' method='post'>
    	Crime: " . crime_dropdown(NULL, 'crime')
            . "
    <br />
    	{$csrf}
    	<input type='submit' value='Edit Crime' />
    </form>
       ";
}

function edit_crime_form()
{
    global $c, $h, $userid, $db;
    $_POST['crime'] =
            (isset($_POST['crime']) && is_numeric($_POST['crime']))
                    ? abs(intval($_POST['crime'])) : '';
    staff_csrf_stdverify('staff_editcrime1',
            'staff_crimes.php?action=editcrime');
    $d =
            $db->query(
                    "SELECT `crimeXP`, `crimeJREASON`, `crimeJAILTIME`,
                     `crimeJTEXT`, `crimeFTEXT`, `crimeSTEXT`, `crimeITEXT`,
                     `crimeGROUP`, `crimeSUCCESSITEM`, `crimeSUCCESSCRYS`,
                     `crimeSUCCESSMUNY`, `crimePERCFORM`, `crimeBRAVE`,
                     `crimeNAME`
                     FROM `crimes`
                     WHERE `crimeID` = {$_POST['crime']}");
    if ($db->num_rows($d) == 0)
    {
        $db->free_result($d);
        echo 'Crime doesn\'t seem to exist.<br />&gt; <a href="staff_crimes.php?action=newcrime">Go back</a>';
        die($h->endpage());
    }
    $itemi = $db->fetch_row($d);
    $db->free_result($d);
    $csrf = request_csrf_html('staff_editcrime2');
    echo "
    <h3>Editing Crime</h3>
    <form action='staff_crimes.php?action=editcrimesub' method='post'>
    	<input type='hidden' name='crimeID' value='{$_POST['crime']}' />
    	Name: <input type='text' name='crimeNAME' value='{$itemi['crimeNAME']}' />
    <br />
    	Brave Cost: <input type='text' name='crimeBRAVE' value='{$itemi['crimeBRAVE']}' />
    <br />
    	Success % Formula: <input type='text' name='crimePERCFORM' value='{$itemi['crimePERCFORM']}' />
    <br />
    	Success Money: <input type='text' name='crimeSUCCESSMUNY' value='{$itemi['crimeSUCCESSMUNY']}' />
    <br />
    	Success Crystals: <input type='text' name='crimeSUCCESSCRYS' value='{$itemi['crimeSUCCESSCRYS']}' />
    <br />
    	Success Item: "
            . item2_dropdown(NULL, 'crimeSUCCESSITEM',
                    $itemi['crimeSUCCESSITEM']) . "
    <br />
    	Group: "
            . crimegroup_dropdown(NULL, 'crimeGROUP', $itemi['crimeGROUP'])
            . "
    <br />
    	Initial Text: <textarea rows='4' cols='40' name='crimeITEXT'>{$itemi['crimeITEXT']}</textarea>
    <br />
    	Success Text: <textarea rows='4' cols='40' name='crimeSTEXT'>{$itemi['crimeSTEXT']}</textarea>
    <br />
    	Failure Text: <textarea rows='4' cols='40' name='crimeFTEXT'>{$itemi['crimeFTEXT']} </textarea>
    <br />
    	Jail Text: <textarea rows='4' cols='40' name='crimeJTEXT'>{$itemi['crimeJTEXT']} </textarea>
    <br />
    	Jail Time: <input type='text' name='crimeJAILTIME' value='{$itemi['crimeJAILTIME']}' />
    <br />
    	Jail Reason: <input type='text' name='crimeJREASON' value='{$itemi['crimeJREASON']}' />
    <br />
    	Crime XP Given: <input type='text' name='crimeXP' value='{$itemi['crimeXP']}' />
    <br />
    	{$csrf}
    	<input type='submit' value='Edit Crime' />
    </form>
       ";
}

function edit_crime_sub()
{
    global $c, $h, $userid, $db;
    $_POST['crimeNAME'] =
            (isset($_POST['crimeNAME'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])+$/i",
                            $_POST['crimeNAME']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimeNAME']))) : '';
    $_POST['crimeBRAVE'] =
            (isset($_POST['crimeBRAVE']) && is_numeric($_POST['crimeBRAVE']))
                    ? abs(intval($_POST['crimeBRAVE'])) : '';
    $_POST['crimePERCFORM'] =
            (isset($_POST['crimePERCFORM']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimePERCFORM'])))
                    : '';
    $_POST['crimeSUCCESSMUNY'] =
            (isset($_POST['crimeSUCCESSMUNY'])
                    && is_numeric($_POST['crimeSUCCESSMUNY']))
                    ? abs(intval($_POST['crimeSUCCESSMUNY'])) : '';
    $_POST['crimeSUCCESSCRYS'] =
            (isset($_POST['crimeSUCCESSCRYS'])
                    && is_numeric($_POST['crimeSUCCESSCRYS']))
                    ? abs(intval($_POST['crimeSUCCESSCRYS'])) : '';
    $_POST['crimeSUCCESSITEM'] =
            (isset($_POST['crimeSUCCESSITEM'])
                    && is_numeric($_POST['crimeSUCCESSITEM']))
                    ? abs(intval($_POST['crimeSUCCESSITEM'])) : 0;
    $_POST['crimeGROUP'] =
            (isset($_POST['crimeGROUP']) && is_numeric($_POST['crimeGROUP']))
                    ? abs(intval($_POST['crimeGROUP'])) : '';
    $_POST['crimeITEXT'] =
            (isset($_POST['crimeITEXT']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimeITEXT'])))
                    : '';
    $_POST['crimeSTEXT'] =
            (isset($_POST['crimeSTEXT']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimeSTEXT'])))
                    : '';
    $_POST['crimeFTEXT'] =
            (isset($_POST['crimeFTEXT']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimeFTEXT'])))
                    : '';
    $_POST['crimeJTEXT'] =
            (isset($_POST['crimeJTEXT']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimeJTEXT'])))
                    : '';
    $_POST['crimeJAILTIME'] =
            (isset($_POST['crimeJAILTIME'])
                    && is_numeric($_POST['crimeJAILTIME']))
                    ? abs(intval($_POST['crimeJAILTIME'])) : '';
    $_POST['crimeJREASON'] =
            (isset($_POST['crimeJREASON'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])+$/i",
                            $_POST['crimeJREASON']))
                    ? $db->escape(
                            strip_tags(stripslashes($_POST['crimeJREASON'])))
                    : '';
    $_POST['crimeXP'] =
            (isset($_POST['crimeXP']) && is_numeric($_POST['crimeXP']))
                    ? abs(intval($_POST['crimeXP'])) : '';
    if (empty($_POST['crimeNAME']) || empty($_POST['crimeBRAVE'])
            || empty($_POST['crimePERCFORM'])
            || empty($_POST['crimeSUCCESSMUNY'])
            || empty($_POST['crimeSUCCESSCRYS'])
            || empty($_POST['crimeGROUP']) || empty($_POST['crimeITEXT'])
            || empty($_POST['crimeSTEXT']) || empty($_POST['crimeFTEXT'])
            || empty($_POST['crimeJTEXT']) || empty($_POST['crimeJAILTIME'])
            || empty($_POST['crimeJREASON']) || empty($_POST['crimeXP']))
    {
        echo 'One or more of the inputs seems to be of the wrong format,
        		please go back and try again.<br />
        &gt; <a href="staff_crimes.php?action=editcrime">Go back</a>';
        die($h->endpage());
    }
    staff_csrf_stdverify('staff_editcrime2',
            'staff_crimes.php?action=editcrime');
    if (!empty($_POST['crimeSUCCESSITEM']))
    {
        $qi =
                $db->query(
                        'SELECT COUNT(`itmid`)
                         FROM `items`
                         WHERE `itmid` = ' . $_POST['crimeSUCCESSITEM']);
        $exist_check = $db->fetch_single($qi);
        $db->free_result($qi);
        if ($exist_check == 0)
        {
            echo 'Item you selected doesn\'t seem to exist.<br />
            &gt; <a href="staff_crimes.php?action=editcrime">Go back</a>';
            die($h->endpage());
        }
    }
    $db->query(
            "UPDATE `crimes`
             SET `crimeNAME` = '{$_POST['crimeNAME']}',
             `crimeBRAVE` = '{$_POST['crimeBRAVE']}',
             `crimePERCFORM` = '{$_POST['crimePERCFORM']}',
             `crimeSUCCESSMUNY` = '{$_POST['crimeSUCCESSMUNY']}',
             `crimeSUCCESSCRYS` = '{$_POST['crimeSUCCESSCRYS']}',
             `crimeSUCCESSITEM` = '{$_POST['crimeSUCCESSITEM']}',
             `crimeGROUP` = '{$_POST['crimeGROUP']}',
             `crimeITEXT` = '{$_POST['crimeITEXT']}',
             `crimeSTEXT` = '{$_POST['crimeSTEXT']}',
             `crimeFTEXT` = '{$_POST['crimeFTEXT']}',
             `crimeJTEXT` = '{$_POST['crimeJTEXT']}',
             `crimeJAILTIME` = {$_POST['crimeJAILTIME']},
             `crimeJREASON` = '{$_POST['crimeJREASON']}',
             `crimeXP` = {$_POST['crimeXP']}
             WHERE `crimeID` = {$_POST['crimeID']}");
    echo 'Crime (' . $_POST['crimeNAME']
            . ') edited.<br />
            &gt; <a href="staff.php">Goto Main</a>';
    stafflog_add('Edited crime ' . $_POST['crimeNAME']);

}

function delcrime()
{
    global $c, $h, $userid, $db;
    switch ($_GET['step'])
    {
    default:
        $csrf = request_csrf_html('staff_delcrime1');
        echo "
        <h3>Deleting Crime</h3>
        Here you can delete a crime. <br />
        <form action='staff_crimes.php?action=delcrime&amp;step=2' method='post'>
        	Crime: " . crime_dropdown(NULL, 'crime')
                . "
        <br />
        	{$csrf}
        	<input type='submit' value='Delete Crime' />
        </form>
           ";
        break;
    case 2:
        $target =
                (isset($_POST['crime']) && is_numeric($_POST['crime']))
                        ? abs(intval($_POST['crime'])) : '';
        staff_csrf_stdverify('staff_delcrime1',
                'staff_crimes.php?action=delcrime');
        if (empty($target))
        {
            echo 'Invalid Crime.<br />
            &gt; <a href="staff_crimes.php?action=delcrime">Go back</a>';
            die($h->endpage());
        }
        $d =
                $db->query(
                        "SELECT `crimeNAME`
                         FROM `crimes`
                         WHERE `crimeID` = '$target'");
        if ($db->num_rows($d) == 0)
        {
            $db->free_result($d);
            echo 'Crime you selected doesn\'t seem to exist.<br />
            &gt; <a href="staff_crimes.php?action=delcrime">Go back</a>';
            die($h->endpage());
        }
        $itemi = $db->fetch_row($d);
        $db->free_result($d);
        $csrf = request_csrf_html('staff_delcrime2');
        echo "
        <h3>Confirm</h3>
        Delete crime -  " . $itemi["crimeNAME"]
                . "?
        <form action='staff_crimes.php?action=delcrime&amp;step=3' method='post'>
        	<input type='hidden' name='crimeID' value='$target' />
        	{$csrf}
        	<input type='submit' name='yesorno' value='Yes' />
        	<input type='submit' name='yesorno' value='No' onclick=\"window.location='staff_crimes.php?action=delcrime';\" />
        </form>
           ";
        break;
    case 3:
        $target =
                (isset($_POST['crimeID']) && is_numeric($_POST['crimeID']))
                        ? abs(intval($_POST['crimeID'])) : '';
        staff_csrf_stdverify('staff_delcrime2',
                'staff_crimes.php?action=delcrime');
        if (empty($target))
        {
            echo 'Invalid Crime.<br />
            &gt; <a href="staff_crimes.php?action=delcrime">Go back</a>';
            die($h->endpage());
        }
        $_POST['yesorno'] =
                (isset($_POST['yesorno'])
                        && in_array($_POST['yesorno'], array('Yes', 'No')))
                        ? $_POST['yesorno'] : 'No';
        if ($_POST['yesorno'] == 'No')
        {
            echo '
        	Crime not deleted.<br />
        	&gt; <a href="staff.php">Goto Main</a>
           	';
            die($h->endpage());
        }
        $d =
                $db->query(
                        "SELECT `crimeNAME`
                        FROM `crimes`
                        WHERE `crimeID` = '$target'");
        if ($db->num_rows($d) == 0)
        {
            $db->free_result($d);
            echo 'Crime you selected doesn\'t seem to exist.<br />
            &gt; <a href="staff_crimes.php?action=delcrime">Go back</a>';
            die($h->endpage());
        }
        $itemi = $db->fetch_row($d);
        $db->free_result($d);
        $db->query(
                "DELETE FROM `crimes`
        	     WHERE `crimeID` = '$target'");
        echo 'Crime (' . $itemi['crimeNAME']
                . ') Deleted.<br />
                &gt; <a href="staff.php">Goto Main.</a>';
        stafflog_add('Deleted crime ' . $itemi['crimeNAME']);
        break;
    }
}

function new_crimegroup_form()
{
    $csrf = request_csrf_html('staff_newcrimegroup');
    echo "
    Adding a new crime group.
    <br />
    <form action='staff_crimes.php?action=newcrimegroupsub' method='post'>
    	Name: <input type='text' name='cgNAME' />
    <br />
    	Order Number: <input type='text' name='cgORDER' />
    <br />
    	{$csrf}
    	<input type='submit' value='Create Crime Group' />
    </form>
       ";
}

function new_crimegroup_submit()
{
    global $c, $userid, $db, $h;
    $_POST['cgNAME'] =
            (isset($_POST['cgNAME'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])+$/i",
                            $_POST['cgNAME']))
                    ? $db->escape(strip_tags(stripslashes($_POST['cgNAME'])))
                    : '';
    $_POST['cgORDER'] =
            (isset($_POST['cgORDER']) && is_numeric($_POST['cgORDER']))
                    ? abs(intval($_POST['cgORDER'])) : '';
    if (empty($_POST['cgNAME']) || empty($_POST['cgORDER']))
    {
        echo 'You missed one or more of the required fields.
        		Please go back and try again.<br />
        &gt; <a href="staff_crimes.php?action=newcrimegroup">Go Back</a>';
        die($h->endpage());
    }
    staff_csrf_stdverify('staff_newcrimegroup',
            'staff_crimes.php?action=newcrimegroup');
    $d =
            $db->query(
                    'SELECT COUNT(`cgID`)
                     FROM `crimegroups`
                     WHERE `cgORDER` = ' . $_POST['cgORDER']);
    if ($db->fetch_single($d) > 0)
    {
        $db->free_result($d);
        echo 'You cannot put two crime groups in the same order.<br />
        &gt; <a href="staff_crimes.php?action=newcrimegroup">Go back</a>';
        die($h->endpage());
    }
    $db->free_result($d);
    $db->query(
            "INSERT INTO `crimegroups`
             (`cgNAME`, `cgORDER`)
             VALUES('{$_POST['cgNAME']}', '{$_POST['cgORDER']}')");
    echo 'Crime Group created!<br />
    &gt; <a href="staff_crimes.php?action=newcrimegroup">Go Back</a>';
    stafflog_add('Created Crime Group ' . $_POST['cgNAME']);
}

function edit_crimegroup_begin()
{
    $csrf = request_csrf_html('staff_editcrimegroup1');
    global $c, $h, $userid, $db;
    echo "
    <h3>Editing A Crime Group</h3>
    <form action='staff_crimes.php?action=editcrimegroupform' method='post'>
    	Crime Group: " . crimegroup_dropdown(NULL, 'crimeGROUP')
            . "
    <br />
    	{$csrf}
    	<input type='submit' value='Edit Crime Group' />
    </form>
       ";
}

function edit_crimegroup_form()
{
    global $c, $h, $userid, $db;
    $_POST['crimeGROUP'] =
            (isset($_POST['crimeGROUP']) && is_numeric($_POST['crimeGROUP']))
                    ? abs(intval($_POST['crimeGROUP'])) : '';
    staff_csrf_stdverify('staff_editcrimegroup1',
            'staff_crimes.php?action=editcrimegroup');
    if (empty($_POST['crimeGROUP']))
    {
        echo 'Invalid Group.<br />
        &gt; <a href="staff_crimes.php?action=editcrimegroup">Go back</a>';
        die($h->endpage());
    }
    $d =
            $db->query(
                    "SELECT `cgORDER`, `cgNAME`
                     FROM `crimegroups`
                     WHERE `cgID` = {$_POST['crimeGROUP']}");
    if ($db->num_rows($d) == 0)
    {
        $db->free_result($d);
        echo 'Group you selected doesn\'t seem to exist.<br />
        &gt; <a href="staff_crimes.php?action=editcrimegroup">Go back</a>';
        die($h->endpage());
    }
    $itemi = $db->fetch_row($d);
    $db->free_result($d);
    $csrf = request_csrf_html('staff_editcrimegroup2');
    echo "
    <h3>Editing Crime Group</h3>
    <form action='staff_crimes.php?action=editcrimegroupsub' method='post'>
    	<input type='hidden' name='cgID' value='{$_POST['crimeGROUP']}' />
    	Name: <input type='text' name='cgNAME' value='{$itemi['cgNAME']}' />
    <br />
    	Order Number: <input type='text' name='cgORDER' value='{$itemi['cgORDER']}' />
    <br />
    	{$csrf}
    	<input type='submit' value='Edit Crime Group' />
    </form>
       ";
}

function edit_crimegroup_sub()
{
    global $c, $h, $userid, $db;
    $_POST['cgNAME'] =
            (isset($_POST['cgNAME'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])+$/i",
                            $_POST['cgNAME']))
                    ? $db->escape(strip_tags(stripslashes($_POST['cgNAME'])))
                    : '';
    $_POST['cgORDER'] =
            (isset($_POST['cgORDER']) && is_numeric($_POST['cgORDER']))
                    ? abs(intval($_POST['cgORDER'])) : '';
    $_POST['cgID'] =
            (isset($_POST['cgID']) && is_numeric($_POST['cgID']))
                    ? abs(intval($_POST['cgID'])) : '';
    staff_csrf_stdverify('staff_editcrimegroup2',
            'staff_crimes.php?action=editcrimegroup');
    if (empty($_POST['cgNAME']) || empty($_POST['cgORDER']))
    {
        echo 'You missed one or more of the required fields.
        		Please go back and try again.<br />
        &gt; <a href="staff_crimes.php?action=editcrimegroup">Go Back</a>';
        die($h->endpage());
    }
    else
    {
        $d =
                $db->query(
                        'SELECT COUNT(`cgID`)
                         FROM `crimegroups`
                         WHERE `cgORDER` = ' . $_POST['cgORDER']
                                . '
                         AND `cgID` != ' . $_POST['cgID']);
        if ($db->fetch_single($d) > 0)
        {
            $db->free_result($d);
            echo 'You cannot put two crime groups in the same order.<br />
            &gt; <a href="staff_crimes.php?action=editcrimegroup">Go back</a>';
            die($h->endpage());
        }
        $db->free_result($d);
        $db->query(
                "UPDATE `crimegroups`
                 SET `cgNAME` = '{$_POST['cgNAME']}',
                 `cgORDER` = '{$_POST['cgORDER']}'
                 WHERE `cgID` = '{$_POST['cgID']}'");
        echo 'Crime Group edited<br />
        &gt; <a href="staff_crimes.php?action=editcrimegroup">Go Back</a>';
        stafflog_add("Edited Crime Group {$_POST['cgNAME']}");
    }
}

function delcrimegroup()
{
    global $c, $h, $userid, $db;
    switch ($_GET['step'])
    {
    default:
        $csrf = request_csrf_html('staff_delcrimegroup1');
        echo "
        <h3>Deleting Crime Group</h3>
        <form action='staff_crimes.php?action=delcrimegroup&amp;step=2' method='post' name='theform' onsubmit='return checkme();'>
              Crime Group: " . crimegroup_dropdown(NULL, 'crimeGROUP')
                . "<br />
        Move crimes in deleted group to: "
                . crimegroup_dropdown(NULL, 'crimeGROUP2')
                . "<br />
              {$csrf}
              <input type='submit' value='Delete Crime Group' />
        </form>";
        break;
    case 2:
        $target =
                (isset($_POST['crimeGROUP'])
                        && is_numeric($_POST['crimeGROUP']))
                        ? abs(intval($_POST['crimeGROUP'])) : '';
        $target2 =
                (isset($_POST['crimeGROUP2'])
                        && is_numeric($_POST['crimeGROUP2']))
                        ? abs(intval($_POST['crimeGROUP2'])) : '';
        staff_csrf_stdverify('staff_delcrimegroup1',
                'staff_crimes.php?action=delcrimegroup');
        if ((empty($target) || empty($target2)) || ($target == $target2))
        {
            echo 'One of two things may have went wrong.<br />
            1) You didn\'t input the fields correctly.<br />
            2) Fields are the same.<br />
            &gt; <a href="staff_crimes.php?action=delcrimegroup">Go back</a>';
            die($h->endpage());
        }
        $q =
                $db->query(
                        "SELECT COUNT(`cgID`)
                         FROM `crimegroups`
                         WHERE `cgID` IN($target, $target2)");
        if ($db->fetch_single($q) < 2)
        {
            $db->free_result($q);
            echo 'One of the two or both groups selected don\'t exist.<br />
            &gt; <a href="staff_crimes.php?action=delcrimegroup">Go back</a>';
            die($h->endpage());
        }
        $db->free_result($q);
        $d =
                $db->query(
                        "SELECT `cgNAME`
                         FROM `crimegroups`
                         WHERE `cgID` = $target");
        $itemi = $db->fetch_single($d);
        $db->free_result($d);
        $csrf = request_csrf_html('staff_delcrimegroup2');
        echo "
        <h3>Confirm</h3>
        Delete crime group -  " . $itemi
                . "?
        <form action='staff_crimes.php?action=delcrimegroup&amp;step=3' method='post'>
        	<input type='hidden' name='cgID' value='$target' />
        	<input type='hidden' name='cgID2' value='$target2' />
        	{$csrf}
        	<input type='submit' name='yesorno' value='Yes' />
        	<input type='submit' name='yesorno' value='No' onclick=\"window.location='staff_crimes.php?action=delcrimegroup';\" />
        </form>
           ";
        break;
    case 3:
        $target =
                (isset($_POST['cgID']) && is_numeric($_POST['cgID']))
                        ? abs(intval($_POST['cgID'])) : '';
        $target2 =
                (isset($_POST['cgID2']) && is_numeric($_POST['cgID2']))
                        ? abs(intval($_POST['cgID2'])) : '';
        staff_csrf_stdverify('staff_delcrimegroup2',
                'staff_crimes.php?action=delcrimegroup');
        if ((empty($target) || empty($target2)) || ($target == $target2))
        {
            echo 'One of two things may have went wrong.<br />
            1) You didn\'t input the fields correctly.<br />
            2) Fields are the same.<br />
            &gt; <a href="staff_crimes.php?action=delcrimegroup">Go back</a>';
            die($h->endpage());
        }
        $q =
                $db->query(
                        "SELECT COUNT(`cgID`)
                         FROM `crimegroups`
                         WHERE `cgID` IN($target, $target2)");
        if ($db->fetch_single($q) < 2)
        {
            $db->free_result($q);
            echo 'One of the two or both groups selected don\'t exist.<br />
            &gt; <a href="staff_crimes.php?action=delcrimegroup">Go back</a>';
            die($h->endpage());
        }
        $db->free_result($q);
        $_POST['yesorno'] =
                (isset($_POST['yesorno'])
                        && in_array($_POST['yesorno'], array('Yes', 'No')))
                        ? $_POST['yesorno'] : 'No';
        if ($_POST['yesorno'] == 'No')
        {
            echo 'Group not deleted.<br />
            &gt; <a href="staff.php">Goto Main</a>';
            die($h->endpage());
        }
        $d =
                $db->query(
                        "SELECT `cgNAME`
                         FROM `crimegroups`
                         WHERE `cgID` = $target");
        $itemi = $db->fetch_row($d);
        $db->free_result($d);
        $db->query(
                "DELETE FROM `crimegroups`
        	     WHERE `cgID` = $target");
        $db->query(
                "UPDATE `crimes`
                 SET `crimeGROUP` = {$target2}
                 WHERE `crimeGROUP` = {$target}");
        stafflog_add("Deleted crime group {$itemi['cgNAME']}");
        echo 'Crime Group deleted.<br />
        &gt; <a href="staff.php">Goto Main</a>';
        break;
    }
}

function reorder_crimegroups()
{
    global $db, $c, $h, $userid;
    if (isset($_POST['submit']))
    {
        unset($_POST['submit']);
        staff_csrf_stdverify('staff_reorder_crimegroups',
                'staff_crimes.php?action=reorder');
        unset($_POST['verf']);
        $used = array();
        foreach ($_POST as $v)
        {
            $v = (isset($v) && is_numeric($v)) ? abs(intval($v)) : '';
            if (empty($v))
            {
                echo 'Invalid group.<br />
                &gt; <a href="staff_crimes.php?action=reorder">Go Back</a>';
                die($h->endpage());
            }
            if (in_array($v, $used))
            {
                echo 'You have used the same order number twice.<br />
                &gt; <a href="staff_crimes.php?action=reorder">Go Back</a>';
                die($h->endpage());
            }
            $used[] = $v;
        }
        $ro_cnt = count($used);
        $ro = implode(',', $used);
        $c_g =
                $db->query(
                        'SELECT COUNT(`cgID`)
                         FROM `crimegroups`
                         WHERE `cgORDER` IN(' . $ro . ')');
        if ($db->fetch_single($c_g) < $ro_cnt)
        {
            $db->free_result($c_q);
            echo 'Group order doesn\'t exist.<br />
            &gt; <a href="staff_crimes.php?action=reorder">Go Back</a>';
            die($h->endpage());
        }
        $db->free_result($c_q);
        foreach ($_POST as $k => $v)
        {
            $cg = str_replace("order", "", $k);
            $db->query(
                    "UPDATE `crimegroups`
                     SET `cgORDER` = {$v}
                     WHERE `cgID` = {$cg}");
        }
        echo "Crime group order updated!";
        stafflog_add("Reordered crime groups");
    }
    else
    {
        $q =
                $db->query(
                        "SELECT `cgID`, `cgNAME`
                        FROM `crimegroups`
                        ORDER BY `cgORDER` ASC, `cgID` ASC");
        $rows = $db->num_rows($q);
        $i = 0;
        $csrf = request_csrf_html('staff_reorder_crimegroups');
        echo "
        <h3>Re-ordering Crime Groups</h3><hr />
        <table width='100%' cellspacing='1' cellpadding='1' class='table'>
        		<tr>
        	<th>Crime Group</th>
        	<th>Order</th>
        		</tr>
        <form action='staff_crimes.php?action=reorder' method='post'>
        	<input type='hidden' name='submit' value='1' />
        	{$csrf}
           ";
        while ($r = $db->fetch_row($q))
        {
            $i++;
            echo "
    		<tr>
    			<td>{$r['cgNAME']}</td>
    			<td><select name='order{$r['cgID']}' type='dropdown'>
       		";
            for ($j = 1; $j <= $rows; $j++)
            {
                if ($j == $i)
                {
                    echo "<option value='{$j}' selected='selected'>{$j}</option>";
                }
                else
                {
                    echo "<option value='{$j}'>{$j}</option>";
                }
            }
            echo '
					</select>
				</td>
			</tr>
   			';
        }
        $db->free_result($q);
        echo "
			<tr>
				<td colspan='2' align='center'><input type='submit' value='Reorder' /></td>
			</tr>
		</form>
		</table>
   		";
    }
}
$h->endpage();
