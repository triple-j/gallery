<?php
include( 'config.php' );

$files = array( "images"=>array() );

foreach ( glob(DIR_IMAGES."*") as $file ) {
	if ( preg_match("/\.(gif|jpg|jpeg|png)$/i", $file) ) {
		$files['images'] []= $file;
	}
}

header('Content-type: application/json; charset=utf-8');
echo json_encode( $files, JSON_PRETTY_PRINT );
