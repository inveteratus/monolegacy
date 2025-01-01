<?php

require __DIR__ . '/../public/globals_nonauth.php';

global $db, $set;

$ver_reset = false;
if ($set['validate_period'] == 5 && $set['validate_on'])
{
    $ver_reset = true;
}
if ($set['validate_period'] == 15 && $set['validate_on']
        && in_array(date('i'), array("00", "15", "30", "45")))
{
    $ver_reset = true;
}
// update for all users
$allusers_query =
        "UPDATE `users`
        SET `brave` = LEAST(`brave` + ((`maxbrave` / 10) + 0.5), `maxbrave`),
        `hp` = LEAST(`hp` + (`maxhp` / 3), `maxhp`),
        `will` = LEAST(`will` + 10, `maxwill`),
        `energy` = IF(`donatordays` > 0,
                   LEAST(`energy` + (`maxenergy` / 6), `maxenergy`),
                   LEAST(`energy` + (`maxenergy` / 12.5), `maxenergy`))"
                . ($ver_reset ? ', `verified` = 0' : '');
$db->query($allusers_query);
