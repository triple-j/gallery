<?php
include( 'config.php' );

$numof = isset($_REQUEST['numof']) ? $_REQUEST['numof'] : IMAGES_PER_PAGE;
$page  = isset($_REQUEST['page']) ? $_REQUEST['page'] - 1 : 0;

$json = file_get_contents( HTTP_SERVER . DIR_WS_CATALOG . FILE_JSON_LIST );
$data = json_decode($json, true);

$start_rel_to = isset($_REQUEST['rel']) ? array_search($_REQUEST['rel'],$data['images']) : false;

$start = ($start_rel_to===false) ? $page * $numof : $start_rel_to;
$end   = $start + $numof;

for ( $idx = $start; $idx < $end; $idx++ ) {
	$orig_src = $data['images'][$idx];
	$thmb_src = FILE_THUMBNAILER . "?src={$orig_src}";
?>
	<div class="img-thumb-box">
		<a href="<?=$orig_src;?>">
			<img src="<?=$thmb_src;?>" />
		</a>
	</div>
<?php
}
