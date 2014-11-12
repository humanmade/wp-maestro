<?php

namespace WPMaestro;

use Composer\Script\Event;

/**
 * Class ScriptHandler
 * @package WPMaestro
 */
class ScriptHandler {

	/**
	 * Callback for the Composer post-create-project-command event
	 *
	 * @param Event $event
	 */
	public static function postCreateProject( Event $event ) {

		$io = $event->getIO();

		$root = realpath( '.' );

		$templates_path = $root . '/src/templates/';

		$project_name = basename( $root );

		$db_creds = array(
			'db_host' => [
				'default' => 'localhost',
				'msg'     => 'Host name (default localhost)' . PHP_EOL
			],
			'db_name' => [
				'default' => $project_name,
				'msg'     => 'Database name (default:' . $project_name . ')' . PHP_EOL
			],
			'db_pass' => [
				'default' => '',
				'msg'     => 'Database password (default blank)' . PHP_EOL
			],
			'db_user' => [
				'default' => 'root',
				'msg'     => 'Database user (default root)' . PHP_EOL
			]
		);

		foreach ( $db_creds as $key => $msg ) {
			$$key = $io->ask( $msg, 'default' );
		}

		$replaces = [
			"{{ projectname }}" => $project_name,
			"{{ db_host }}"     => $db_host,
			"{{ db_name }}"     => $db_name,
			"{{ db_user }}"     => $db_user,
			"{{ db_pass }}"     => $db_pass,
		];

		$wp_config = 'wp-config-local.php-dist';

		self::doReplace( $templates_path . $wp_config, $replaces );

		copy( $templates_path . $wp_config, $root . DIRECTORY_SEPARATOR . substr( $wp_config, 0, - 5 ) );

		echo 'Cleaning up';
		// Remove the source code.
		self::delTree( 'src' );

		echo 'Script finished. Your site is ready!';

		// exit composer and terminate installation process
		exit;
	}

	/**
	 * Replace placeholders with user values.
	 *
	 * @param $target
	 * @param $replaces
	 */
	protected static function doReplace( $target, $replaces ) {

		file_put_contents(
			$target,
			strtr(
				file_get_contents( $target ),
				$replaces
			)
		);

	}

	/**
	 * A simple recursive delTree method
	 *
	 * @param string $dir
	 *
	 * @return bool
	 */
	protected static function delTree( $dir ) {
		$files = array_diff( scandir( $dir ), array( '.', '..' ) );
		foreach ( $files as $file ) {
			( is_dir( "$dir/$file" ) ) ? delTree( "$dir/$file" ) : unlink( "$dir/$file" );
		}

		return rmdir( $dir );
	}

}