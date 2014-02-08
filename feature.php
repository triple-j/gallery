<?php

$preload = isset($_REQUEST['preload']) ? (bool)$_REQUEST['preload'] : false;
$image   = isset($_REQUEST['img']) ? $_REQUEST['img'] : false;

if ( !$image ) { die("Error loading Image"); }

$json = file_get_contents("http://{$_SERVER['SERVER_NAME']}/gallery/list.php");
$data = json_decode($json, true);

$image_idx = array_search( $image, $data['images'] );

if ( $image_idx === false ) { die("Error loading Image"); }


$total_imgs = count($data['images']);

$prev_idx = $image_idx - 1;
$next_idx = $image_idx + 1;

if ( $prev_idx < 0 ) { $prev_idx = $total_imgs - 1; }
if ( $next_idx >= $total_imgs ) { $next_idx = 0; }

$img_prev = $data['images'][$prev_idx];
$img_next = $data['images'][$next_idx];
?>
	<div class="featured">
		<img src="<?=$image;?>" />
	</div>
	<nav class="nav-links">
		<a class="prev" href="<?=$img_prev;?>">
			<?=($preload)?"<img src=\"{$img_prev}\" />":"prev";?>
		</a>
		<a class="next" href="<?=$img_next;?>">
			<?=($preload)?"<img src=\"{$img_next}\" />":"next";?>
		</a>
	</nav>
