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
		<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>
			var current_img = "<?=$first_img;?>";
			var key = {
				"LEFT_ARROW"  : 37,
				"UP_ARROW"    : 38,
				"RIGHT_ARROW" : 39,
				"DOWN_ARROW"  : 40
			};
			var nav_visible  = false;

			function change_img(e) {
				var image = location.hash.replace(/^#img:/,"");

				console.log( {image:image, current:window.current_img} );

				/*if ( image != "" ) {
					window.current_img = image;
				}*/
				switch ( image ) {
					case "prev":
						prev_img();
						break;
					case "next":
						next_img();
						break;
					case "":
						window.current_img = "<?=$first_img;?>";
						break;
					default:
						window.current_img = image;
				}

				$('#viewer').load('feature.php', {img:window.current_img,preload:0}, function(){
					if ( window.nav_visible ) {
						open_nav();
					}
				});
			}

			function prev_img() {
				var prev_href = $('#viewer .nav-links a.prev').attr('href');
				location.hash = "#img:" + prev_href;
			}

			function next_img() {
				var next_href = $('#viewer .nav-links a.next').attr('href');
				location.hash = "#img:" + next_href;
			}

			function display_nav( visible ) {
				if ( visible === undefined ) {
					visible = window.nav_visible;
				} else {
					window.nav_visible = visible;
				}

				if ( visible ) {
					$('#thumb-nav').show();
				} else {
					$('#thumb-nav').hide();
				}
			}

			function open_nav() {
				$('#thumb-nav').load('<?=FILE_AJAX_LISTING;?>', {numof:<?=IMAGES_PER_NAV;?>,rel:window.current_img}, function(){
					console.log("Thumb Navigation Updated");
					display_nav( true );
				});
			}

			function close_nav() {
				display_nav( false );
			}

			$(document).ready(function(){
				$(window).on('hashchange', change_img);
				change_img(null);
				display_nav();

				$(document).on('keypress', function(evt){
					var pressed = (evt.keyCode || evt.charCode);

					console.log( {pressed:pressed} );

					switch ( pressed ) {
						case window.key['LEFT_ARROW']:
							console.log( "View Previous Image" );
							prev_img();
							break;
						case window.key['RIGHT_ARROW']:
							console.log( "View Next Image" );
							next_img();
							break;
						case window.key['UP_ARROW']:
							console.log( "Open Navigation" );
							open_nav();
							break;
						case window.key['DOWN_ARROW']:
							console.log( "Close Navigation" );
							close_nav();
							break;
					}
				});

				$('#thumb-nav').on('click', '.img-thumb-box a', function(evt){
					var img_link = $(this).attr('href');
					//console.log( {img_link:img_link, encode:encodeURIComponent(img_link)} );
					location.href = "<?=FILE_VIEWER;?>#img:" + img_link;
					evt.preventDefault();
				});
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
