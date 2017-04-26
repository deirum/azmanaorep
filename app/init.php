<?php

function onProlog() {

}

function onEpilog()
{
    Application::getInstance()->setPageProperty('h1',"<h1>main content</h1>");
}