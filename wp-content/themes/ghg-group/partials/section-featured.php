<?php
// Partial | Featured Section Contents
?>


<div class="container-fluid container--max-lg <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
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
        <div class="col-12 col-md-6 col-lg-8 <?= $type ?>__media">
            <?php if ($media) {
                $media['wrap'] = false;
                get_template_part('partials/block', 'media', $media);
            } ?>
        </div>
    </div>
</div>