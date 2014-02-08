<?php
include( 'config.php' );

$numof = IMAGES_PER_PAGE;

$json = file_get_contents( HTTP_SERVER . DIR_WS_CATALOG . FILE_JSON_LIST );
$data = json_decode($json, true);

$total_imgs  = count($data['images']);
$total_pages = ceil( $total_imgs / $numof );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<link href="css/main.css" rel="stylesheet" type="text/css" media="screen">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="javascript/gallery.js"></script>
		<script>

			var gallery_listing = new Gallery({
				"VIEWER"       : "<?=FILE_VIEWER;?>",
				"AJAX_LISTING" : "<?=FILE_AJAX_LISTING;?>",
				"total_pages"  : <?=$total_pages;?>
			});

			$(document).ready(function(){
				gallery_listing.init();
			});

		</script>
	</head>

	<body>
		<h1>Image Gallery</h1>

		<nav class="pages">
			<ul>
				<li><a href="#page-prev">&laquo;</a></li>
<?php for ( $idx = 1; $idx <= $total_pages; $idx++ ) { ?>
				<li><a href="#page-<?=$idx;?>"><?=$idx;?></a></li>
<?php } ?>
				<li><a href="#page-next">&raquo;</a></li>
			</ul>
		</nav>

		<div id="gallery"></div>

		<nav class="pages">
			<ul>
				<li><a href="#page-prev">&laquo;</a></li>
<?php for ( $idx = 1; $idx <= $total_pages; $idx++ ) { ?>
				<li><a href="#page-<?=$idx;?>"><?=$idx;?></a></li>
<?php } ?>
				<li><a href="#page-next">&raquo;</a></li>
			</ul>
		</nav>

	</body>
</html>
