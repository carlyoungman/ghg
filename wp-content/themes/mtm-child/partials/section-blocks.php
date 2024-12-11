<?php
// Partial | Blocks Section Contents
?>
<div class="container-fluid container--max-lg">
    <?php if ($title || $text) { ?>
        <div class="row <?= $type ?>__intro">
            <div class="col-12">
                <div class="content__wrap text-center">
                    <?php if ($title) { ?>
                        <h2><?= $title ?></h2>
                    <?php } ?>
                    <?php if ($text) { ?>
                        <?= $text ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row <?= $type ?>__inner section__inner <?= $type ?>__container slider__wrap slider--mob swiper">
        <div class="swiper-wrapper col-12 mx-0 px-0 row flex-nowrap flex-md-wrap">
            <?php foreach ($entries as $entry) { ?>
                <div class="col-12 col-md-6 col-lg-3 <?= $type ?>__entry swiper-slide">
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