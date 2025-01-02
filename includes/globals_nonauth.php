<?php

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
require __DIR__ . '/error_handler.php';
set_error_handler('error_php');

require __DIR__ . '/config.php';
global $_CONFIG;

require __DIR__ . '/global_func.php';

require __DIR__ . '/database.php';
$db = new database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);
$c = $db->connection();
$set = $db->execute('SELECT conf_name, conf_value FROM settings')->fetchAll(PDO::FETCH_KEY_PAIR);
