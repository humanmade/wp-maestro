<?php

namespace HM\WPMaestro\Tasks\Questions;

class InstallQuestions {

	public function get_questions() {

		$project_name = basename( realpath( '.' ) );

		return [
			'project_name' => [
				'default' => $project_name,
				'prompt'  => 'Project name ( default ' . $project_name . ' )'
			],
			'db_host'      => [
				'default' => 'localhost',
				'prompt'  => 'Host name ( default localhost )'
			],
			'db_name'      => [
				'default' => $project_name,
				'prompt'  => 'Database name ( default ' . $project_name . '  )'
			],
			'db_user'      => [
				'default' => 'root',
				'prompt'  => 'Database username ( default root )'
			],
			'db_pass'      => [
				'default' => '',
				'prompt'  => 'Database password ( default blank )'
			],
			'active_theme' => [
				'default' => 'twentyfifteen',
				'prompt'  => 'Active theme ( default twentyfifteen )'
			],
			'admin_email'  => [
				'default' => '',
				'prompt'  => 'Admin email'
			],
			'admin_user'   => [
				'default' => '',
				'prompt'  => 'Admin username'
			],
			'admin_pass'   => [
				'default' => '',
				'prompt'  => 'Admin user password'
			]
		];
	}
}
