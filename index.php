<?php
require_once('config.php');
require_once(DIR_TOOLS.'connect_db.php');
require_once(DIR_INCLUDES.'pagination.php');

$pagination = new Pagination($pdo, IMAGES_PER_PAGE);

$current_page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
$page_items = $pagination->getPage($current_page);

$total_pages = $pagination->totalPages();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>Image Gallery</title>

		<link href="assets/css/main.css" rel="stylesheet" type="text/css" media="screen">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="assets/javascript/main.js"></script>

		<script>
			console.log("Current Page: <?=$current_page;?>");
		</script>
	</head>

	<body>
		<h1>Image Gallery</h1>

<?php require(DIR_HELPERS.'pagination_navigation.php'); ?>

		<div id="gallery">
<?php require(DIR_HELPERS.'image_list.php'); ?>
		</div>

<?php require(DIR_HELPERS.'pagination_navigation.php'); ?>

		<div id="overlay"></div>
		<div id="popup">
			<div id="viewer"></div>
		</div>
	</body>
</html>
