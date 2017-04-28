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
    $xmlOutput = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<news.list>\n";
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
    $xmlOutput .= "</news.list>";
    file_put_contents('rss.xml', $xmlOutput, FILE_TEXT);
}

function renameImagePath() {
    $xml = simplexml_load_file('rss.xml');
    for ($i = 0; $i < 10; $i++) {
        $item = $xml->item[$i];
        copy($item->image, 'images/' . $i . '.jpg');
        $item->image = '/images/' . $i . '.jpg';
    }
    $xml->saveXML("xml.xml");
}


function getDescriptionNews(&$i) {
    $newObj = simplexml_load_file('xml.xml');
        for (; $i < 10; $i++) {
            $item = $newObj->item[$i];
            echo $item->title . '<br>';

        }
    echo '<pre>' . print_r($newObj, true) . '</pre>';
}

/*putXMLFromSite();
renameImagePath();*/




ob_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="../templates/news/1style.css">
    <meta content="text/html; charset=windows-1252" http-equiv="Content-Type" />
    <title>Test Ajax</title>
</head>
<body>

<div class="content" id="content">
    <?php
    if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
        ob_flush();
        ob_clean();
    }
    else {
        ob_end_clean();
    }

    $itemsCount = 3;
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        if (isset ($_GET["lastIndex"])) {
            $itemsCount = $_GET["lastIndex"] + 3 < count($newsArray) ? $_GET["lastIndex"] + 3 : count($newsArray);
        }
    }
    for ($i = $itemsCount - ($itemsCount - $_GET["lastIndex"]); $i < $itemsCount; $i++) {
        ?>
        <div class="block" id="block">
            <h4>Новость №<?= $i?></h4>
            <p><?php echo getDescriptionNews($i)?></p>
        </div>
    <?php }
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        ob_flush();
        ob_end_clean();
        exit;
    }
    else {
        ob_flush();
        ob_end_clean();
    }
    ?>
</div>

<button id="ajaxButton" type="button">Еще новости</button>

<script src="../templates/news/script.js" type="text/javascript"></script>
</body>
</html>