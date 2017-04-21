<?php

function onProlog() {

}

function onEpilog()
{
    Application::getInstance('news')->setPageProperty('h1','main content');
}