<?php
include $_SERVER['DOCUMENT_ROOT'] . '/app/core.php';
Application::getInstance()->setTemplate('news');

Application::getInstance()->showHeader();
echo '<h1>';
Application::getInstance()->showProperty('h1');
echo '</h1>';
Application::getInstance()->showFooter();
?>
