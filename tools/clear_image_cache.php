<?php
require_once(dirname(dirname(__FILE__)).'/config.php');

$image_files = glob(DIR_FS_CATALOG.DIR_CACHE."*.png");

foreach ($image_files as $image_file) {
	unlink($image_file);
}

echo "done.";
