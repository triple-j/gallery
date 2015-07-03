<?php
require_once(dirname(dirname(__FILE__)).'/config.php');

class Pagination
{
	public $dbh;
	public $items_pre_page = IMAGES_PER_PAGE;

	public function __construct($database_handler, $items_pre_page) {
		$this->dbh = $database_handler;
		$this->items_pre_page = $items_pre_page;
	}

	public function getPage($page_number = 1) {
		$page_stmt = $this->dbh->prepare("
			SELECT
				id,
				filename,
				type
			FROM
				viewable_files
			ORDER BY
				datetime(added) ASC
			LIMIT
				:start, :count
		");

		$page_data = array();
		$page_data[':start'] = ( $page_number - 1 ) * $this->items_pre_page;
		//$page_data[':end']   = $page_data[':start'] + $this->items_pre_page - 1;
		$page_data[':count'] = $this->items_pre_page;

		var_dump( $page_data );

		$page_stmt->execute($page_data);

		return $page_stmt->fetchAll(PDO::FETCH_ASSOC);
		//return $page_stmt->fetchAll();
	}

	public function totalPages() {
		$total_stmt = $this->dbh->prepare("
			SELECT
				COUNT(id)
			FROM
				viewable_files
		");
		$total_stmt->execute();
		$total_results = $total_stmt->fetchAll(PDO::FETCH_COLUMN, 0);

		$total_items = (int) $total_results[0];
		$total_pages = (int) ceil( $total_items / $this->items_pre_page );

		return $total_pages;
	}
}
