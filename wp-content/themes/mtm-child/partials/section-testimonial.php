<?php
// Partial | Testimonial Section Contents
?>

<div class="container-fluid container--max-lg <?= $type ?>__container">
    <div class="row <?=$type?>__shadow accent--bottom-left"></div>
    <div class="row <?= $type ?>__inner section__inner accent--top-right">
        <div class="col-12 section__intro"></div>
        <div class="col-12 col-md-5 col-lg-6  <?= $type ?>__title">
            <div class="content__wrap">
                <?php if ($title) { ?>
                    <p class="text--upper"><?=$title?></p>
                <?php } ?>
                <?php if ($image) { 
                    echo yr_image($image['id']);
                } ?>
            </div>
        </div>
        <div class="col-12 col-md-7 col-lg-6  <?= $type ?>__body">
            <div class="content__wrap">
                <?php if ($text) { ?>
                    <?= $text ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>