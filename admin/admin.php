<?php
require dirname(__FILE__) . "/../bootstrap.php";

define("ADMIN_BASEDIR", WWW_BASEDIR . "/admin");

$user = null; /* @var $user User */
$userFactory = new UserFactory();

// obsluha přihlášení
if (param_post("login")) {
    $username = param_post("username");
    $password = param_post("password");
    
    $user = $userFactory->findUser($username, $password);
    
    if ($user == null) $loginFailed = true;
    else {
        $_SESSION['user'] = $user->id;
        $user->updateLastLogin();
    }
}

// odhlášení
if (param_get("logout")) {
    unset($_SESSION['user']);
}

// nepřihlášený uživatel
if (!isset($_SESSION['user'])) {
    include dirname(__FILE__) . "/login.php";
    exit;
}

if (!$user) $user = $userFactory->loadSingle($_SESSION['user']);
$showMenu = true;
