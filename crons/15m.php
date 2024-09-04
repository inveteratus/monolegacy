<?php

require __DIR__ . '/../public/config.php';
require __DIR__ . '/../public/Database.php';

global $_CONFIG;

$db = new Database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

$sql = <<<SQL
    SELECT conf_name, conf_value
    FROM settings
SQL;
$settings = $db->execute($sql)->fetchAll(PDO::FETCH_KEY_PAIR);

if ($settings['validate_on'] && ($settings['validate_period'] == 15)) {
    $db->execute('UPDATE users SET verified = 0');
}
