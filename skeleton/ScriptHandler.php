<?php

namespace WPMaestro;

use Composer\Script\Event;

class ScriptHandler {

	public static function postCreateProject( Event $event ) {

		$io = $event->getIO();

		$project_name = basename( realpath( '.' ) );

		$db_creds = array(
			'db_host' => 'Host name (default localhost)' . PHP_EOL,
			'db_name' => 'Database name (default:' . $project_name . ')' . PHP_EOL,
			'db_pass' => 'Database password (default blank)' . PHP_EOL,
			'db_user' => 'Database user (default root)' . PHP_EOL
		);

		foreach ( $db_creds as $key => $msg ) {
			$$key = $io->ask( $msg, 'default');
		}

		$replaces = [
			"{{ projectname }}" => $project_name,
			"{{ db_host }}" => $db_host,
			"{{ db_name }}" => $db_name,
			"{{ db_user }}" => $db_user,
			"{{ db_pass }}" => $db_pass,
		];

		$wp_config = __DIR__ . '/templates/wp-config-local.php-dist';

		self::apply_values( $wp_config, $replaces );

		copy( $wp_config, '../wp-config-local' );

		// exit composer and terminate installation process
		exit;
	}

	protected static function apply_values( $target, $replaces ) {

		file_put_contents(
			$target,
			strtr(
				file_get_contents( $target ),
				$replaces
			)
		);

	}

}
