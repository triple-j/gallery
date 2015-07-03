<?php
/**
 * Required Variables
 *   $page_items
 */

for ( $idx = 0; $idx < count($page_items); $idx++ ) {
	$orig_src = $page_items[$idx]['filename'];
	$thmb_src = $page_items[$idx]['type'] === "IMAGE" ? FILE_THUMBNAILER . "?src={$orig_src}" : "assets/placeholder.gif";
?>
	<div class="img-thumb-box">
		<a href="<?=$orig_src;?>">
			<img src="<?=$thmb_src;?>" />
		</a>
	</div>
<?php
}
