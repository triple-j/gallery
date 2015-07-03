<?php
/**
 * Required Variables
 *   $current_page
 *   $total_pages
 */

$current_url   = strtok($_SERVER["REQUEST_URI"],'?');
$next_page     = min($current_page+1, $total_pages);
$previous_page = max($current_page-1, 1);
?>
		<nav class="pages">
			<ul>
				<li class="first"><a href="<?="{$current_url}?page=1";?>">&laquo;</a></li>
				<li class="previous"><a href="<?="{$current_url}?page={$previous_page}";?>">&lsaquo;</a></li>
<?php
for ( $idx = 1; $idx <= $total_pages; $idx++ ) {
	if ( $current_page == $idx ) {
?>
				<li class="page current"><strong><?=$idx;?></strong></li>
<?php
	} else {
?>
				<li class="page"><a href="<?="{$current_url}?page={$idx}";?>"><?=$idx;?></a></li>
<?php
	}
}
?>
				<li class="next"><a href="<?="{$current_url}?page={$next_page}";?>">&rsaquo;</a></li>
				<li class="last"><a href="<?="{$current_url}?page={$total_pages}";?>">&raquo;</a></li>
			</ul>
		</nav>
