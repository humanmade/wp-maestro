<?php

define( 'DB_NAME', {{ db_name }} );
define( 'DB_USER', {{ db_user }} );
define( 'DB_PASSWORD', {{ db_pass }} );
define( 'DB_HOST', {{ db_host }} );

define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress' );
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );

define( 'HM_DEV', true ); // Enable/disable HM Dev Plugin. Also Enables/disables wp_debug
