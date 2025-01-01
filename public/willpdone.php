<?php

require __DIR__ . '/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

if (!isset($_GET['action']))
{
    ob_get_clean();
    header('HTTP/1.1 400 Bad Request');
    exit;
}
if ($_GET['action'] == "cancel")
{
    echo 'You have cancelled your donation. Please donate later...';
}
else if ($_GET['action'] == "done")
{
    if (!$_GET['tx'])
    {
        echo 'Get a life.';
        die($h->endpage());
    }
    echo 'Thank you for your payment to ' . $set['game_name']
            . '. Your transaction has been completed, and a receipt for
            your purchase has been emailed to you. You may log into your
            account at <a href="http://www.paypal.com">www.paypal.com</a>
            to view details of this transaction.
            Your Will Potion should be credited within a few minutes,
            if not, contact an admin for assistance.';
}
$h->endpage();
