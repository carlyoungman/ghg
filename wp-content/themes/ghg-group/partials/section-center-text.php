<?php
// Partial | Center Text Section Contents
?>

<div class="container-fluid container--max <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
        <div class="col-12">
            <div class="content__wrap mx-auto text-center">
                <?php if ($title) { ?>
                    <h2><?= $title ?></h2>
                <?php } ?>
                <?php if ($text) { ?>
                    <p><?= $text ?></p>
                <?php } ?>
                <?php if ($link) {
                    echo yr_button($link);
                } ?>
            </div>
        </div>
    </div>
</div>