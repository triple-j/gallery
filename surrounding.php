
<?php
require_once('config.php');
require_once(DIR_TOOLS.'connect_db.php');
require_once(DIR_INCLUDES.'pagination.php');

$pagination = new Pagination($pdo, IMAGES_PER_PAGE);

$image = $_REQUEST['src'];
$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : floor((IMAGES_PER_NAV) / 2);

$surrounding_items = $pagination->surroundingItems($image, $offset);
$prev_src = empty($surrounding_items['leading']) ? null : $surrounding_items['leading'][0]['filename'];
$next_src = empty($surrounding_items['trailing']) ? null : $surrounding_items['trailing'][0]['filename'];

$page_items = $surrounding_items['list'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>Surrounding Images</title>

		<link href="assets/css/main.css" rel="stylesheet" type="text/css" media="screen">
	</head>

	<body>

		<nav id="thumb-nav">
			<div class="images">
<?php require(DIR_HELPERS.'image_list.php'); ?>
			</div>
			<a class="prev" href="<?=FILE_SURROUND . "?src={$prev_src}&offset={$offset}";?>">Prev</a>
			<a class="next" href="<?=FILE_SURROUND . "?src={$next_src}&offset={$offset}";?>">Next</a>
		</nav>

	</body>
</html>
