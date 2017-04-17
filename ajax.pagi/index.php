<?php
ob_start();
$newsArray = array(
    0 => '1Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    1 => '2Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    2 => '3Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    3 => '4Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    4 => '5Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    5 => '6Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    6 => '7Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    7 => '8Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    8 => '9Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    9 => '10Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    10 => '11Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.',
    11 => '12Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
        been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type
        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="main.css">
    <meta content="text/html; charset=windows-1252" http-equiv="Content-Type" />
    <title>Test Ajax</title>
</head>

<body>


<div class="content" id="content">
    <?php
    $header = ob_get_contents();
    ob_clean();
    $itemsCount = 3;
    if (isset ($_GET["lastIndex"])) {
        $itemsCount = $_GET["lastIndex"] + 3 < count($newsArray) ? $_GET["lastIndex"] + 3 : count($newsArray);
    }
    for ($i = $itemsCount - ($itemsCount - $_GET["lastIndex"]); $i < $itemsCount; $i++) {
        ?>
        <div class="block" id="block">
            <h4>Новость №<?php echo $i?></h4>
            <p><?php echo $newsArray[$i]?></p>
        </div>
    <?php }
    $content = ob_get_contents();
    ob_clean();?>
</div>

<button id="ajaxButton" type="button">Еще новости</button>

<script type="text/javascript">
    var ajaxButton = document.getElementById("ajaxButton");
    ajaxButton.addEventListener('click', function () {

        httpRequest = new XMLHttpRequest();
        lastElementIndex = document.getElementsByClassName("block").length;
        httpRequest.open('GET', location.origin + location.pathname + '?lastIndex=' + lastElementIndex, true);
        httpRequest.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText === '') {
                        ajaxButton.style.display = 'none';
                    }
                    var element = document.getElementById("content");
                    element.innerHTML += this.responseText;
                }
            }
        }
        httpRequest.send();
    });
</script>
</body>
</html>
<?php
$footer = ob_get_contents();
ob_clean();
if (!isset($_GET["lastIndex"])) {
    echo $header;
    echo $content;
    echo $footer;
}   else
    echo $content;
ob_end_flush();
?>