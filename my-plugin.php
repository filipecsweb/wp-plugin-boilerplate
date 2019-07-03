<?php /** @noinspection PhpUnusedAliasInspection */

/**
 * Plugin Name:     Volts - Avise-me quando disponivel
 * Plugin URI:      https://www.volts.ag/
 * Description:     Sistema de lista de espera que avisa os clientes quando um produto volta ao estoque.
 * Author:          Filipe Seabra <filipe@voltsdigital.com.br>
 * Author URI:      https://www.volts.ag/
 * Text Domain:     volts-waitlist
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Volts_Waitlist
 */

use VoltsWaitlist\Functions;

require 'functions.php';

require Functions\plugin_path() . '/inc/class-volts-waitlist.php';
require Functions\plugin_path() . '/inc/class-activator.php';
require Functions\plugin_path() . '/inc/class-deactivator.php';

/**
 * @see \VoltsWaitlist\Activator\init()
 */
register_activation_hook( __FILE__, 'VoltsWaitlist\Activator\init' );

/**
 * @see \VoltsWaitlist\Deactivator\init()
 */
//register_deactivation_hook( __FILE__, 'VoltsWaitlist\Deactivator\init' );

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
 * @see \VoltsWaitlist\Volts_Waitlist::run()
 */
add_action( 'plugins_loaded', array( 'VoltsWaitlist\Volts_Waitlist', 'run' ) );
