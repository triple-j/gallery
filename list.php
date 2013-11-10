<?php

#echo "<pre>";
$files = array( "images"=>array() );

foreach ( glob("gifs/*") as $file ) {
	if ( preg_match("/\.(gif|jpg|jpeg|png)$/i", $file) ) {
		#echo $file.PHP_EOL;
		$files['images'] []= $file;
	}
}

echo json_encode( $files, JSON_PRETTY_PRINT );
