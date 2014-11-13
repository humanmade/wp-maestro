<?php

namespace HM\WPMaestro;

use Composer\Script\Event;
use HM\WPMaestro\Tasks\Database;

//use HM\WPMaestro\Tasks\Hosts;

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

		$user_values = array(
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
			],
			'theme_slug' => [
				'default' => 'twentyfifteen',
				'msg'     => 'Active theme (default twentyfifteen)' . PHP_EOL
			],
			'admin_email' => [
				'default' => 'admin@example.com',
				'msg'     => 'Admin email (default admin@example.com)' . PHP_EOL
			],
			'admin_user' => [
				'default' => 'jack123',
				'msg'     => 'Admin user (default jack123)' . PHP_EOL
			],
			'admin_password' => [
				'default' => 'jack123',
				'msg'     => 'Admin password (default jack123)' . PHP_EOL
			],
		);

		foreach ( $user_values as $key => $val ) {
			$$key = $io->ask( $val['msg'] , $val['default'] );
		}

		$replaces = [
			"{{projectname}}" => $project_name,
			"{{db_host}}"     => $db_host,
			"{{db_name}}"     => $db_name,
			"{{db_user}}"     => $db_user,
			"{{db_pass}}"     => $db_pass,
		];

		$wp_config_local = 'wp-config-local.php-dist';
		$wp_config = 'wp-config.php-dist';
		$index = 'index.php-dist';
		$wpcli_config = 'wp-cli.yml-dist';

		self::doReplace( $templates_path . $wp_config_local, $replaces );
		self::doReplace( $templates_path . $wpcli_config, $replaces );

		copy( $templates_path . $wp_config_local, $root . DIRECTORY_SEPARATOR . substr( $wp_config_local, 0, - 5 ) );

		copy( $templates_path . $wp_config, $root . DIRECTORY_SEPARATOR . substr( $wp_config, 0, - 5 ) );

		copy( $templates_path . $index, $root . DIRECTORY_SEPARATOR . substr( $index, 0, - 5 ) );
		copy( $templates_path . $wpcli_config, $root . DIRECTORY_SEPARATOR . substr( $wpcli_config, 0, - 5 ) );

		//$hosts_task = new Hosts( $project_name );
		//$hosts_task->run();

		$installation = new Install( $root, $theme_slug, $admin_user, $admin_password, $admin_email );
		$installation->run();

		echo 'Cleaning up' . PHP_EOL;
		// Remove the source code.
		self::delTree( 'src' );

		echo 'Script finished. Your site is ready!' . PHP_EOL;

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
			( is_dir( "$dir/$file" ) ) ? self::delTree( "$dir/$file" ) : unlink( "$dir/$file" );
		}

		return rmdir( $dir );
	}



}
