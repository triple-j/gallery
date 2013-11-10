<?php
// File and new size
#$filename = 'test.jpg';
#$percent = 0.5;
$filename = $_GET['src'];
$quality  = 67;

#die($filename);

$thumb_width  = 100;
$thumb_height = 200;
#$thumb_width  = 400;
$thumb_width = $thumb_height = 128;

// Content type
header('Content-Type: image/png');

// Get new sizes
list($width, $height) = getimagesize($filename);
#$newwidth = $width * $percent;
#$newheight = $height * $percent;
$ratio = $width / $height;
#die($ratio);

$scale = max( $width/$thumb_width, $height/$thumb_height );
$tmp_width  = (int)$width / $scale;
$tmp_height = (int)$height / $scale;

/*if ( $width > $height ) {
	$tmp_width  = (int)$thumb_width;
	$tmp_height = (int)$thumb_width / $ratio;
} else {
	$tmp_width  = (int)$thumb_height * $ratio;
	$tmp_height = (int)$thumb_height;
}*/
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