<?php

namespace MyPlugin\Actions\AdminDefault;

use MyPlugin\Functions;

/**
 * Register the stylesheets for the admin area.
 *
 * @param string $hook May be edit.php, page param value (page=plugin_page), etc.
 */
function enqueue_admin_styles( $hook ) {
	// If we are not seeing specific pages, quit.
	if ( $hook != '' ) {
		return;
	}

	$handles = array(
		array(
			'handle' => 'admin-' . Functions\plugin_slug(), // Default css file for all plugin pages.
			'src'    => Functions\plugin_url() . '/assets/dist/css/bundle-admin.css',
			'deps'   => array(),
			'ver'    => Functions\plugin_version(),
			'media'  => 'all'
		)
	);

	foreach ( $handles as $handle ) {
		wp_enqueue_style(
			$handle['handle'],
			$handle['src'],
			$handle['deps'],
			$handle['ver'],
			$handle['media']
		);
	}
}

/**
 * Register the JavaScript for the admin area.
 *
 * @param string $hook May be edit.php, page param value (page=plugin_page), etc.
 */
function enqueue_admin_scripts( $hook ) {
	// If we are not seeing specific pages, quit.
	if ( $hook != '' ) {
		return;
	}

	$l10n = array(
		'all' => array(
			'plugin_url' => Functions\plugin_url(),
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
		)
	);

	$handles = array(
		array(
			'handle'    => 'admin-' . Functions\plugin_slug(), // Default js file for all plugin pages.
			'src'       => Functions\plugin_url() . '/assets/dist/js/bundle-admin.css',
			'deps'      => array( 'jquery' ),
			'ver'       => Functions\plugin_version(),
			'in_footer' => true,
			'l10n'      => $l10n['all'],
		)
	);

	foreach ( $handles as $handle ) {
		wp_register_script(
			$handle['handle'],
			$handle['src'],
			$handle['deps'],
			$handle['ver'],
			$handle['in_footer']
		);

		if ( ! empty( $handle['l10n'] ) ) {
			wp_localize_script( $handle['handle'], '_l10n_admin', $handle['l10n'] );
		}

		wp_enqueue_script( $handle['handle'] );
	}
}
