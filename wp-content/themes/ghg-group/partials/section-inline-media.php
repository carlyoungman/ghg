<?php
// Partial | Inline Media Section Contents
?>


<div class="container-fluid container--max-lg <?= $type ?>__background-container">
    <div class="<?= $type ?>__background">
    </div>
</div>


<div class="container-fluid container--max<?=($layout == 'blocks') ? '-lg' : '' ?> <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
        <div class="col-12 col-md-6 <?= $type ?>__media">
            <div class="content__wrap">
                <?php if ($media) {
                    get_template_part('partials/block', 'media', $media);
                } ?>
            </div>
        </div>
        <div class="col-12 col-md-6 <?= $type ?>__text">
            <div class="content__wrap">
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