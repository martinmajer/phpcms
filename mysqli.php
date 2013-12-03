<?php

// připojení k databázi
$mysqli = @new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_errno) {
    header_500();
}

$mysqli->query("SET NAMES 'utf8'");

/** @return mysqli */
function db() {
    global $mysqli;
    return $mysqli;
}


function dbError() {
    return "Chyba v databázi: " . db()->error;
}
