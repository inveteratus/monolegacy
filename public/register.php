<?php

require __DIR__ . '/config.php';
global $_CONFIG;

require __DIR__ . '/database.php';
$db = new database($_CONFIG['db.dsn'], $_CONFIG['db.user'], $_CONFIG['db.password']);

session_start(['name' => 'MCCSID']);
if (array_key_exists('userid', $_SESSION) && ($_SESSION['userid'] > 0)) {
    header('Location: /');
    exit;
}

$name = $email = '';
$errors = ['name' => '', 'email' => '', 'password' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = array_key_exists('name', $_POST) && is_string($_POST['name']) ? trim($_POST['name']) : '';
    $email = array_key_exists('email', $_POST) && is_string($_POST['email']) ? trim($_POST['email']) : '';
    $password = array_key_exists('password', $_POST) && is_string($_POST['password']) ? trim($_POST['password']) : '';

    if (!strlen($name)) {
        $errors['name'] = 'Name is required';
    }
    else if ($db->execute('SELECT COUNT(*) FROM users WHERE username = :name', ['name' => $name])->fetchColumn()) {
        $errors['name'] = 'Name is already in use';
    }

    if (!strlen($email)) {
        $errors['email'] = 'Name is required';
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address';
    }
    else if ($db->execute('SELECT COUNT(*) FROM users WHERE email = :email', ['email' => $email])->fetchColumn()) {
        $errors['name'] = 'Email is already in use';
    }

    if (!strlen($password)) {
        $errors['password'] = 'Password is required';
    }
    else if (strlen($password) < 8) {
        $errors['password'] = 'Password too short';
    }

    if (!implode('', $errors)) {
        $salt = substr(implode('', array_filter(str_split(random_bytes(100)), 'ctype_alnum')), -8);
        $sql = <<<SQL
            INSERT INTO users (username, userpass, gender, signedup, email, lastip_login, lastip_signup, last_login, pass_salt)
            VALUES (:username, :userpass, :gender, :signedup, :email, :lastip_login, :lastip_signup, :last_login, :pass_salt)
        SQL;
        $db->execute($sql, [
            'username' => $name,
            'userpass' => md5($salt . md5($password)),
            'gender' => ['Male', 'Female'][random_int(0, 1)],
            'signedup' => time(),
            'email' => $email,
            'lastip_login' => $_SERVER['REMOTE_ADDR'],
            'lastip_signup' => $_SERVER['REMOTE_ADDR'],
            'last_login' => time(),
            'pass_salt' => $salt,
        ]);
        $userid = $db->lastInsertId();
        $sql = <<<SQL
            INSERT INTO userstats (userid, strength, agility, guard, labour, IQ)
            VALUES (:userid, 10, 10, 10, 10, 10)
        SQL;
        $db->execute($sql, ['userid' => $userid]);

        $_SESSION = ['loggedin' => true, 'userid' => $userid];

        session_regenerate_id();
        session_write_close();

        header('Location: /loggedin.php');
        exit;
    }

    $name = htmlentities($name);
    $email = htmlentities($email);
    $errors = array_map(fn (string $error) => '<span class="text-sm text-red-500">' . htmlentities($error) . '</span>', $errors);
}

ob_start(fn (string $html) => preg_replace('`>\s+<`', '><', trim($html)));

echo <<<HTML
    <!DOCTYPE html>
    <html lang="en-GB">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Monolegacy</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-200 flex flex-col items-center justify-center min-h-screen text-slate-700">
        <form action="/register.php" method="post" class="bg-slate-100 rounded-md px-8 py-6 shadow border border-slate-300 max-w-md w-full flex flex-col space-y-3">
            <div class="flex flex-col">
                <label for="name" class="text-sm font-medium text-slate-600">Name</label>
                <input id="name" type="text" name="name" value="{$name}" maxlength="25" autofocus autocomplete="name" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
                {$errors['name']}            
            </div>            
            <div class="flex flex-col">
                <label for="email" class="text-sm font-medium text-slate-600">Email</label>
                <input id="email" type="email" name="email" value="{$email}" maxlength="250" autocomplete="email" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
                {$errors['email']}            
            </div>            
            <div class="flex flex-col">
                <label for="password" class="text-sm font-medium text-slate-600">Password</label>            
                <input id="password" type="password" name="password" autocomplete="new-password" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />            
                {$errors['password']}            
            </div>            
            <div class="flex pt-3">
                <button type="submit" class="bg-blue-500 text-white font-medium px-3 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-100 focus:ring-blue-500">Register</button>
            </div>            
        </form>
        <p class="pt-2 text-center text-sm"><a href="/login.php" class="text-slate-700 hover:underline focus:underline focus:outline-none">Already got an account ?</a></p>
    </body>
    </html>
HTML;
