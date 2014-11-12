<?php

namespace HM\WPMaestro\Tasks;

class Hosts {

	protected $host_name;

	protected $ip_address = '192.168.50.10';

	public function __construct( $host_name ) {

		$this->host_name = $host_name;

	}

	public function run() {

		$hosts_file = '/etc/hosts';

		$data = $this->ip_address . ' ' . $this->host_name;

		$flags = ( file_exists( $hosts_file ) ) ? FILE_APPEND : null;

		file_put_contents( $hosts_file, $data, $flags );
	}
} 