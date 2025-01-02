<?php

require __DIR__ . '/globals.php';

global $h, $ir, $db, $h, $userid;

if ($ir['jail'] || $ir['hospital'])
{
    die("This page cannot be accessed while in jail or hospital.");
}
$crimes = array();
$q2 =
        $db->query(
                "SELECT `crimeGROUP`, `crimeNAME`, `crimeBRAVE`, `crimeID`
                         FROM `crimes`
                         ORDER BY `crimeBRAVE` ASC");
while ($r2 = $db->fetch_row($q2))
{
    $crimes[] = $r2;
}
$db->free_result($q2);
$q =
        $db->query(
                "SELECT `cgID`, `cgNAME` FROM `crimegroups` ORDER BY `cgORDER` ASC");
echo "<h3>Criminal Centre</h3><br />
<table width='75%' cellspacing='1' class='table'><tr><th>Crime</th><th>Cost</th><th>Do</th></tr>";
while ($r = $db->fetch_row($q))
{
    echo "<tr><td colspan='3' class='h'>{$r['cgNAME']}</td></tr>";
    foreach ($crimes as $v)
    {
        if ($v['crimeGROUP'] == $r['cgID'])
        {
            echo "<tr><td>{$v['crimeNAME']}</td><td>{$v['crimeBRAVE']} Brave</td><td><a href='docrime.php?c={$v['crimeID']}'>Do</a></td></tr>";
        }
    }
}
$db->free_result($q);
echo "</table>";
$h->endpage();
