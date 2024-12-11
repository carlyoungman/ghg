<?php
// Partial | Cards Section Contents
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
    <div class="row <?= $type ?>__inner section__inner <?= $type ?>__container">
        <?php foreach ($entries as $entry) { ?>
            <div class="col-12 col-md-10 col-lg-4 <?= $type ?>__entry">
                <div class="content__wrap">
                    <?php if ($entry['media']) {
                        get_template_part('partials/block', 'media', $entry['media']);
                    } ?>
                    <?php if ($entry['title']) { ?>
                        <h3><?= $entry['title'] ?></h3>
                    <?php } ?>
                    <?php if ($entry['text']) { ?>
                        <div class="<?=$type?>__text"><?= $entry['text'] ?></div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>