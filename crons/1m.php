<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Classes\Database;

require __DIR__ . '/../public/config.php';

global $_CONFIG;

$db = new Database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

$sql = <<<SQL
    UPDATE users
    SET hospital = GREATEST(0, hospital - 1), jail = GREATEST(0, jail - 1)
SQL;
$db->execute($sql);

$sql = <<<SQL
    UPDATE settings
    SET conf_value = (SELECT COUNT(*) FROM users WHERE hospital > 0)
    WHERE conf_name = :conf_name
SQL;
$db->execute($sql, ['conf_name' => 'hospital_count']);

$sql = <<<SQL
    UPDATE settings
    SET conf_value = (SELECT COUNT(*) FROM users WHERE jail > 0)
    WHERE conf_name = :conf_name
SQL;
$db->execute($sql, ['conf_name' => 'jail_count']);
