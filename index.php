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
		<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>
			var current_page = 1;
			var total_pages = <?=$total_pages;?>;

			function change_page(e) {
				var page = location.hash.replace(/^#page-/,"");

				console.log( {page:page, current:window.current_page} );

				switch ( page ) {
					case "prev":
						if ( window.current_page > 1 ) {
							window.current_page--;
							location.hash = "#page-" + window.current_page;
						}
						break;
					case "next":
						if ( window.current_page < total_pages ) {
							window.current_page++;
							location.hash = "#page-" + window.current_page;
						}
						break;
					case "":
						window.current_page = 1;
						break;
					default:
						window.current_page = parseInt(page,10);
				}

				console.log( {page:page, current:window.current_page} );

				$('#gallery').load('<?=FILE_AJAX_LISTING;?>', {page:window.current_page});
			}

			$(document).ready(function(){
				$(window).on('hashchange', change_page);
				change_page(null);

				$('#gallery').on('click', '.img-thumb-box a', function(evt){
					var img_link = $(this).attr('href');
					console.log( {img_link:img_link, encode:encodeURIComponent(img_link)} );
					location.href = "<?=FILE_VIEWER;?>#img:" + img_link;
					evt.preventDefault();
				});
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
