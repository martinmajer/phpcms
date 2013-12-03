<?php
error_reporting(E_ALL | E_STRICT);

session_start();

// nastavení a připojení k databázi
require dirname(__FILE__) . "/config.php";
require dirname(__FILE__) . "/mysqli.php";

// načtení knihoven
foreach (glob(dirname(__FILE__) . "/lib/*.php") as $filename) require_once $filename;

// načtení modulů
loadModule("core");
foreach (glob(dirname(__FILE__) . "/modules/*", GLOB_ONLYDIR) as $dirname) {
    $moduleName = basename($dirname);
    if ($moduleName != "core") loadModule($moduleName);
}

define("ADMIN_DIR", dirname(__FILE__) . "/admin");
