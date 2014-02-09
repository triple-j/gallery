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

			function resize_elms() {
				var width  = $(window).width(),
				    height = $(window).height();

				console.log({width:width,height:height});

				$('.win-width').width( width - 16 );
				$('.win-height').height( height - 16 );
			}

			$(document).ready(function(){
				gallery_viewer.init('viewer');

				$(window).on('resize', resize_elms);
				resize_elms();
			});

		</script>
	</head>

	<body>
		<!--h1>Image Viewer</h1-->

		<nav id="nav-links">
			<a class="prev win-height" href="#img:prev">Prev</a>
			<a class="next win-height" href="#img:next">Next</a>
		</nav>

		<div id="viewer" class="win-width win-height"></div>

		<nav id="thumb-nav" class="win-width"></nav>

	</body>
</html>
