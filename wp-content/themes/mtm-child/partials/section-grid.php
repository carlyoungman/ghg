<?php
// Partial | Grid Section Contents
?>
<div class="container-fluid container--max-lg">
    <?php if ($title || $text) { ?>
        <div class="row <?= $type ?>__intro">
            <div class="col-12 col-md-6">
                <?php if ($title) { ?>
                    <h2><?= $title ?></h2>
                <?php } ?>
            </div>
            <div class="col-12 col-md-6 <?= $type ?>__intro-text">
                <?php if ($text) { ?>
                    <?= $text ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="row <?= $type ?>__inner section__inner <?= $type ?>__container slider__wrap slider--mob swiper">
        <div class="swiper-wrapper col-12 mx-0 px-0 row flex-nowrap flex-md-wrap justify-content-md-center">
            <?php foreach ($entries as $entry) { ?>
                <div class="col-12 col-md-10 col-lg-4 <?= $type ?>__entry swiper-slide">
                    <div class="content__wrap">
                        <?php if ($entry['icon']) { ?>
                            <?= yr_image($entry['icon']['id']) ?>
                        <?php } ?>
                        <?php if ($entry['label']) { ?>
                            <h3><?= $entry['label'] ?></h3>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="slider__buttons d-md-none">
            <div class="slider__button slider--prev"></div>
            <div class="slider__button slider--next"></div>
        </div>
        <div class="slider__pagination d-md-none">
        </div>
    </div>
</div>