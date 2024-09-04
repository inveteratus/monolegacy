<?php

use App\Classes\Database;

session_name('MCCSID');
@session_start();
if (!isset($_SESSION['started']))
{
    session_regenerate_id();
    $_SESSION['started'] = true;
}
ob_start();
foreach ($_POST as $k => $v)
{
    $_POST[$k] = addslashes($v);
}
foreach ($_GET as $k => $v)
{
    $_GET[$k] = addslashes($v);
}
require __DIR__ . '/basic_error_handler.php';
set_error_handler('error_php');
require __DIR__ . '/global_func.php';
require __DIR__ . '/config.php';
global $_CONFIG;
$db = new Database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);
$db->configure($_CONFIG['hostname'], $_CONFIG['username'],
        $_CONFIG['password'], $_CONFIG['database'], $_CONFIG['persistent']);
$db->connect();
$c = $db->connection_id;
$set = array();
$settq = $db->query("SELECT *
					 FROM `settings`");
while ($r = $db->fetch_row($settq))
{
    $set[$r['conf_name']] = $r['conf_value'];
}
