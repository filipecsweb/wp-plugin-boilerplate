<?php

/**
 * Args may be passed when executing `wp eval-file`. E.g. `wp eval-file provision.php --skip-wordpress dry-run=1`.
 *
 * @link https://developer.wordpress.org/cli/commands/eval-file/
 */
if ( ! empty( $args ) ) {
	$_args = [];

	foreach ( $args as $k => $arg ) {
		$pieces = explode( '=', $arg );

		$_args[ $pieces[0] ] = $pieces[1];
	}

	$args = $_args;
}

define( 'NEW_FILENAME_PREFIX', $args['new-filename-prefix'] ?? '' );
define( 'NEW_FUNCTION_PREFIX', $args['new-function-prefix'] ?? '' );
define( 'NEW_CLASS_PREFIX', $args['new-class-prefix'] ?? '' );
define( 'NEW_NAMESPACE_PREFIX', $args['new-namespace-prefix'] ?? '' );

define( 'OLD_FILENAME_PREFIX', $args['old-filename-prefix'] ?? 'my-plugin' );
define( 'OLD_FUNCTION_PREFIX', $args['old-function-prefix'] ?? 'my_plugin' );
define( 'OLD_CLASS_PREFIX', $args['old-class-prefix'] ?? 'My_Plugin' );
define( 'OLD_NAMESPACE_PREFIX', $args['old-namespace-prefix'] ?? 'MyPlugin' );

$exclude = [ '.git', 'node_modules', 'vendor' ];

$directory = new RecursiveDirectoryIterator( __DIR__, RecursiveDirectoryIterator::SKIP_DOTS );
$iterator  = new RecursiveIteratorIterator(
	new RecursiveCallbackFilterIterator(
		$directory,
		/**
		 * @param SplFileInfo                     $file
		 * @param mixed                           $key
		 * @param RecursiveCallbackFilterIterator $iterator
		 *
		 * @return bool True if you need to recurse or if the item is acceptable.
		 */
		function ( $file, $key, $iterator ) use ( $exclude ) {
			// If is a directory and it's not supposed to be excluded we return true.
			if ( ! $file->isFile() && ! in_array( $file->getFilename(), $exclude ) ) {
				return true;
			}

			// If filename equals to index.php or the file is this current file we return false.
			if ( $file->getFilename() == 'index.php'
			     || $file->getFilename() == basename( __FILE__ ) ) {
				return false;
			}

			// Finally, now returns true only if it's a file.
			return $file->isFile();
		} )
);

$replace_file_content = function () use ( $args, $iterator ) {
	$files = [];

	/**
	 * @var SplFileInfo $info
	 */
	foreach ( $iterator as $info ) {
		$ext = $info->getExtension();

		if ( $ext != 'php'
		     && $ext != 'js'
		     && $ext != 'json' ) {
			continue;
		}

		$files[] = $info->getPathname();
	}

	foreach ( $files as $file ) {
		if ( NEW_FILENAME_PREFIX ) {
			file_put_contents( $file, str_replace( OLD_FILENAME_PREFIX, NEW_FILENAME_PREFIX, file_get_contents( $file ) ) );
		}

		if ( NEW_FUNCTION_PREFIX ) {
			file_put_contents( $file, str_replace( OLD_FUNCTION_PREFIX, NEW_FUNCTION_PREFIX, file_get_contents( $file ) ) );
		}

		if ( NEW_CLASS_PREFIX ) {
			file_put_contents( $file, str_replace( OLD_CLASS_PREFIX, NEW_CLASS_PREFIX, file_get_contents( $file ) ) );
		}

		if ( NEW_NAMESPACE_PREFIX ) {
			file_put_contents( $file, str_replace( OLD_NAMESPACE_PREFIX, NEW_NAMESPACE_PREFIX, file_get_contents( $file ) ) );
		}
	}
};

$replace_file_content();

$replace_filename = function () use ( $args, $iterator ) {
	$files = [];

	/**
	 * @var SplFileInfo $info
	 */
	foreach ( $iterator as $info ) {
		$files[] = $info->getPathname();
	}

	$renamed = [];

	foreach ( $files as $file ) {
		if ( strpos( $file, OLD_FILENAME_PREFIX ) !== false ) {
			if ( empty( $args['dry-run'] ) ) {
				rename( $file, str_replace( OLD_FILENAME_PREFIX, NEW_FILENAME_PREFIX, $file ) );
			}

			$renamed[] = "$file -> " . str_replace( OLD_FILENAME_PREFIX, NEW_FILENAME_PREFIX, $file );
		}
	}

	if ( ! empty( $args['dry-run'] ) ) {
		echo implode( "\n", $renamed ) . "\n";
	}
};

if ( NEW_FILENAME_PREFIX ) {
	$replace_filename();
}
