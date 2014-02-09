<?php
include( 'config.php' );

$json = file_get_contents( HTTP_SERVER . DIR_WS_CATALOG . FILE_JSON_LIST );
$data = json_decode($json, true);

$first_img = $data['images'][0];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<link href="css/main.css" rel="stylesheet" type="text/css" media="screen">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="javascript/gallery.js"></script>
		<script>

			var gallery_viewer = new Gallery({
				"VIEWER"       : "<?=FILE_VIEWER;?>",
				"AJAX_LISTING" : "<?=FILE_AJAX_LISTING;?>",
				"AJAX_FEATURE" : "<?=FILE_AJAX_FEATURE;?>",
				"current_img"  : "<?=$first_img;?>",
				"imgs_per_nav" : "<?=IMAGES_PER_NAV;?>"
			});

			$(document).ready(function(){
				gallery_viewer.init('viewer');
			});

		</script>
	</head>

	<body>
		<!--h1>Image Viewer</h1-->

		<nav id="nav-links">
			<a class="prev" href="#img:prev">Prev</a>
			<a class="next" href="#img:next">Next</a>
		</nav>

		<div id="viewer"></div>

		<nav id="thumb-nav"></nav>

	</body>
</html>
