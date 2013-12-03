<?php
require "./bootstrap.php";

// získání relativního URL stránky
$requestUri = getRequestUri();


// obsloužení požadavků
$_content = null; /* @var $_content Content */

$pageFactory = new PageFactory();
$_content = $pageFactory->getBySlug($requestUri);

if ($_content == null) {
    header_404();
}

$_content->render();


