<?php

if (strpos($_SERVER['PHP_SELF'], "globals_nonauth.php") !== false)
{
    exit;
}
session_name('MCCSID');
@session_start();
if (!isset($_SESSION['started']))
{
    session_regenerate_id();
    $_SESSION['started'] = true;
}
ob_start();
if (function_exists("get_magic_quotes_gpc") == false)
{

    function get_magic_quotes_gpc()
    {
        return 0;
    }
}
if (get_magic_quotes_gpc() == 0)
{
    foreach ($_POST as $k => $v)
    {
        $_POST[$k] = addslashes($v);
    }
    foreach ($_GET as $k => $v)
    {
        $_GET[$k] = addslashes($v);
    }
}
require __DIR__ . '/lib/basic_error_handler.php';
set_error_handler('error_php');
require __DIR__ . '/config.php';
global $_CONFIG;
define("MONO_ON", 1);
require __DIR__ . '/database.php';
require __DIR__ .  '/global_func.php';
$db = new database;
$db->configure($_CONFIG['hostname'], $_CONFIG['username'],
        $_CONFIG['password'], $_CONFIG['database']);
$db->connect();
$c = $db->connection_id;
$set = array();
$settq = $db->query("SELECT *
					 FROM `settings`");
while ($r = $db->fetch_row($settq))
{
    $set[$r['conf_name']] = $r['conf_value'];
}
