<?php
// Partial | Inline Text Section Contents
?>

<div class="container-fluid container--max <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
        <div class="col-12 col-md-5 <?=$snippet ? 'col-lg-5' : 'col-lg-4' ?> <?= $type ?>__title">
            <div class="content__wrap">
                <?php if ($title) { ?>
                    <h2><?= $title ?></h2>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-md-7 <?=$snippet ? 'col-lg-7' : 'col-lg-8'?> <?= $type ?>__text">
            <div class="content__wrap">
                <?php if ($text) { ?>
                    <?=$snippet ? '<p>' : '' ?>
                    <?= $text ?>
                    <?=$snippet ? '</p>' : '' ?>
                <?php } ?>
                <?php if ($link) {
                    echo yr_button($link);
                } ?>
            </div>
        </div>
    </div>
</div>