<?php
// Partial | Inline Form Section Contents
?>

<div class="container-fluid container--max <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
        <div class="col-12 col-md-6 <?= $type ?>__text">
            <div class="content__wrap">
				<?php if ( $title ) { ?>
                    <h2><?= $title ?></h2>
				<?php } ?>
				<?php if ( $text ) { ?>
                    <p><?= $text ?></p>
				<?php } ?>
				<?php if ( $link ) {
					echo yr_button( $link );
				} ?>
            </div>
        </div>
        <div class="col-12 col-md-6 <?= $type ?>__form">
            <div class="content__wrap">
				<?= do_shortcode( '[formidable id="' . $form . '"]' ) ?>
            </div>
        </div>
    </div>
</div>