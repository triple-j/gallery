<?php
require_once(dirname(dirname(__FILE__)).'/config.php');

$sqlite_file = DIR_FS_CATALOG.DIR_CACHE.FILE_DATABASE;

$pdo = new PDO( 'sqlite:'.$sqlite_file, null, null, array(PDO::ATTR_PERSISTENT => true) );
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
