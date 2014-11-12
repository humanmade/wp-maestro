<?php

namespace HM\WPMaestro\Tasks;

class Database {

	protected $project_path;

	protected $ip_address = '192.168.50.10';

	public function __construct( $project_path ) {

		$this->project_path = $project_path;

	}

	public function run() {

		chdir( $this->project_path );

		exec( 'wp create db' );
	}
}
