<?php
/*==================================
|	Theme Functions
==================================*/

// Load theme init functions
include_once(get_template_directory().'/inc/theme-init.php');

// Load theme registers
include_once(get_template_directory().'/inc/theme-register.php');

// Load theme security functions
include_once(get_template_directory().'/inc/theme-security.php');

// Load theme custom functions
include_once(get_template_directory().'/inc/theme-functions.php');

// Load theme scripts and styles
include_once(get_template_directory().'/inc/theme-scripts.php');

// Load theme dependant plugins
include_once(get_template_directory().'/inc/theme-plugins.php');

// Load theme custom meta
include_once(get_template_directory().'/inc/theme-meta.php');