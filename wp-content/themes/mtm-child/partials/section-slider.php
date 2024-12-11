<?php
// Partial | Slider Section Contents
?>

<div class="container-fluid container--max">
    <div class="row section__intro">
        <div class="col-12 text-center">
			<?php if ($title) { ?>
                <h2><?= $title ?></h2>
			<?php } ?>
        </div>
    </div>
    <div class="row swiper <?= $type ?>__container">
        <div class="col-12 <?= $type ?>__wrap ">
            <div class="row swiper-wrapper flex-nowrap no-gutters">
				<?php foreach ($entries as $entry) { ?>
                    <div class="slider__entry swiper-slide">
                        <div class="content__wrap">
                            <div class="slider__entry-image">
								<?= yr_image($entry['image']['id']) ?>
                            </div>
							<?php if ($entry['text']) { ?>
                                <p><?= $entry['text'] ?></p>
							<?php } ?>
							<?php echo yr_button($entry['link'], true); ?>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
        <div class="slider__controls">
            <div class="slider__button slider--prev"></div>
            <div class="slider__button slider--next"></div>
        </div>
    </div>
</div>