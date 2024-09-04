<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Classes\Database;

require __DIR__ . '/../public/config.php';

global $_CONFIG;

$db = new Database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

$sql = <<<SQL
    UPDATE users
    SET brave = LEAST(maxbrave, brave + maxbrave / 10 + 0.5),
        energy = LEAST(maxenergy, energy + maxenergy / IF(donatordays > 0, 6, 12.5)),
        hp = LEAST(maxhp, hp + maxhp / 5),
        will = LEAST(maxwill, will + 10)
SQL;
$db->execute($sql);

$sql = <<<SQL
    SELECT conf_name, conf_value
    FROM settings
SQL;
$settings = $db->execute($sql)->fetchAll(PDO::FETCH_KEY_PAIR);

if ($settings['validate_on'] && ($settings['validate_period'] == 5)) {
    $db->execute('UPDATE users SET verified = 0');
}
