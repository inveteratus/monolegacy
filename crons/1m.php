<?php

require __DIR__ . '/../includes/config.php';
global $_CONFIG;

require __DIR__ . '/../includes/database.php';
$db = new database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

$sql = <<<SQL
    UPDATE users
    SET hospital = IF(hospital > 0, hospital - 1, 0),
        jail = IF(jail > 0, jail - 1, 0)
SQL;
$db->execute($sql);

$sql = <<<SQL
    UPDATE settings
    SET conf_value = (SELECT COUNT(*) FROM users WHERE hospital > 0)
    WHERE conf_name = :name
SQL;
$db->execute($sql, ['name' => 'hospital_count']);

$sql = <<<SQL
    UPDATE settings
    SET conf_value = (SELECT COUNT(*) FROM users WHERE jail > 0)
    WHERE conf_name = :name
SQL;
$db->execute($sql, ['name' => 'jail_count']);
