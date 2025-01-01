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
 * File: cyberbank.php
 * Signature: 09eb6913691ece5fb0a17394956b4df5
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
echo "<h3>Cyber Bank</h3>";
$bank_cost = 10000000;
$bank_maxfee_dp = 1500000;
$bank_feepercent_dp = 15;
$bank_maxfee_wd = 750000;
$bank_feepercent_wd = 7.5;
if ($ir['cybermoney'] > -1)
{
    if (!isset($_GET['action']))
    {
        $_GET['action'] = '';
    }
    switch ($_GET['action'])
    {
    case "deposit":
        deposit();
        break;

    case "withdraw":
        withdraw();
        break;

    default:
        index();
        break;
    }

}
else
{
    if (isset($_GET['buy']))
    {
        if ($ir['money'] >= $bank_cost)
        {
            echo "Congratulations, you bought a bank account for "
                    . money_formatter($bank_cost)
                    . "!<br />
<a href='cyberbank.php'>Start using my account</a>";
            $db->query(
                    "UPDATE `users`
                             SET `money` = `money` - {$bank_cost},
                             `cybermoney` = 0
                             WHERE `userid` = $userid");
        }
        else
        {
            echo "You do not have enough money to open an account.
<a href='explore.php'>Back to town...</a>";
        }
    }
    else
    {
        echo "Open a bank account today, just " . money_formatter($bank_cost)
                . "!<br />
<a href='cyberbank.php?buy'>&gt; Yes, sign me up!</a>";
    }
}

function index()
{
    global $db, $ir, $c, $userid, $h, $bank_maxfee_dp, $bank_feepercent_dp, $bank_maxfee_wd, $bank_feepercent_wd;
    echo "\n<b>You currently have " . money_formatter($ir['cybermoney'])
            . " in the bank.</b><br />
At the end of each day, your bank balance will go up by 7%.<br />
<table width='75%' border='2'> <tr> <td width='50%'><b>Deposit Money</b><br />
It will cost you {$bank_feepercent_dp}% of the money you deposit, rounded up.
The maximum fee is " . money_formatter($bank_maxfee_dp)
            . ".<form action='cyberbank.php?action=deposit' method='post'>
Amount: <input type='text' name='deposit' value='{$ir['money']}' /><br />
<input type='submit' value='Deposit' /></form></td> <td>
<b>Withdraw Money</b><br />
It will cost you {$bank_feepercent_wd}% of the money you withdraw, rounded up.
The maximum fee is " . money_formatter($bank_maxfee_wd)
            . ".<form action='cyberbank.php?action=withdraw' method='post'>
Amount: <input type='text' name='withdraw' value='{$ir['cybermoney']}' /><br />
<input type='submit' value='Withdraw' /></form></td> </tr> </table>";
}

function deposit()
{
    global $db, $ir, $c, $userid, $h, $bank_maxfee_dp, $bank_feepercent_dp;
    $_POST['deposit'] =
            (isset($_POST['deposit']) && is_numeric($_POST['deposit']))
                    ? abs((int) $_POST['deposit']) : 0;
    if ($_POST['deposit'] > $ir['money'])
    {
        echo "You do not have enough money to deposit this amount.";
    }
    else if ($_POST['deposit'] == 0)
    {
        echo "There's no point depositing nothing.";
    }
    else
    {
        $fee = ceil($_POST['deposit'] * $bank_feepercent_dp / 100);
        if ($fee > $bank_maxfee_dp)
        {
            $fee = $bank_maxfee_dp;
        }
        $gain = $_POST['deposit'] - $fee;
        $ir['cybermoney'] += $gain;
        $db->query(
                "UPDATE `users`
                SET `cybermoney` = `cybermoney` + $gain,
                `money` = `money` - {$_POST['deposit']}
                WHERE `userid` = $userid");
        echo "You hand over " . money_formatter($_POST['deposit'])
                . " to be deposited, <br />
after the fee is taken (" . money_formatter($fee) . "), "
                . money_formatter($gain)
                . " is added to your account. <br />
<b>You now have " . money_formatter($ir['cybermoney'])
                . " in the Cyber Bank.</b><br />
<a href='cyberbank.php'>&gt; Back</a>";
    }
}

function withdraw()
{
    global $db, $ir, $c, $userid, $h, $bank_maxfee_wd, $bank_feepercent_wd;
    $_POST['withdraw'] =
            (isset($_POST['withdraw']) && is_numeric($_POST['withdraw']))
                    ? abs((int) $_POST['withdraw']) : 0;
    if ($_POST['withdraw'] > $ir['cybermoney'])
    {
        echo "You do not have enough banked money to withdraw this amount.";
    }
    else if ($_POST['withdraw'] == 0)
    {
        echo "There's no point withdrawing nothing.";
    }
    else
    {
        $fee = ceil($_POST['withdraw'] * $bank_feepercent_wd / 100);
        if ($fee > $bank_maxfee_wd)
        {
            $fee = $bank_maxfee_wd;
        }
        $gain = $_POST['withdraw'] - $fee;
        $ir['cybermoney'] -= $gain;
        $db->query(
                "UPDATE `users`
                SET `cybermoney` = `cybermoney` - $gain,
                `money` = `money` + $gain
        		WHERE `userid` = $userid");
        echo "You ask to withdraw " . money_formatter($gain)
                . ", <br />
the teller hands it over after she takes the bank fees. <br />
<b>You now have " . money_formatter($ir['cybermoney'])
                . " in the Cyber Bank.</b><br />
<a href='cyberbank.php'>&gt; Back</a>";
    }
}
$h->endpage();
