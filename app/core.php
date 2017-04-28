<?php

final class Application
{

    private static $instance = null;
    private $property = array();
    private $template = '';
    private $__components = array();

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

    public function includeComponent($name, $tempalte, $params = array())
    {
        if (empty($this->__components[$name])) {
            $firstCount = count(get_declared_classes());
            include_once($_SERVER['DOCUMENT_ROOT'] . '/app/components/' . $name . '/class.php');
            $classes = get_declared_classes();
            for ($i = $firstCount - 1; $i < count($classes); $i++) {
                if (is_subclass_of($classes[$i], 'Component')) {
                    $this->__components[$name] = $classes[$i];
                    break;
                }
            }
        }
        $component = new $this->__components[$name]($name, $tempalte, $params);
        $component->executeComponent();
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
        }
        return $keys;
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

    private function translit($str)
    {
        $rus = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', '!', '?', '.', ',', ':', ';', '[', ']', '{', '}', '<', '>', '/', '"', '*', '-', '+', '@', '#', '№', '$', '%', '^', '&', '(', ')', '~', '`', '=', '„', '“', '»', '«', ' ');
        $lat = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-');
        return trim(str_replace($rus, $lat, $str),'-');
    }

}

abstract class Component
{
    private $name = '';
    private $template = '';
    protected $params = array();
    protected $toResult = array();

    public function __construct($name, $template, $params = array())
    {
        $this->name = $name;
        $this->template = $template;
        $this->params = $params;
    }

    final public function includeTemplate($page = "template")
    {
        $tempPath = $_SERVER['DOCUMENT_ROOT'] . '/app/components/' . $this->name . '/' . $page . '.php';
        if (file_exists($tempPath)) {
            include_once($tempPath);
            showNews($this->arrResult, $this->params);
        }
    }

    protected function prepareParams()
    {
        if (empty($this->params['count']))
            $this->params['count'] = 3;
        if (empty($this->params['show_img']))
            $this->params['show_img'] = 'Y';
        if (empty($this->params['data']))
            $this->params['data'] = 'xml.xml';
    }

    protected function getPageNumber()
    {
        $page = 1;
        if (isset($_GET['PAGE']) &&
            (int)$_GET['PAGE'] > 0
        )
            $page = (int)($_GET['PAGE']);
        return $page;
    }

    public abstract function executeComponent();
}