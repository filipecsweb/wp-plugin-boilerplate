<?php

namespace VoltsWaitlist;

use VoltsWaitlist\Functions;

class Volts_Waitlist {
	/**
	 * @var     object $instance
	 */
	protected static $instance = null;

	public function __construct() {
		$this->set_dependencies();
		$this->set_locale();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @access   private
	 */
	private function set_dependencies() {
		if ( is_admin() ) {
			$glob = glob( Functions\plugin_path() . '/admin/**/*.php' );

			$glob = array_filter( $glob, function ( $v ) {
				if ( strpos( $v, 'index.php' ) !== false ) {
					return false;
				}

				return true;
			} );

			foreach ( $glob as $filepath ) {
				require $filepath;
			}
		}

		$glob = glob( Functions\plugin_path() . '/public/**/*.php' );

		$glob = array_filter( $glob, function ( $v ) {
			if ( strpos( $v, 'index.php' ) !== false ) {
				return false;
			}

			return true;
		} );

		foreach ( $glob as $filepath ) {
			require $filepath;
		}

		$glob = glob( Functions\plugin_path() . '/inc/models/*.php' );

		$glob = array_filter( $glob, function ( $v ) {
			if ( strpos( $v, 'index.php' ) !== false ) {
				return false;
			}

			return true;
		} );

		foreach ( $glob as $filepath ) {
			require $filepath;
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @access   private
	 */
	private function set_locale() {
		load_plugin_textdomain(
			Functions\plugin_slug(),
			false,
			Functions\plugin_path() . '/languages/'
		);
	}

	public static function run() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
	}
}
