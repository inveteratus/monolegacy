<?php

require __DIR__ . '/../includes/config.php';
global $_CONFIG;

require __DIR__ . '/../includes/database.php';
$db = new database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

$sql = <<<SQL
    UPDATE users
    SET brave = LEAST(brave + maxbrave / 10 + 0.5, maxbrave),
        energy = LEAST(energy + maxenergy / IF(donatordays > 0, 6, 12.5), maxenergy),
        hp = LEAST(hp + maxhp / 5, maxhp),
        will = LEAST(will + RAND() * 10 + 1, maxwill)
SQL;
$db->execute($sql);
