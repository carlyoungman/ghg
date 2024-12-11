<?php
/*============================================
|	  Header Component
============================================*/
$theme = wp_get_theme();
$bodyClass = (isset($theme->stylesheet) && $theme->stylesheet) ? str_replace(' ', '-', 'theme--'.$theme->stylesheet) : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/site.webmanifest">
    <link rel="mask-icon" href="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/safari-pinned-tab.svg" color="#ff0000">
    <link rel="shortcut icon" href="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#faf8f2">
    <meta name="msapplication-config" content="<?=get_stylesheet_directory_uri()?>/dist/assets/favicons/browserconfig.xml">
    <meta name="theme-color" content="#faf8f2">
  <?php wp_head(); ?> 
  </head>
  <body <?php body_class($bodyClass); ?>>
    <header id="main">
      <div class="container-fluid container--max-lg">
        <div class="row">
          <div class="col-6 col-md-4 col-lg-2 col-xl-3 header__branding">
            <a href="/">
              <?=svg('ghg-logo')?>
            </a>
          </div>
          <div class="col-6 col-md-8 col-lg-10 col-xl-9 justify-content-end d-flex align-items-center justify-content-end">
            <nav id="header" class="d-none d-lg-flex">
              <?=wp_nav_menu(['theme_location' => 'header_menu', 'container' => false]) ?>
              <?=yr_button([
              'title' => 'Get in touch',
              'url' => '/contact',
              'class' => 'btn--light'
            ])?>
            </nav>
            <button class="header__mobile-toggle mobile__toggle d-lg-none">
              <span></span>
            </button>
          </div>
        </div>
      </div>
    </header>
    <nav id="mobile">
      <?=wp_nav_menu(['theme_location' => 'mobile_menu', 'container' => false]) ?>
    </nav>
    <main id="wrapper">
