<?php

namespace HM\WPMaestro;

use Composer\Script\Event;
use HM\WPMaestro\Tasks\Questions;
use HM\WPMaestro\Tasks\Install;

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

		$install = new Install();
		$install->run( $event->getIO(), new Questions\InstallQuestions() );

		echo 'Cleaning up' . PHP_EOL;

		// Remove the source code.
		self::delTree( 'src' );

		echo 'Script finished. Your site is ready!' . PHP_EOL;

		// exit composer and terminate installation process
		exit;
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
