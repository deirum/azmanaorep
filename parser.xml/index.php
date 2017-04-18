<?php
$rss =  simplexml_load_file('https://people.onliner.by/feed');

/*MAIN ROADS
$title =  $rss->channel->title;
$link = $rss->channel->link;
$description = $rss->channel->description;
$pubDate = $rss->channel->pubDate;

$itemTitle = $rss->channel->item->title;
$itemLink = $rss->channel->item->link;
$itemComments = $rss->channel->item->comments;
$itemPubDate = $rss->channel->item->pubDate;
$itemCategory = $rss->channel->item->Category;
$itemDescription = $rss->channel->item->description;*/
$i = 0;
    foreach ($rss->channel->item as $item) {
        if ($i == 10) break;
        echo $item->title;
        echo $item->description;
        echo "$item->pubDate <br>";
        echo "$item->link <br><hr><br>";
        $i++;
    }

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom_xml = dom_import_simplexml($rss);
$dom_xml = $dom->importNode($dom_xml, true);
$dom_xml = $dom->appendChild($dom_xml);
$dom->save('rss.xml');
?>