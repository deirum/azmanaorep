<?php

include_once '../app/application.php';

Application::getInstance()->showHeader('news');
echo '<h1>';
Application::getInstance()->showProperty('h1');
echo '</h1>';
Application::getInstance()->showFooter('news');
?>
