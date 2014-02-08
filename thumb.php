<?php
include( 'config.php' );

// File and new size
$filename = $_GET['src'];
#$quality  = 67;

$thumb_width  = THUMB_WIDTH;
$thumb_height = THUMB_HEIGHT;

// Content type
header('Content-Type: image/png');

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

#imagealphablending($thumb, true);
$fuchsia = imagecolorallocate($thumb, 255, 0, 255);
imagefilledrectangle($thumb, 0, 0, $thumb_width, $thumb_height, $fuchsia);
imagecolortransparent($thumb, $fuchsia);

// Resize
imagecopyresized(
	$thumb, $source,
	 $tmp_left,    $tmp_top,      0,       0,
	$tmp_width, $tmp_height, $width, $height
);

// Output
#imagejpeg($thumb, null, $quality);
imagepng($thumb);
