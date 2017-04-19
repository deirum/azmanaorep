<?php

class Application
{

    private static $instance = null;

    /**
     * @return Singleton
     */

    private $property;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
        $this->property = array("h1" => "news");
        ob_start();
    }

    public function setPageProperty($id, $value)
    { #устанавливает св-во страницы, например id = 'h1', \#
        $this->property[$id] = $value;                              #при этом в класс#
    }

    public function getPageProperty($id)
    {  #получение св-ва страницы по id#
        $id = (string)$id;
        return $this->property[$id];
    }

    public function showProperty($id)
    {
        /*ob_flush();
        ob_clean();*/
        $id = (string)$id;
        echo $this->getPageProperty($id);     #- на месте вызова оставляет макрос для дальнешей замены#
        /*ob_flush();*/                      #на необходимое св-во страницы,например если id = 'h1', то макрос =#
        # #PAGE_PROPERTY_h1#*/
    }

    public function showHeader($template_name)
    {
        /*ob_clean();*/
        include "../app/templates/$template_name/header.php";
        /*ob_flush();*/
    }

    public function showFooter($template_name)
    {
        /*ob_flush();
        ob_clean();*/
        include "../app/templates/$template_name/footer.php";   /*- подключает footer c шаблона*/#
        /*ob_flush();*/
    }

    public function restartBuffer()
    {
        ob_end_clean();
        ob_start();
    }

    public function handler($event)
    {#- проверка и выполнение события с названием $event.#
        # Регистрация событий должна#
    }         #происходить с помощью реализации одноименной функции в файле init.php*/#

}

?>