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
				<li><a href="<?="{$current_url}?page=1";?>">&laquo;</a></li>
				<li><a href="<?="{$current_url}?page={$previous_page}";?>">&lsaquo;</a></li>
<?php
for ( $idx = 1; $idx <= $total_pages; $idx++ ) {
	if ( $current_page == $idx ) {
?>
				<li><strong><?=$idx;?></strong></li>
<?php
	} else {
?>
				<li><a href="<?="{$current_url}?page={$idx}";?>"><?=$idx;?></a></li>
<?php
	}
}
?>
				<li><a href="<?="{$current_url}?page={$next_page}";?>">&rsaquo;</a></li>
				<li><a href="<?="{$current_url}?page={$total_pages}";?>">&raquo;</a></li>
			</ul>
		</nav>
