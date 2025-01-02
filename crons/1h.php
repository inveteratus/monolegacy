<?php

require __DIR__ . '/../includes/config.php';
global $_CONFIG;

require __DIR__ . '/../includes/database.php';
$db = new database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

$db->execute('UPDATE gangs SET gangCHOURS = gangCHOURS - 1 WHERE gangCRIME > 0');

$sql = <<<SQL
    SELECT g.gangID, oc.ocSTARTTEXT, oc.ocSUCCTEXT, oc.ocFAILTEXT, oc.ocMINMONEY, oc.ocMAXMONEY, oc.ocID, oc.ocNAME
    FROM gangs g
    LEFT JOIN orgcrimes oc ON oc.ocID = g.gangCRIME
    WHERE g.gangCRIME > 0 AND g.gangCHOURS <= 0
SQL;
$gangs = $db->execute($sql)->fetchAll(PDO::FETCH_ASSOC);

foreach ($gangs as $r) {
    $suc = rand(0, 1);
    if ($suc)
    {
        $log = $r['ocSTARTTEXT'] . $r['ocSUCCTEXT'];
        $muny = (int) (rand($r['ocMINMONEY'], $r['ocMAXMONEY']));
        $log = $db->escape(str_replace('{muny}', $muny, $log));
        $db->query(
                "UPDATE `gangs` SET `gangMONEY` = `gangMONEY` + {$muny}, `gangCRIME` = 0 WHERE `gangID` = {$r['gangID']}");
        $db->query(
                "INSERT INTO `oclogs` VALUES (NULL, {$r['ocID']}, {$r['gangID']},
                        '$log', 'success', $muny, '{$r['ocNAME']}', " . time()
                        . ")");
        $i = $db->insert_id();
        $qm =
                $db->query(
                        "SELECT `userid` FROM `users` WHERE `gang` = {$r['gangID']}");
        while ($rm = $db->fetch_row($qm))
        {
            addEvent($rm['userid'],
                    "Your Gang's Organised Crime Succeeded. Go <a href='oclog.php?ID=$i'>here</a> to view the details.",
                    NULL);
        }
        $db->free_result($qm);
    }
    else
    {
        $log = $r['ocSTARTTEXT'] . $r['ocFAILTEXT'];
        $muny = 0;
        $log = $db->escape(str_replace('{muny}', $muny, $log));
        $db->query(
                "UPDATE `gangs` SET `gangCRIME` = 0 WHERE `gangID` = {$r['gangID']}");
        $db->query(
                "INSERT INTO `oclogs` VALUES (NULL,{$r['ocID']},{$r['gangID']},
                         '$log', 'failure', $muny, '{$r['ocNAME']}', "
                        . time() . ")");
        $i = $db->insert_id();
        $qm =
                $db->query(
                        "SELECT `userid` FROM `users` WHERE `gang` = {$r['gangID']}");
        while ($rm = $db->fetch_row($qm))
        {
            addEvent($rm['userid'],
                    "Your Gang's Organised Crime Failed. Go <a href='oclog.php?ID=$i'>here</a> to view the details.");
        }
    }
}

if (date('G') == 17)
{
    // Job stats update
    $db->query(
            "UPDATE `users` AS `u`
    		    INNER JOIN `userstats` AS `us` ON `u`.`userid` = `us`.`userid`
    		    LEFT JOIN `jobranks` AS `jr` ON `jr`.`jrID` = `u`.`jobrank`
    		    SET `u`.`money` = `u`.`money` + `jr`.`jrPAY`, `u`.`exp` = `u`.`exp` + (`jr`.`jrPAY` / 20),
    		    `us`.`strength` = (`us`.`strength` + 1) + `jr`.`jrSTRG` - 1,
    		    `us`.`labour` = (`us`.`labour` + 1) + `jr`.`jrLABOURG` - 1,
    		    `us`.`IQ` = (`us`.`IQ`+1) + `jr`.`jrIQG` - 1
    		    WHERE `u`.`job` > 0 AND `u`.`jobrank` > 0");
}
