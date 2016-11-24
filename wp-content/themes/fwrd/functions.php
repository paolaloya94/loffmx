<?php

/*-----------------------------------------------------------------------------------*/
/* Set Proper Parent/Child theme paths for inclusion
/*-----------------------------------------------------------------------------------*/
/*ini_set('max_execution_time', 600);*/

define( 'IRON_PARENT_DIR', get_template_directory() );
define( 'IRON_CHILD_DIR',  get_stylesheet_directory() );

define( 'IRON_PARENT_URL', get_template_directory_uri() );
define( 'IRON_CHILD_URL',  get_stylesheet_directory_uri() );

define( 'IRON_ENVATO_ITEM_ID', ''); // HARDCODED

function dependencies_check(){
	if (is_user_logged_in()){
		if ( !defined('IRON_MUSIC') ) {
			echo '<div class="message dependencie"><h4>Important: The theme requires that you install and activate the plugin Iron Music. <a href="'. esc_url(get_admin_url( null, 'themes.php?page=tgmpa-install-plugins' )) . '">Click here to install it.</a></h4></div>';
			echo '<style type="text/css">.message.dependencie{ position:absolute; top:0; left:0; width:100%; z-index:3000; padding:20px 50px; text-align:center; background:black; color:#fff; }.message.dependencie h4{color:#fff;}</style>';
		}
	}
}
add_action( 'wp_footer', 'dependencies_check');


global $xt_styles;

/**
 * Sets up the content width value based on the theme's design.
 * @see iron_content_width() for template-specific adjustments.
 */



if ( ! isset( $content_width ) )
	$content_width = 696;


if(!defined('ACF_LITE')){
	define('ACF_LITE', TRUE);
}

// Load functions
require_once(IRON_PARENT_DIR.'/includes/functions.php');

// Load upgrades/migrations
require_once(IRON_PARENT_DIR.'/includes/upgrade.php');

// Load Admin Panel
require_once(IRON_PARENT_DIR.'/admin/options.php');

// Load dynamic styles class
if ( ! class_exists( 'Iron_Dynamic_Styles' ) ) {
	require_once(IRON_PARENT_DIR.'/includes/classes/styles.class.php');
}


// Load Plugin installation and activation
require_once(IRON_PARENT_DIR.'/includes/classes/tgmpa.class.php');
require_once(IRON_PARENT_DIR.'/includes/plugins.php');



if ( ! class_exists('acf') )
	require_once(IRON_PARENT_DIR.'/includes/advanced-custom-fields/acf.php');


// Load Widgets
require_once(IRON_PARENT_DIR.'/includes/classes/widget.class.php');
require_once(IRON_PARENT_DIR.'/includes/widgets.php');


// Load Visual Composer Addons
add_action( 'vc_before_init', 'IRON_vcSetAsTheme' );
function IRON_vcSetAsTheme() {
    vc_set_as_theme( $disable_updater = true );
}
require_once(IRON_PARENT_DIR.'/includes/vc-extend/vc-custom-params.php');
require_once(IRON_PARENT_DIR.'/includes/vc-extend/vc-map.php');
require_once(IRON_PARENT_DIR.'/includes/vc-extend/vc-helpers.php');


// Load Iron Nav 
require_once(IRON_PARENT_DIR.'/includes/classes/nav.class.php');

// Load Custom Fields
require_once(IRON_PARENT_DIR.'/includes/custom-fields.php');

// Setup Theme
require_once(IRON_PARENT_DIR.'/includes/setup.php');

require_once(IRON_PARENT_DIR. '/framework-customizations/theme/hooks.php');

/*-----------------------------------------------------------------------------------*/
/* WOOCOMMERCE
/*-----------------------------------------------------------------------------------*/

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'fwrd_my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'fwrd_my_theme_wrapper_end', 10);

function fwrd_my_theme_wrapper_start() {
  echo '<div class="container">
		<div class="boxed">';
}

function fwrd_my_theme_wrapper_end() {
  echo '</div></div>';
}
