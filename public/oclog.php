<?php

require __DIR__ . '/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

$_GET['ID'] =
        (isset($_GET['ID']) && is_numeric($_GET['ID']))
                ? abs(intval($_GET['ID'])) : 0;
if (empty($_GET['ID']))
{
    echo 'Invalid command.<br />
    &gt; <a href="index.php">Go Home</a>';
    die($h->endpage());
}
$q =
        $db->query(
                'SELECT `ocCRIMEN`, `ocTIME`, `oclLOG`, `oclRESULT`, `oclMONEY`
                 FROM `oclogs`
                 WHERE `oclID` = ' . $_GET['ID']);
if ($db->num_rows($q) == 0)
{
    $db->free_result($q);
    echo 'Invalid OC.<br />
    &gt; <a href="index.php">Go Home</a>';
    die($h->endpage());
}
$r = $db->fetch_row($q);
$db->free_result($q);
echo "
Here is the detailed view on this crime.
<br />
<b>Crime:</b> {$r['ocCRIMEN']}
<br />
<b>Time Executed:</b> " . date('F j, Y, g:i:s a', $r['ocTIME'])
        . "
<br />
        {$r['oclLOG']}
<br />
<br />
<b>Result:</b> {$r['oclRESULT']}
<br />
<b>Money Made:</b> " . money_formatter($r['oclMONEY']) . "
   ";
$h->endpage();
