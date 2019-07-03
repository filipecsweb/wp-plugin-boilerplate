<?php

namespace VoltsWaitlist\Activator;

/**
 * Fired during plugin activation.
 *
 * @since       1.0.0
 * @package     Volts_Waitlist
 * @subpackage  Inc
 * @author      Filipe Seabra
 */
function init() {
	create_tables();
}

/**
 * @global $wpdb
 * @internal
 */
function create_tables() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'volts_waitlist_subscriber';

	if ( $wpdb->get_var( "show tables like '$table_name'" ) != $table_name ) {
		$sql = "CREATE TABLE $table_name (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
email varchar(255) NOT NULL,
variation_sku varchar(255) NOT NULL,
referrer varchar(255) NOT NULL,
PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}
}
