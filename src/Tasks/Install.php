<?php

namespace HM\WPMaestro\Tasks;

use HM\WPMaestro\Tasks\Questions\InstallQuestions;

class Install extends Task {

	public function run( $io = null, InstallQuestions $questions = null ) {

		foreach ( $questions->get_questions() as $key => $question ) {
			$answers[ $key ] = $io->ask( $question['prompt'], $question['default'] );
		}

		foreach ( $answers as $key => $val ) {
			$replacements[ '{{' . $key . '}}' ] = $val;
		}

		$root = realpath( '.' );

		$templates_path = $root . '/src/templates/';

		$templates = array(
			'wp-config-local.php-dist',
			'wp-config.php-dist',
			'index.php-dist',
			'wp-cli.yml-dist',
		);

		foreach ( $templates as $template ) {
			$this->doReplace( $templates_path . $template, $replacements );
			copy( $templates_path . $template, $root . DIRECTORY_SEPARATOR . substr( $template, 0, -5 ) );
		}

		chdir( $root . '/wp-content' );

		symlink( $root . '/wp/wp-content/themes', 'themes' );

		chdir( $root );

		exec( 'wp db create' );

		exec( "wp core install --title={$answers['project_name']} --admin_user={$answers['admin_user']} --admin_password={$answers['admin_pass']} --admin_email={$answers['admin_email']}" );

		exec( 'wp theme install ' . $answers['active_theme'] . ' --activate' );

	}
}
