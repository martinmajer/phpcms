<?php

/** Vrátí požadovanou stránku na webu a případně zajistí přesměrování. */
function getRequestUri() {
    $requestUri = strtok($_SERVER['REQUEST_URI'], '?');
    $queryString = strtok('?');
    if (WWW_BASEDIR !== "" && strpos($requestUri, WWW_BASEDIR) === 0) { // odstranění BASE_DIR
        $requestUri = substr($requestUri, strlen(WWW_BASEDIR));
    }
    if ($requestUri !== "/" && substr($requestUri, 0, 1) === "/") { // odstranění počátečního lomítka
        $requestUri = substr($requestUri, 1);
    }
    // přesměrování indexu na .
    if ($requestUri == "index.php") { 
        header("Location: " . WWW_BASEDIR . "/"); exit;
    }
    // přesměrování adresy s / na konci na adresu bez / na konci
    if ($requestUri !== "/" && substr($requestUri, strlen($requestUri)-1, 1) === "/") {
        $newUri = substr($requestUri, 0, strlen($requestUri)-1);
        header("Location: " . WWW_BASEDIR . "/" . $newUri . ($queryString ? "?" . $queryString : "")); exit;
    }
    return $requestUri;
}

function header_500() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo "<h1>HTTP 500</h1>";
    exit;
}

function header_404() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Page Not Found', true, 404);
    echo "<h1>HTTP 404</h1>";
    exit;
}

function param_get($name, $trim = true) {
    if (isset($_GET[$name])) {
        if ($trim) return trim($_GET[$name]);
        else return $_GET[$name];
    }
    else return null;
}

function param_post($name, $trim = true) {
    if (isset($_POST[$name])) {
        if ($trim) return trim($_POST[$name]);
        else return $_POST[$name];
    }
    else return null;
}

function makeLink($slug) {
    if ($slug == "/") return WWW_BASEDIR . "/";
    else return WWW_BASEDIR . "/" . $slug;
}

function getContent() {
    global $_content;
    return $_content;
}

function loadModule($name) {
    foreach (glob(dirname(__FILE__) . "/../modules/" . $name . "/*.php") as $filename) require_once $filename;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function form_isSubmittedBy($name, $method = "post") {
    if ($method == "post") {
        return isset($_POST[$name]);
    }
    else if ($method == "get") {
        return isset($_GET[$name]);
    }
    else return false;
}

$_form_errors = array();
$_form_success = "";

function form_addError($message) {
    global $_form_errors;
    $_form_errors[] = $message;
}

function form_isOk() {
    global $_form_errors;
    return !$_form_errors;
}

function form_getErrors() {
    global $_form_errors;
    return $_form_errors;
}

function form_setSuccessMessage($msg) {
    global $_form_success;
    $_form_success = $msg;
    $_SESSION['formSuccessMessage'] = $msg;
}

function form_getSuccessMessage() {
    global $_form_success;
    if (isset($_SESSION['formSuccessMessage'])) {
        $_form_success = $_SESSION['formSuccessMessage'];
        unset($_SESSION['formSuccessMessage']);
    }
    return $_form_success;
}

function form_writeErrors() {
    $errors = form_getErrors();
    echo "<div class=\"alert alert-error\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
    $first = true;
    foreach ($errors as $e) {
        if ($first) $first = false;
        else echo "<br/>";
        echo $e;
    }
    echo "</div>", PHP_EOL;
}

function form_writeSuccessMessage() {
    echo "<div class=\"alert alert-success\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
    echo form_getSuccessMessage();
    echo "</div>", PHP_EOL;
}

function form_showMessages() {
    if (form_getErrors()) form_writeErrors();
    else if (form_getSuccessMessage()) form_writeSuccessMessage();
}

function fix($input) {
    return htmlspecialchars($input);
}

function formatDate($timestamp) {
    return date("j.n.Y", $timestamp);
}

function formatTime($timestamp) {
    return date("j.n.Y H:i:s", $timestamp);
}

function parseDatetime($datetime) {
    if (!$datetime) return false;
    $datetime = str_replace(". ", ".", $datetime);
    
    $parts = explode(" ", $datetime);
    
    if (count($parts) < 2) $parts[] = "0:00:00";
    else if (count($parts) > 2) return false;
    
    $dateParts = explode(".", $parts[0]);
    if (count($dateParts) != 3) return false;
    $year = (int)$dateParts[2];
    $month = (int)$dateParts[1];
    $day = (int)$dateParts[0];
    
    $timeParts = explode(":", $parts[1]);
    if (count($timeParts) != 3 && count($timeParts) != 2) return false;
    $hour = (int)$timeParts[0];
    $minute = (int)$timeParts[1];
    $second = @(int)$timeParts[2];
    
    return mktime($hour, $minute, $second, $month, $day, $year);
}

// @todo funkce na zkracování textu
