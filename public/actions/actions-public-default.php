<?php

namespace MyPlugin\Actions\PublicDefault;

use MyPlugin\Functions;

/**
 * Hooked into `wp_enqueue_scripts` action hook.
 *
 * Register the stylesheets for the public area.
 */
function enqueue_public_styles() {
	if ( ! is_singular( 'product' ) ) {
		return;
	}

	$handles = array(
		array(
			'handle' => 'public-' . Functions\plugin_slug(), // Default css file for all plugin pages.
			'src'    => Functions\plugin_url() . '/assets/dist/css/bundle-public.css',
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
 * Hooked into `wp_enqueue_scripts` action hook.
 *
 * Register the JavaScript for the public area.
 */
function enqueue_public_scripts() {
	if ( ! is_singular( 'product' ) ) {
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
			'handle'    => 'public-' . Functions\plugin_slug(), // Default js file for all plugin pages.
			'src'       => Functions\plugin_url() . '/assets/dist/js/bundle-public.js',
			'deps'      => [], // Someone very clever disabled WordPress default jQuery library.
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
			wp_localize_script( $handle['handle'], '_l10n_public_my_plugin', $handle['l10n'] );
		}

		wp_enqueue_script( $handle['handle'] );
	}
}
