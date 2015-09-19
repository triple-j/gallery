<?php
require_once('config.php');
require_once(DIR_TOOLS.'connect_db.php');
require_once(DIR_INCLUDES.'pagination.php');

$pagination = new Pagination($pdo, IMAGES_PER_PAGE);

$image = $_REQUEST['src'];

$surrounding_items = $pagination->surroundingItems($image,4);
$prev_src = empty($surrounding_items['leading']) ? null : $surrounding_items['leading'][0]['filename'];
$next_src = empty($surrounding_items['trailing']) ? null : $surrounding_items['trailing'][0]['filename'];

$item_type = $surrounding_items['current']['type'];
$item_src = $image;

$gallery_page = $surrounding_items['current']['page_number'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>Image Viewer</title>

		<link href="assets/css/main.css" rel="stylesheet" type="text/css" media="screen">
	</head>

	<body>
		<!--h1>Image Viewer</h1-->

		<div id="viewer">
			<div class="featured">
<?php if ( $item_type == "VIDEO" ) { ?>
				<video src="<?=$item_src;?>" autoplay loop>
					This browser doesn't support embedded videos.
				</video>
<?php } else { ?>
				<img src="<?=$image;?>" />
<?php } ?>
			</div>

			<nav class="image-nav">
				<a class="prev" href="<?=FILE_VIEWER . "?src=" . $prev_src;?>">Prev</a>
				<a class="next" href="<?=FILE_VIEWER . "?src=" . $next_src;?>">Next</a>
			</nav>
		</div>

		<nav id="nav-links">
			<a class="gallery" href="<?=FILE_GALLERY."?page=".$gallery_page;?>">Back to Gallery</a>
			<a class="surrounding" href="<?=FILE_SURROUND."?src=".$image;?>">Surrounding Images</a>
		</nav>

		<nav id="thumb-nav">
		</nav>

	</body>
</html>
