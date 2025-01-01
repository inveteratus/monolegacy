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
 * File: crystaltemple.php
 * Signature: 7385fd377cd3186c48ca655b7a5bab3b
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');

function csrf_error($goBackTo)
{
    global $h;
    echo '<h3>Error</h3><hr />
    Your purchase has been blocked for your security.<br />
    Please make crystal purchases quickly after you open the form
     - do not leave it open in tabs.<br />
    &gt; <a href="crystaltemple.php?spend=' . $goBackTo . '">Try Again</a>';
    $h->endpage();
    exit;
}
if (!isset($_GET['spend']))
{
    echo "Welcome to the crystal temple!<br />
You have <b>{$ir['crystals']}</b> crystals.<br />
What would you like to spend your crystals on?<br />
<br />
<a href='crystaltemple.php?spend=refill'>
Energy Refill - {$set['ct_refillprice']} Crystals
</a><br />
<a href='crystaltemple.php?spend=IQ'>
IQ - {$set['ct_iqpercrys']} IQ per crystal
</a><br />
<a href='crystaltemple.php?spend=money'>
Money - " . money_formatter($set['ct_moneypercrys'])
            . " per crystal</a><br />";
}
else
{
    if ($_GET['spend'] == 'refill')
    {
        if ($ir['crystals'] < $set['ct_refillprice'])
        {
            echo "You don't have enough crystals!";
        }
        else if ($ir['energy'] == $ir['maxenergy'])
        {
            echo "You already have full energy.";
        }
        else
        {
            $db->query(
                    "UPDATE `users`
                    SET `energy` = `maxenergy`,
                    `crystals` = `crystals` - {$set['ct_refillprice']}
                    WHERE `userid` = $userid");
            echo "You have paid {$set['ct_refillprice']} crystals to
                  refill your energy bar.";
        }
    }
    else if ($_GET['spend'] == 'IQ')
    {
        $iq_csrf = request_csrf_code('ctemple_iq');
        echo "Type in the amount of crystals you want to swap for IQ.<br />
			  You have <b>{$ir['crystals']}</b> crystals.<br />
		      One crystal = {$set['ct_iqpercrys']} IQ.
		      <form action='crystaltemple.php?spend=IQ2' method='post'>
		      <input type='text' name='crystals' /><br />
		      <input type='hidden' name='verf' value='{$iq_csrf}' />
		      <input type='submit' value='Swap' />
		      </form>";
    }
    else if ($_GET['spend'] == 'IQ2')
    {
        if (!isset($_POST['verf'])
                || !verify_csrf_code('ctemple_iq',
                        stripslashes($_POST['verf'])))
        {
            csrf_error('IQ');
        }
        $_POST['crystals'] =
                isset($_POST['crystals']) ? (int) $_POST['crystals'] : 0;
        if ($_POST['crystals'] <= 0 || $_POST['crystals'] > $ir['crystals'])
        {
            echo "Error, you either do not have enough crystals
                  or did not fill out the form.<br />
			      <a href='crystaltemple.php?spend=IQ'>Back</a>";
        }
        else
        {
            $iqgain = $_POST['crystals'] * $set['ct_iqpercrys'];
            $db->query(
                    "UPDATE `users`
                     SET `crystals` = `crystals` - {$_POST['crystals']}
                     WHERE `userid` = $userid");
            $db->query(
                    "UPDATE `userstats`
                    SET `IQ` = `IQ` + $iqgain
            		WHERE `userid` = $userid");
            echo "You traded {$_POST['crystals']} crystals for $iqgain IQ.";
        }
    }
    else if ($_GET['spend'] == 'money')
    {
        $m_csrf = request_csrf_code('ctemple_money');
        echo "Type in the amount of crystals you want to swap for money.<br />
			  You have <b>{$ir['crystals']}</b> crystals.<br />
			  One crystal = " . money_formatter($set['ct_moneypercrys'])
                . ".
              <form action='crystaltemple.php?spend=money2' method='post'>
              <input type='text' name='crystals' /><br />
              <input type='hidden' name='verf' value='{$m_csrf}' />
              <input type='submit' value='Swap' />
              </form>";
    }
    else if ($_GET['spend'] == 'money2')
    {
        if (!isset($_POST['verf'])
                || !verify_csrf_code('ctemple_money',
                        stripslashes($_POST['verf'])))
        {
            csrf_error('money');
        }
        $_POST['crystals'] =
                isset($_POST['crystals']) ? (int) $_POST['crystals'] : 0;
        if ($_POST['crystals'] <= 0 || $_POST['crystals'] > $ir['crystals'])
        {
            echo "Error, you either do not have enough crystals or did not
                  fill out the form.<br />
				  <a href='crystaltemple.php?spend=money'>Back</a>";
        }
        else
        {
            $iqgain = $_POST['crystals'] * $set['ct_moneypercrys'];
            $db->query(
                    "UPDATE `users`
                     SET `crystals` = `crystals` - {$_POST['crystals']},
                     `money` = `money` + $iqgain
            		 WHERE `userid` = $userid");
            echo "You traded {$_POST['crystals']} crystals for "
                    . money_formatter($iqgain) . ".";
        }
    }
}

$h->endpage();
