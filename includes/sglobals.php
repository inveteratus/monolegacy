<?php

use App\Classes\Database;
use Carbon\CarbonImmutable;

function staff_csrf_error($goBackTo)
{
    global $h;
    echo '<h3>Error</h3><hr />
    Your action has been blocked for security reasons.<br />
    &gt; <a href="' . $goBackTo . '">Try Again</a>';
    $h->endpage();
    exit;
}

/**
 * Check the CSRF code we received against the one that was registered for the form - using default code properties ($_POST['verf']).
 * If verification fails, end execution immediately.
 * If not, continue.
 * @param string $formid A unique string used to identify this form to match up its submission with the right token.
 * @param string $code The code the user's form input returned.
 */
function staff_csrf_stdverify($formid, $goBackTo)
{
    if (!isset($_POST['verf'])
            || !verify_csrf_code($formid, stripslashes($_POST['verf'])))
    {
        staff_csrf_error($goBackTo);
    }
}
if (session_status() == PHP_SESSION_NONE) {
    session_name('MCCSID');
    session_start();
}
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
$domain = determine_game_urlbase();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == 0)
{
    header("Location: /login");
    exit;
}
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
require __DIR__ . '/header.php';
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
global $jobquery, $housequery;
if (isset($jobquery) && $jobquery)
{
    $is =
            $db->query(
                    "SELECT `u`.*, `j`.*, `jr`.*
                     FROM `users` AS `u`
                     LEFT JOIN `jobs` AS `j` ON `j`.`jID` = `u`.`job`
                     LEFT JOIN `jobranks` AS `jr`
                     ON `jr`.`jrID` = `u`.`jobrank`
                     WHERE `u`.`userid` = '{$userid}'
                     LIMIT 1");
}
else if (isset($housequery) && $housequery)
{
    $is =
            $db->query(
                    "SELECT `u`.*, `h`.*
                     FROM `users` AS `u`
                     LEFT JOIN `houses` AS `h` ON `h`.`hWILL` = `u`.`maxwill`
                     WHERE `u`.`userid` = '{$userid}'
                     LIMIT 1");
}
else
{
    $is =
            $db->query(
                    "SELECT `u`.*
                     FROM `users` AS `u`
                     WHERE `u`.`userid` = '{$userid}'
                     LIMIT 1");
}
$ir = $db->fetch_row($is);
if ($ir['force_logout'] != '0')
{
    $db->query(
            "UPDATE `users`
    		 SET `force_logout` = 0
    		 WHERE `userid` = {$userid}");
    session_unset();
    session_destroy();
    header("Location: /login");
    exit;
}
if (!in_array($ir['user_level'], array(2, 3, 5)))
{
    echo 'This page cannot be accessed.<br />&gt; <a href="index.php">Go Home</a>';
    die;
}
check_level();
$h = new headers;
$h->startheaders();
$fm = money_formatter($ir['money']);
$cm = money_formatter($ir['crystals'], '');
$lv = CarbonImmutable::parse($ir['last_seen'])->timestamp;
global $atkpage;
$staffpage = 1;
if ($atkpage)
{
    $h->userdata($ir, $lv, $fm, $cm, 0);
}
else
{
    $h->userdata($ir, $lv, $fm, $cm);
}
$h->smenuarea();
