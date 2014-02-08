<?php
error_reporting(E_ALL);

$numof = isset($_REQUEST['numof']) ? $_REQUEST['numof'] : 60;
$page  = isset($_REQUEST['page']) ? $_REQUEST['page'] - 1 : 0;

$json = file_get_contents("http://{$_SERVER['SERVER_NAME']}/gallery/list.php");
$data = json_decode($json, true);

$start_rel_to = isset($_REQUEST['rel']) ? array_search($_REQUEST['rel'],$data['images']) : false;

$start = ($start_rel_to===false) ? $page * $numof : $start_rel_to;
$end   = $start + $numof;

for ( $idx = $start; $idx < $end; $idx++ ) {
	$orig_src = $data['images'][$idx];
	$thmb_src = "thumb.php?src={$orig_src}";
?>
	<div class="img-thumb-box">
		<a href="<?=$orig_src;?>">
			<img src="<?=$thmb_src;?>" />
		</a>
	</div>
<?php
}
