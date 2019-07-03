<?php /** @noinspection PhpUnusedAliasInspection */

/**
 * Plugin Name:     PLUGIN NAME
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     my_plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         My_Plugin
 */

use MyPlugin\Functions;

require 'functions.php';

require Functions\plugin_path() . '/inc/class-my-plugin.php';
require Functions\plugin_path() . '/inc/class-activator.php';
require Functions\plugin_path() . '/inc/class-deactivator.php';

/**
 * @see \MyPlugin\Activator\init()
 */
register_activation_hook( __FILE__, 'MyPlugin\Activator\init' );

/**
 * @see \MyPlugin\Deactivator\init()
 */
//register_deactivation_hook( __FILE__, 'MyPlugin\Deactivator\init' );

/**
 * Add custom links to be displayed on the plugins page (beside the activate/deactivate links).
 *
 * @link    https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
 * @link    https://developer.wordpress.org/reference/functions/admin_url/
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
	$custom_links = array(
//		array(
//			"url" => '',
//			"text" => '',
//		)
	);

	foreach ( $custom_links as $link ) {
		$html = "<a href='{$link['url']}'>{$link['text']}</a>";

		array_push( $links, $html );
	}

	return $links;
} );

/**
 * @see \MyPlugin\My_Plugin::run()
 */
add_action( 'plugins_loaded', array( 'MyPlugin\My_Plugin', 'run' ) );
