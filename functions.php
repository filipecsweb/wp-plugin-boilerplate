<?php

namespace MyPlugin\Functions;

function plugin_path() {
	return untrailingslashit( plugin_dir_path( __FILE__ ) );
}

function plugin_url() {
	return untrailingslashit( plugin_dir_url( __FILE__ ) );
}

function plugin_version() {
	return '1.0.2';
}

function plugin_slug() {
	return 'my-plugin';
}

function the_partial_part( $slug, $name = null, $args = [] ) {
	$templates = array();
	$name      = (string) $name;

	if ( '' !== $name ) {
		$templates[] = "{$slug}-{$name}.php";
	}

	$templates[] = "{$slug}.php";

	foreach ( $templates as $template ) {
		if ( file_exists( plugin_path() . '/partials/' . $template ) ) {
			$located = plugin_path() . '/partials/' . $template;
			break;
		}
	}

	if ( isset( $located ) ) {
		$args;

		require( $located );
	}
}
