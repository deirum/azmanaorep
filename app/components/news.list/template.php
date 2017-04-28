<?php
function showNews($items, $params)
{
    ?>
    <div class="content">
    <?
    foreach ($items as $item) {
        ?>
        <div class='block'>
            <h4><?= $item['title'] ?></h4>
            <div class='description'><?= $item['description'] ?></div>
            <?php
            if ($params['show_img'] == 'Y') {
                ?><a href=" <?= $item['link'] ?>"><img src='/app/data<?= $item['image'] ?>'></a></br>
                <?php } ?>
            <em><?= $item['date'] ?></em>
            <blockquote><?= $item['code'] ?></blockquote>
        </div>
        <?php
    }
    ?>
    </div>
    <?
}
?>