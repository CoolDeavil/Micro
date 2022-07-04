<?php

use API\Core\Container\MicroDI;
use API\Core\Render\PHPRender;
/**@var $renderer PHPRender */
/**@var $params array */
$ioc = MicroDI::getInstance([]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Micro</title>
    <link rel="stylesheet" href="{{ asset(css/main.min.css) }}">
    <style>
    </style>
</head>
<body>
<div class="appSideNavOverlay">
    <div class="appSideNav">
        <span class="close-thick js_hamburger_"></span>
        <div class="logoIcon" style="margin-bottom:30px;"></div>
        <a href="/">Landing</a>
    </div>
</div>
<div class="cFab">&#9650;</div>
<form action="{{ asset(api/switchLang) }}" method="post" id="formSwitch" style="display: none">
    <input type="hidden" name="language" value="any">
</form>
<div class="appHero">
    <h1 class="microLogo">micro<span>PHP</span></h1>
</div>
<?= $renderer->render('layout/navBarPartial')  ?>

<div class="container appContent">