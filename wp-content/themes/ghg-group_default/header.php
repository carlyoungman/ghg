<?php
$theme     = wp_get_theme();
$bodyClass = ( isset( $theme->stylesheet ) && $theme->stylesheet ) ? str_replace( ' ', '-', 'theme--' . $theme->stylesheet ) : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" sizes="180x180"
		  href="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32"
		  href="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16"
		  href="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/site.webmanifest">
	<link rel="mask-icon" href="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/safari-pinned-tab.svg"
		  color="#ff0000">
	<link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#faf8f2">
	<meta name="msapplication-config"
		  content="<?= get_stylesheet_directory_uri() ?>/dist/assets/favicons/browserconfig.xml">
	<meta name="theme-color" content="#faf8f2">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $bodyClass ); ?>>

<?php get_template_part( '/template-parts/header' ); ?>
<main id="wrapper">
