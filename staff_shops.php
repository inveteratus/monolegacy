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
 * File: staff_shops.php
 * Signature: 6f5b0e2891f00ad7e02a12bae02f1c03
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('sglobals.php');
if ($ir['user_level'] != 2)
{
    echo 'You cannot access this area.<br />&gt; <a href="staff.php">Go Back</a>';
    die($h->endpage());
}
if (!isset($_GET['action']))
{
    $_GET['action'] = '';
}
switch ($_GET['action'])
{
case 'newshop':
    new_shop_form();
    break;
case 'newshopsub':
    new_shop_submit();
    break;
case 'newstock':
    new_stock_form();
    break;
case 'newstocksub':
    new_stock_submit();
    break;
case 'delshop':
    delshop();
    break;
default:
    echo "Error: This script requires an action.";
    break;
}

function new_shop_form()
{
    global $db, $ir, $c, $h;
    $csrf = request_csrf_html('staff_newshop');
    echo "
    <h3>Adding a New Shop</h3>
    <form action='staff_shops.php?action=newshopsub' method='post'>
    	Shop Name: <input type='text' name='sn' value='' />
    	<br />
    	Shop Desc: <input type='text' name='sd' value='' />
    	<br />
    	Shop Location: " . location_dropdown(NULL, "sl")
            . "
    	<br />
    	{$csrf}
    	<input type='submit' value='Create Shop' />
    </form>
       ";
}

function new_shop_submit()
{
    global $db, $ir, $c, $h;
    staff_csrf_stdverify('staff_newshop', 'staff_shops.php?action=newshop');
    $_POST['sl'] =
            (isset($_POST['sl']) && is_numeric($_POST['sl']))
                    ? abs(intval($_POST['sl'])) : 0;
    $_POST['sn'] =
            (isset($_POST['sn'])
                    && preg_match(
                            "/^[a-z0-9_]+([\\s]{1}[a-z0-9_]|[a-z0-9_])+$/i",
                            $_POST['sn']))
                    ? $db->escape(strip_tags(stripslashes($_POST['sn']))) : '';
    $_POST['sd'] =
            (isset($_POST['sd']))
                    ? $db->escape(strip_tags(stripslashes($_POST['sd']))) : '';
    if (empty($_POST['sn']) || empty($_POST['sd']))
    {
        echo 'You missed a field, go back and try again.<br />
        &gt; <a href="staff_shops.php?action=newshop">Go Back</a>';
    }
    else
    {
        $q =
                $db->query(
                        'SELECT COUNT(`cityid`)
                         FROM `cities`
                         WHERE `cityid` = ' . $_POST['sl']);
        if ($db->fetch_single($q) == 0)
        {
            $db->free_result($q);
            echo 'Location doesn\'t seem to exist.<br />
            &gt; <a href="staff_shops.php?action=newshop">Go Back</a>';
            die($h->endpage());
        }
        $db->free_result($q);
        $db->query(
                "INSERT INTO `shops`
                VALUES(NULL, {$_POST['sl']}, '{$_POST['sn']}', '{$_POST['sd']}')");
        stafflog_add('Added Shop ' . $_POST['sn']);
        echo 'The ' . $_POST['sn']
                . ' Shop was successfully added to the game.<br />
                &gt; <a href="staff.php">Go Home</a>';
        die($h->endpage());
    }
}

function new_stock_form()
{
    global $db, $ir, $c, $h;
    $csrf = request_csrf_html('staff_newstock');
    echo "
    <h3>Adding an item to a shop</h3>
    <form action='staff_shops.php?action=newstocksub' method='post'>
    	Shop: " . shop_dropdown(NULL, "shop") . "
    	<br />
    	Item: " . item_dropdown(NULL, "item")
            . "
    	<br />
    	{$csrf}
    	<input type='submit' value='Add Item To Shop' />
    </form>
       ";
}

function new_stock_submit()
{
    global $db, $ir, $c, $h;
    staff_csrf_stdverify('staff_newstock', 'staff_shops.php?action=newstock');
    $_POST['shop'] =
            (isset($_POST['shop']) && is_numeric($_POST['shop']))
                    ? abs(intval($_POST['shop'])) : '';
    $_POST['item'] =
            (isset($_POST['item']) && is_numeric($_POST['item']))
                    ? abs(intval($_POST['item'])) : '';
    if (empty($_POST['shop']) || empty($_POST['item']))
    {
        echo 'Invalid shop/item.<br />
        &gt; <a href="staff_shops.php?action=newstock">Go Back</a>';
        die($h->endpage());
    }
    $q =
            $db->query(
                    'SELECT COUNT(`shopID`)
                     FROM `shops`
                     WHERE `shopID` = ' . $_POST['shop']);
    $q2 =
            $db->query(
                    'SELECT COUNT(`itmid`)
                     FROM `items`
                     WHERE `itmid` = ' . $_POST['item']);
    if ($db->fetch_single($q) == 0 || $db->fetch_single($q2) == 0)
    {
        $db->free_result($q);
        $db->free_result($q2);
        echo 'Invalid shop/item.<br />
        &gt; <a href="staff_shops.php?action=newstock">Go Back</a>';
        die($h->endpage());
    }
    $db->free_result($q);
    $db->free_result($q2);
    $db->query(
            "INSERT INTO `shopitems`
             VALUES(NULL, {$_POST['shop']}, {$_POST['item']})");
    stafflog_add(
            'Added Item ID ' . $_POST['item'] . ' to shop ID '
                    . $_POST['shop']);
    echo 'Item ID ' . $_POST['item'] . ' was successfully added to shop ID '
            . $_POST['shop']
            . '<br />
            &gt; <a href="staff.php">Go Home</a>';
    die($h->endpage());
}

function delshop()
{
    global $db, $ir, $c, $h;
    $_POST['shop'] =
            (isset($_POST['shop']) && is_numeric($_POST['shop']))
                    ? abs(intval($_POST['shop'])) : '';
    if (!empty($_POST['shop']))
    {
        staff_csrf_stdverify('staff_delshop', 'staff_shops.php?action=delshop');
        $shpq =
                $db->query(
                        "SELECT `shopNAME`
        				 FROM `shops`
        				 WHERE `shopID` = {$_POST['shop']}");
        if ($db->num_rows($shpq) == 0)
        {
            $db->free_result($shpq);
            echo "Invalid shop.<br />
            &gt; <a href='staff_shops.php?action=delshop'>Go back</a>";
            die($h->endpage());
        }
        $sn = $db->fetch_single($shpq);
        $db->free_result($shpq);
        $db->query(
                "DELETE FROM `shops`
         		 WHERE `shopID` = {$_POST['shop']}");
        $db->query(
                "DELETE FROM `shopitems`
                 WHERE `sitemSHOP` = {$_POST['shop']}");
        stafflog_add('Deleted Shop ' . $sn);
        echo 'Shop ' . $sn
                . ' Deleted.<br />
                &gt; <a href="staff.php">Go Home</a>';
        die($h->endpage());
    }
    else
    {
        $csrf = request_csrf_html('staff_delshop');
        echo "
        <h3>Delete Shop</h3>
        <hr />
        Deleting a shop will remove it from the game permanently. Be sure.
        <form action='staff_shops.php?action=delshop' method='post'>
        	Shop: " . shop_dropdown(NULL, "shop")
                . "
        	<br />
        	{$csrf}
        	<input type='submit' value='Delete Shop' />
        </form>
           ";
    }
}
$h->endpage();
