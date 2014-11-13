<?php

namespace HM\WPMaestro\Tasks;

class Install {

	protected $project_path;

	protected $theme_slug;

	protected $admin_user;
	protected $admin_password;
	protected $admin_email;

	public function __construct( $project_path, $theme_slug, $admin_user, $admin_password, $admin_email ) {

		$this->project_path = $project_path;

		$this->theme_slug = $theme_slug;

		$this->admin_email = $admin_email;
		$this->admin_user = $admin_user;
		$this->admin_password = $admin_password;

	}

	public function run() {

		chdir( $this->project_path );

		exec( 'wp db create' );

		exec( "wp core install --url={$this->project_path} --title={$this->project_path} --admin_user={$this->admin_user} --admin_password={$this->admin_password} --admin_email={$this->admin_email}" );

		exec( 'wp theme install ' . $this->theme_slug . ' --activate' );
	}
}
