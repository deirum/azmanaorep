<?php

function onProlog() {

}

function onEpilog()
{
    Application::getInstance()->setPageProperty('h1',"main content");
}