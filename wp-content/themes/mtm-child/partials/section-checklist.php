<?php
// Partial | Checklist Section Contents
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
    <div class="row d-block <?= $type ?>__inner section__inner">
        <div class="<?= $type ?>__inner-wrap">
            <?php
            foreach ($entries as $index => $entry) { ?>
                <div class="<?= $type ?>__entry">
                    <div class="content__wrap">
                        <?php if ($entry['text']) { ?>
                            <p>
                                <?= $entry['text'] ?>
                            </p>
                        <?php } ?>
                    </div>
                </div>
                <?php if (($index + 1) % 2 == 0) { ?>
                    <div class="checklist__break"></div>
                <?php  } ?>
            <?php } ?>
        </div>
    </div>
</div>