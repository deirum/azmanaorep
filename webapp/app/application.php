<?php

final class Application
{

    private static $instance = null;

    /**
     * @return Singleton
     */

    private $property;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->property = array("h1" => "news");
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
        echo "#PAGE_PROPERTY_$id#";
    }

    public function includeFile($filename) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $filename)) {
            include_once $_SERVER['DOCUMENT_ROOT'] . $filename;
        } else {
            return false;
        }
    }

    public function handler($event)
    {
        $this->includeFile("/app/init.php");
        if (call_user_func($event)!= null) {
            call_user_func($event);
        }
    }

    public function showHeader($template_name)
    {
        ob_start();
        $this->includeFile("/app/templates/$template_name/header.php");
    }

    public function showFooter($template_name)
    {
        $this->handler("onEpilog");
        $this->includeFile("/app/templates/$template_name/footer.php");
        ob_flush();
    }

    public function restartBuffer()
    {
        ob_clean();
    }

}

?>