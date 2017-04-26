<?php

include $_SERVER['DOCUMENT_ROOT'] . '/app/core.php';

Application::getInstance()->setTemplate("news");
Application::getInstance()->showHeader();
Application::getInstance()->showProperty("h1");
Application::getInstance()->showFooter();

Application::getInstance()->includeComponent("news.list", "");

