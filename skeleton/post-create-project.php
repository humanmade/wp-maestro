#!/usr/bin/php
<?php

// @TODO: add wp-config with placeholders
// @TODO: mysql db creation?
// @TODO: add gruntfile / package.json
// @TODO: prompt for additional plugins during setup

// We get the project name from the name of the path that Composer created for us.
$project_name = basename( realpath( '.' ) );
$db_creds = array(
	'db_host' => 'Host name (default localhost)' . PHP_EOL,
	'db_name' => 'Database name (default:' . $project_name . ')' . PHP_EOL,
	'db_pass' => 'Database password (default blank)' . PHP_EOL,
	'db_user' => 'Database user (default root)' . PHP_EOL
);

echo "project name $project_name taken from directory name\n";

foreach ( $db_creds as $key => $msg ) {
	echo $msg;
	$$key = trim( fgets( STDIN ) );
}

$replaces = [
	"{{ projectname }}" => $project_name,
	"{{ db_host }}" => $db_host,
	"{{ db_name }}" => $db_name,
	"{{ db_user }}" => $db_user,
	"{{ db_pass }}" => $db_pass,
];

// Process templates from skel/templates dir. Notice that we only use files that end
// with -dist again. This makes sense in the context of this example, but depending on your
// requirements you might want to do a more complex things here (like if you want
// to replace files somewhere
// else than in the projects root directory
foreach ( glob( "skeleton/templates/{,.}*-dist", GLOB_BRACE ) as $distfile ) {

	$target = substr( $distfile, 15, - 5 );

	// First we copy the dist file to its new location,
	// overwriting files we might already have there.
	echo "creating clean file ($target) from dist ($distfile)...\n";
	copy( $distfile, $target );

	// Then we apply our replaces for within those templates.
	echo "applying variables to $target...\n";
	apply_values( $target, $replaces );
}
echo "removing dist files\n";

// Then we drop the skeleton dir, as it contains skeleton stuff.
del_tree( 'skeleton' );

echo "\033[0;32mdist script done...\n";

/**
 * A method that will read a file, run a strtr to replace placeholders with
 * values from our replace array and write it back to the file.
 *
 * @param string $target the filename of the target
 * @param array $replaces the replaces to be applied to this target
 */
function apply_values( $target, $replaces ) {

	file_put_contents(
		$target,
		strtr(
			file_get_contents( $target ),
			$replaces
		)
	);

}

/**
 * A simple recursive del_tree method
 *
 * @param string $dir
 *
 * @return bool
 */
function del_tree( $dir ) {

	$files = array_diff( scandir( $dir ), array( '.', '..' ) );

	foreach ( $files as $file ) {
		( is_dir( "$dir/$file" ) ) ? del_tree( "$dir/$file" ) : unlink( "$dir/$file" );
	}

	return rmdir( $dir );
}

exit( 0 );
