<?php

namespace MyPlugin\Activator;

/**
 * Fired during plugin activation.
 *
 * @since       1.0.0
 * @package     My_Plugin
 * @subpackage  Inc
 * @author      Filipe Seabra
 */
function init() {
//	create_tables();
}

/**
 * @global $wpdb
 * @internal
 */
function create_tables() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'my_plugin_table';

	if ( $wpdb->get_var( "show tables like '$table_name'" ) != $table_name ) {
		$sql = "CREATE TABLE $table_name (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}
}
