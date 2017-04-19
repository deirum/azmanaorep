<?php

/**
обработка нашего rss.xml файла, удаление HTML тегов, в description оставить только текст
 */
function renameImagePath() {

$xml = simplexml_load_file('rss.xml');
for ($i = 0; $i < 10; $i++) {
    $item = $xml->item[$i];
    copy($item->image, 'images/' . $i . '.jpg');
    $item->image = '/images/' . $i . '.jpg';
}
$xml->saveXML("newRSS.xml");

}

renameImagePath();
/*echo '<pre>' .print_r($xml, true). '</pre>';*/