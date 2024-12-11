<?php
$theme     = wp_get_theme();
$bodyClass =
	isset( $theme->stylesheet ) && $theme->stylesheet
		? str_replace( ' ', '-', 'theme--' . $theme->stylesheet )
		: '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=5, user-scalable=yes">
	<link rel="apple-touch-icon" sizes="180x180"
		  href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32"
		  href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16"
		  href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/site.webmanifest">
	<link rel="mask-icon"
		  href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/safari-pinned-tab.svg"
		  color="#ff0000">
	<link rel="shortcut icon"
		  href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/favicon.ico?v=2">
	<meta name="msapplication-TileColor" content="var(--c-theme-primary)">
	<meta name="msapplication-config"
		  content="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/dist/favicons/browserconfig.xml">
	<meta name="theme-color" content="var(--c-theme-primary)">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $bodyClass ); ?>>

<?php get_template_part( '/template-parts/header' ); ?>
<?php get_template_part( '/template-parts/selling-points' ); ?>
<main id="wrapper">
