<?php
/*
парсинг rss с онлайнера (последних 10 штук)
*/

/*error_reporting(-1);*/
function deleteSpecialSymbols($str){
    $str = str_replace("Читать далее…",'',strip_tags($str));
    $str = preg_replace("[&nbsp;]"," ",$str);
    return $str;
}

function putXMLFromSite() {
$rss =  simplexml_load_file('https://people.onliner.by/feed');
$xmlOutput = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<news>\n";
for ($i = 0; $i < 10; $i++) {
    $item = $rss->channel->item[$i];
    $findNameSpaces = $rss->getNamespaces(true);
    $findChild = $item->children($findNameSpaces["media"]);

    $thumbnail = $findChild->thumbnail[0]->attributes();

    $xmlOutput .= "<item>\n";
    $xmlOutput .= "<title>" . deleteSpecialSymbols($item->title) . "</title>\n";
    $xmlOutput .= "<link>" . deleteSpecialSymbols($item->link) . "</link>\n";
    $xmlOutput .= "<image>" . deleteSpecialSymbols($thumbnail["url"]) . "</image>\n";
    $xmlOutput .= "<description>" . deleteSpecialSymbols($item->description) . "</description>\n";
    $xmlOutput .= "<date>" . deleteSpecialSymbols($item->pubDate) . "</date>\n";
    $xmlOutput .= "</item>\n";
}
$xmlOutput .= "</news>";
file_put_contents('rss.xml', $xmlOutput, FILE_TEXT);
}

putXMLFromSite();
?>