<?php

global $db, $ir, $userid;

$ac = number_format($ir['new_announcements']);

echo <<<HTML
	<a href="/gym.php">Gym</a><br />
	<a href="/criminal.php">Crimes</a><br />
	<a href="/job.php">Your Job</a><br />
	<a href="/education.php">Local School</a><br />
    <a href="/announcements.php">Announcements ({$ac})</a><br />
    <a href="/newspaper.php">Newspaper</a><br />
    <a href="/search.php">Search</a><br />
    <a href="/yourgang.php">Your Gang</a><br />
HTML;

if ($ir['user_level'] > 1) {
    echo <<<HTML
        <hr />
        <strong>Staff</strong><br />
        <a href="/staff.php">Staff Panel</a><br />
        <hr />
        <strong>Staff Online</strong><br />
    HTML;
    $staff = $db->execute('SELECT userid AS id, username AS name FROM users WHERE user_level > 1 AND laston > :time', ['time' => time() - 900])->fetchAll();
    foreach ($staff as $user) {
        $name = htmlentities($user->name);
        echo <<<HTML
            <a href="/viewuser.php?u={$user->id}">{$name}</a><br />       
        HTML;
    }
}

if ($ir['donatordays']) {
    echo <<<HTML
        <hr />
        <strong>Donators</strong><br />
        <a href="/friendslist.php">Friends List</a><br />
        <a href="/blacklist.php">Black List</a><br />
    HTML;
}

echo <<<HTML
    <hr />
    <a href="/preferences.php">Preferences</a><br />
    <a href="/preport.php">Player Report</a><br />
    <a href="/helptutorial.php">Help Tutorial</a><br />
    <a href="/gamerules.php">Game Rules</a><br />
    <a href="/viewuser.php?u={$userid}">My Profile</a><br />
    <a href="/logout.php">Logout</a><br />
HTML;
