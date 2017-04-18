<?php
/*
парсинг rss с онлайнера (последних 10 штук)
*/

error_reporting(-1);
$rss =  simplexml_load_file('https://people.onliner.by/feed');
$xmlOutput = "<xml version='1.0'>\n<news>";

for ($i = 0; $i < 10; $i++) {
    $item = $rss->channel->item[$i];
    $findNameSpaces = $rss->getNamespaces(true);
    $findChild = $item->children($findNameSpaces["media"]);

    $thumbnail = $findChild->thumbnail[0]->attributes();

    $xmlOutput .= "<item>\n";
    $xmlOutput .= "<title>" . $item->title->__toString() . "</title>\n";
    $xmlOutput .= "<link>" . $item->link->__toString() . "</link>\n";
    $xmlOutput .= "<image>" . $thumbnail["url"] . "</image>\n";
    $xmlOutput .= "<description>" . $item->description->__toString() . "</description>\n";
    $xmlOutput .= "<date>" . $item->pubDate->__toString() . "</date>\n";
    $xmlOutput .= "</item>\n";

    echo $item->title;
    echo $item->description;
    echo $thumbnail["url"];

    echo "$item->link<br>";
    echo "$item->pubDate<br>";
}

$xmlOutput .= "</news>\n</xml>";

file_put_contents('rss.xml', $xmlOutput, FILE_TEXT);
?>