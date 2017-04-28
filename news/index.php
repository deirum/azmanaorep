<?php

include $_SERVER['DOCUMENT_ROOT'] . '/app/core.php';

Application::getInstance()->setTemplate("news");
Application::getInstance()->showHeader();
?>
<h1><?Application::getInstance()->showProperty("h1");?></h1>
<?
Application::getInstance()->includeComponent("news.list", "news");
Application::getInstance()->showFooter();

