<?php
require_once(dirname(__FILE__).'/connect_db.php');

$all_files_sql = "SELECT filename FROM viewable_files";
$sth = $pdo->prepare($all_files_sql);
$sth->execute();
$all_files = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
print_r($all_files);

	$insert_sql = "INSERT INTO viewable_files (filename, type, added) VALUES (:filename, :type, datetime('now'))";
	$sth = $pdo->prepare($insert_sql);

foreach ( glob(DIR_FS_CATALOG.DIR_IMAGES."*") as $file ) {
	$filename = str_replace(DIR_FS_CATALOG, '', $file);

	if ( in_array($filename,$all_files) ) continue;


	$insert_data = [];

	if ( preg_match("/\.(gif|jpg|jpeg|png)$/i", $file) ) {
		// IMAGES
		//$files['images'] []= $file;
		echo $filename . PHP_EOL;
		$insert_data[':filename'] = $filename;
		$insert_data[':type'] = "IMAGE";
	} elseif ( preg_match("/\.(mp4|mpeg4|webm|flv)$/i", $file) ) {
		// VIDEOS
		echo $filename . PHP_EOL;
		$insert_data[':filename'] = $filename;
		$insert_data[':type'] = "VIDEO";
	} elseif ( preg_match("/\.(swf)$/i", $file) ) {
		// FLASH
		echo $filename . PHP_EOL;
		$insert_data[':filename'] = $filename;
		$insert_data[':type'] = "FLASH";
	}

	if ( !empty($insert_data) ) {
		$sth->execute($insert_data);
	}
}
