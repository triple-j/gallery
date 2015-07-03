<?php
//include( 'config.php' );
require_once('config.php');
require_once(DIR_TOOLS.'connect_db.php');
require_once(DIR_INCLUDES.'pagination.php');

$pagination = new Pagination($pdo, IMAGES_PER_PAGE);

$current_page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;

$total_pages = $pagination->totalPages();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>Image Gallery</title>

		<link href="assets/css/main.css" rel="stylesheet" type="text/css" media="screen">

		<script>
			console.log("Current Page: <?=$current_page;?>");
		</script>
	</head>

	<body>
		<h1>Image Gallery</h1>

<?php require(DIR_HELPERS.'pagination_navigation.php'); ?>

		<div id="gallery">
			<?php var_dump($pagination->getPage($current_page)); ?>
		</div>

<?php require(DIR_HELPERS.'pagination_navigation.php'); ?>

	</body>
</html>
