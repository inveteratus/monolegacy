<?php

require __DIR__ . '/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

if (!isset($_GET['type'])
        || !in_array($_GET['type'],
                array("equip_primary", "equip_secondary", "equip_armor"),
                true))
{
    echo 'This slot ID is not valid.';
    die($h->endpage());
}
if ($ir[$_GET['type']] == 0)
{
    echo 'You do not have anything equipped in this slot.';
    die($h->endpage());
}
item_add($userid, $ir[$_GET['type']], 1);
$db->query(
        "UPDATE `users`
        SET `{$_GET['type']}` = 0
        WHERE `userid` = {$ir['userid']}");
$names =
        array('equip_primary' => 'Primary Weapon',
                'equip_secondary' => 'Secondary Weapon',
                'equip_armor' => 'Armor');
echo 'The item in your ' . $names[$_GET['type']]
        . ' slot was successfully unequiped.';
$h->endpage();
