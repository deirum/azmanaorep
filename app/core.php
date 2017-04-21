<?php

final class Application
{

    private static $instance = null;
    private $property = array();
    private $template = '';

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->includeFile($_SERVER['DOCUMENT_ROOT'] . '/app/init.php');
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    private function __sleep()
    {
    }

    public function setTemplate($template)
    {
        if ($this->template == '') {
            $this->template = $template;
        }
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getTemplatePath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/app/templates/" . $this->template;
    }

    public function includeComponent()
    {
        #как определить /class.php и что внутри его; classload и тд
    }


    public function setPageProperty($id, $value)
    {
        $this->property[$id] = $value;
    }

    public function getPageProperty($id)
    {
        $id = (string)$id;
        return $this->property[$id];
    }

    public function showProperty($id)
    {
        echo $this->setMacros($id);
    }

    private function setMacros($macros)
    {
        return "#PAGE_PROPERTY_" . $macros . "#";
    }

    private function getPagePropertyKeys()
    {
        $keys = array_keys($this->property);
        for ($i = 0; $i < count($keys); $i++) {
            $keys[$i] = $this->setMacros($keys[$i]);
            return $keys;
        }
    }

    public function includeFile($filename)
    {
        if (file_exists($filename)) {
            include_once $filename;
        }
    }

    public function handler($event)
    {
        if (function_exists($event)) {
            call_user_func($event);
        }
    }

    public function showHeader()
    {
        $this->handler("onProlog");
        ob_start();
        $this->includeFile($this->getTemplatePath() . "/header.php");
    }

    public function showFooter()
    {
        $this->includeFile($this->getTemplatePath() . "/footer.php");
        $this->handler("onEpilog");
        $content = ob_get_contents();
        $content = str_replace($this->getPagePropertyKeys(), $this->property, $content);
        ob_end_clean();
        echo $content;
    }

    public function restartBuffer()
    {
        ob_clean();
    }

}

class Component
{
    private $name = '';
    private $template = '';
    private $params = array();

    public function __construct($name, $template, $params = array())
    {
        $this->name = $name;
        $this->template = $template;
        $this->params = $params;
    }

    public function includeTemplate()
    {
        $tempPath = $_SERVER['DOCUMENT_ROOT'] . '/app/components/' . $this->name . '/' . $this->template . '/index.php';
        if (file_exists($tempPath)) {
            include_once($tempPath);
        }
    }
}