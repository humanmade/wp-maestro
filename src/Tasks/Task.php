<?php

namespace HM\WPMaestro\Tasks;


use HM\WPMaestro\Tasks\Questions\InstallQuestions;

abstract class Task {

	abstract function run( $io = null, InstallQuestions $questions = null );

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
}
