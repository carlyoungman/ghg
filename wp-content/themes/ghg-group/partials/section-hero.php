<?php
// Partial | Hero Section Contents
if ($layout == 'full') { ?>
    <div class="section__background d-none d-md-flex">
        <?php
        $media['wrap'] = false;
        $media['size'] = '100vw';
        get_template_part('partials/block', 'media', $media) ?>
    </div>
    <div class="section__background section-background--mobile d-md-none">
        <?php
        $media_mobile['wrap'] = false;
        $media_mobile['size'] = '200vw';
        get_template_part('partials/block', 'media', $media_mobile) ?>
    </div>
<?php } ?>
<div class="container-fluid container--max-lg">
    <div class="row <?= $type ?>__inner section__inner <?= $type ?>__container">
        <div class="col-12 col-md-6 col-lg-7 <?= $type ?>__text">
            <div class="content__wrap">
                <h1 <?=($size && $size !== 'default') ? 'class="text--sm"' : ''?> ><?= $title ?></h1>
                <?php if ($text) { ?>
                    <p><?= $text ?></p>
                <?php } ?>
            </div>
        </div>
        <?php if ($layout !== 'full') { ?>
            <div class="col-12 col-md-6 <?= $type ?>__media">
            </div>
        <?php } ?>
    </div>
</div>
<?php if ($ticker) {
    $html = '<div class="ticker__inner">';
    $html .= '<span>' . $ticker . '</span>';
    $html .= '</div>';
?>
    <div class="container-fluid <?= $type ?>__ticker ticker">
        <div class="row ticker__inner-wrap">
            <?= $html ?><?= $html ?><?= $html ?><?= $html ?><?= $html ?><?= $html ?>
        </div>
    </div>
<?php } ?>