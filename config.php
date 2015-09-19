<?php
/**
 * Define the webserver and path parameters
 * DIR_FS_* = Filesystem directories (local/physical)
 * DIR_WS_* = Webserver directories (virtual/URL)
 */
define('DOMAIN', $_SERVER['SERVER_NAME'] . ( !in_array($_SERVER['SERVER_PORT'], array(80, 443)) ? ':'.$_SERVER['SERVER_PORT'] : ''));
define('DIR_WS_CATALOG', '/gallery/');
define('DIR_FS_CATALOG', preg_replace("/\/$/", "", $_SERVER["DOCUMENT_ROOT"]) . DIR_WS_CATALOG);

define('HTTP_SERVER', 'http://' . DOMAIN);
define('HTTPS_SERVER', 'https://' . DOMAIN);

define('DIR_IMAGES', "gifs/");
define('DIR_INCLUDES', "includes/");
define('DIR_HELPERS', "helpers/");
define('DIR_CACHE', "cache/");
define('DIR_TOOLS', "tools/");

define('FILE_JSON_LIST', "list.json.php");
define('FILE_AJAX_LISTING', "image_list.php");
define('FILE_AJAX_FEATURE', "feature.php");
define('FILE_GALLERY', "index.php");
define('FILE_VIEWER', "viewer.php");
define('FILE_SURROUND', "surrounding.php");
define('FILE_THUMBNAILER', "thumb.php");
define('FILE_DATABASE', "database-v3.sq3");

define('IMAGES_PER_PAGE', 60);
define('IMAGES_PER_NAV', 5);

define('THUMB_WIDTH', 128);
define('THUMB_HEIGHT', 128);

ini_set('display_errors', 1);
error_reporting(E_ALL);
