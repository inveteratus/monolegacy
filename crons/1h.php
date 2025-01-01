<?php

require __DIR__ . '/../public/globals_nonauth.php';

global $db, $c, $set;

$db->query(
        "UPDATE `gangs` SET `gangCHOURS` = `gangCHOURS` - 1 WHERE `gangCRIME` > 0");
$q =
        $db->query(
                "SELECT `gangID`,`ocSTARTTEXT`, `ocSUCCTEXT`, `ocFAILTEXT`,
                `ocMINMONEY`, `ocMAXMONEY`, `ocID`, `ocNAME`
                FROM `gangs` AS `g`
                LEFT JOIN `orgcrimes` AS `oc` ON `g`.`gangCRIME` = `oc`.`ocID`
                WHERE `g`.`gangCRIME` > 0 AND `g`.`gangCHOURS` <= 0");
while ($r = $db->fetch_row($q))
{
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
                    "Your Gang's Organised Crime Failed. Go <a href='oclog.php?ID=$i'>here</a> to view the details.",
                    $c);
        }
        $db->free_result($qm);
    }
}
$db->free_result($q);
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
if ($set['validate_period'] == 60 && $set['validate_on'])
{
    $db->query("UPDATE `users` SET `verified` = 0");
}
