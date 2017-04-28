<?php

class NewsList extends Component
{
    public function __construct($name, $template, array $params = array())
    {
        parent::__construct($name, $template, $params);
    }

    public function executeComponent()
    {
        $countElements = 0;
        $this->prepareParams();
        $this->arrResult = $this->getResult($this->getPageNumber(), $countElements);
        $this->includeTemplate();
        $this->getPagination($countElements);
    }

    private function getPagination($countElements) {
        ?> <div class="pagi"> <?
            $plus = $countElements%$this->params['count'] != 0?1:0;
            $max = (int)($countElements / $this->params['count']) +$plus;

            if ($this->getPageNumber() > (int)($max / 2) && (int)($this->getPageNumber() / 2) != 1) {
                echo "<a href=\"/news/page-" . ((int)($max / 4)) . "/\" >...</a>";
            }
            for ($i = $this->getPageNumber() - 2; $i < $this->getPageNumber() + 1 && $i < $max; $i++) {
                if ($i >= 0)
                    if ($this->getPageNumber() != $i + 1) {
                        ?><a href="/news/page-<?= $i + 1 ?>/" ><?= $i + 1 ?></a> <?php
                    } else {
                        ?><a class='active'><?= $i + 1 ?></a> <?php
                    }
            }
            if ($this->getPageNumber() <= (int)($max / 2)) {
                echo "<a href=\"/news/page-" . (round(($max + $this->getPageNumber()) / 2)) . "/\" >...</a>";
            }
            ?> </div> <?
    }

    protected function getResult($pageNumber, &$countItems = 0)
    {
        $array = array();
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $this->params['data'])) {
            $xmlString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $this->params['data']);
            $xml = new SimpleXMLElement($xmlString);
            $countItems = count($xml->item);
            $i = 0;
            foreach ($xml->item as $item) {
                $array[$i]['title'] = $item->title->__toString();
                $array[$i]['description'] = $item->description->__toString();
                $array[$i]['date'] = $item->date->__toString();
                $array[$i]['link'] = $item->link->__toString();
                $array[$i]['image'] = $item->image->__toString();
                $array[$i]['code'] = $item->code->__toString();
                $i++;
            }
        }
        return array_splice($array, ($pageNumber - 1) * $this->params['count'], $this->params['count']);
    }
}