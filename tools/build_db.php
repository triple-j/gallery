<?php
require_once(dirname(__FILE__).'/connect_db.php');

$create_sql = "
	CREATE TABLE IF NOT EXISTS `viewable_files` (
		`id`           INTEGER  PRIMARY KEY  AUTOINCREMENT  NOT NULL   ,
		`filename`     TEXT     NULL ,
		`type`         TEXT     NULL ,
		`width`        INTEGER  NULL ,
		`height`       INTEGER  NULL ,
		`added`        TEXT     NULL
	);
";
$pdo->exec($create_sql);
