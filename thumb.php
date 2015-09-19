<?php
include( 'config.php' );

// File and new size
$filename = $_GET['src'];
#$quality  = 67;

$thumb_width  = THUMB_WIDTH;
$thumb_height = THUMB_HEIGHT;

$cache_name = "cache/".md5($filename.$thumb_width.$thumb_height)."_thumb.png";

if( !file_exists($cache_name) ) {
	// Get new sizes
	list($width, $height) = getimagesize($filename);
	$ratio = $width / $height;

	$scale = max( $width/$thumb_width, $height/$thumb_height );
	$tmp_width  = (int)$width / $scale;
	$tmp_height = (int)$height / $scale;

	$tmp_top  = (int)($thumb_height-$tmp_height)/2;
	$tmp_left = (int)($thumb_width-$tmp_width)/2;

	// Load
	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	$source = imagecreatefromgif($filename);

	imagealphablending($source, true);
	imagealphablending($thumb, true);

	$fuchsia = imagecolorallocate($thumb, 255, 0, 255);
	imagefilledrectangle($thumb, -2, -2, $thumb_width, $thumb_height, $fuchsia);
	imagecolortransparent($thumb, $fuchsia);

	// Limit color palette
	#imagetruecolortopalette($source, false, 63);
	#imagetruecolortopalette($thumb, false, 64);

	// Resize
	imagecopyresized(
		$thumb, $source,
		 $tmp_left,    $tmp_top,      0,       0,
		$tmp_width, $tmp_height, $width, $height
	);

	// Limit color palette
	imagetruecolortopalette($thumb, true, 64);

	// Output
	#imagejpeg($thumb, null, $quality);
	imagepng($thumb, $cache_name);
}

// Content type
header('Content-Type: image/png');

// Read and output image
$fp = fopen($cache_name, 'rb');
fpassthru($fp);
