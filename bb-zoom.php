<?php
/**
 * Plugin Name: Beaver Builder - Zoom
 * Plugin URI: http://www.thierry-pigot.fr
 * Description: jQuery Zoom module for Beaver Builder.
 * Version: 1.0
 * Author: Thierry Pigot
 * Author URI: http://www.thierry-pigot.fr
 */
 
 /*
 * todo[
 * ]
*/

define('TP_BB_ZOOM_DIR', plugin_dir_path(__FILE__));
define('TP_BB_ZOOM_URL', plugins_url('/', __FILE__));

// Custom modules
function tp_bb_load_module_zoom() {
	if( class_exists('FLBuilder') ) {
		require_once 'tpbbzoom/tpbbzoom.php';
	}
}
add_action('init', 'tp_bb_load_module_zoom');

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', 'tp_bb_load_textdomain_zoom' );
function tp_bb_load_textdomain_zoom()
{
	load_plugin_textdomain( 'bbzoom', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}