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

		//var_dump( $page_data );

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

	public function surroundingItems($filename, $offset=2, $reverse_leading=true) {
		$item_id_stmt = $this->dbh->prepare("
			SELECT
				id
			FROM
				viewable_files
			WHERE
				filename = :filename
		");
		$item_id_stmt->execute(array(":filename"=>$filename));
		$item_id_results = $item_id_stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		$item_id = $item_id_results[0];

		#var_dump($item_id);

		$all_the_ids_stmt = $this->dbh->prepare("
			SELECT
				id
			FROM
				viewable_files
			ORDER BY
				datetime(added) ASC
		");
		$all_the_ids_stmt->execute();
		$all_the_ids = $all_the_ids_stmt->fetchAll(PDO::FETCH_COLUMN, 0);

		#var_dump($all_the_ids);

		$index = array_search($item_id, $all_the_ids);
		$number_of_items = $offset * 2 + 1;

		// try to keep inside the range
		$start_idx = max($index - $offset, 0);
		if ( $index + $offset >= count($all_the_ids) ) {
			$start_idx = max(count($all_the_ids) - $number_of_items, 0);
		}
		$end_idx = min($start_idx + $number_of_items, count($all_the_ids)) - 1;


		$surrounding_ids = array();
		foreach ( range($start_idx, $end_idx) as $idx ) {
			$surrounding_ids[] = $all_the_ids[$idx];
		}

		#var_dump(count($all_the_ids));
		#var_dump($surrounding_ids);

		// now get the full data
		$place_holders = implode(',', array_fill(0, count($surrounding_ids), '?'));
		$surrounding_stmt = $this->dbh->prepare("
			SELECT
				id,
				filename,
				type
			FROM
				viewable_files
			WHERE
				id IN ({$place_holders})
			ORDER BY
				datetime(added) ASC
		");
		$surrounding_stmt->execute($surrounding_ids);
		$surrounding_results = $surrounding_stmt->fetchAll(PDO::FETCH_ASSOC);

		$surrounding_data = array(
			"list"     => $surrounding_results,
			"leading"  => array(),
			"current"  => array(),
			"trailing" => array()
		);

		foreach ( $surrounding_results as $result ) {
			if ( empty($surrounding_data['current']) ) {
				if ( $result['id'] == $item_id ) {
					$surrounding_data['current'] = $result;
				} else {
					$surrounding_data['leading'][] = $result;
				}
			} else {
				$surrounding_data['trailing'][] = $result;
			}
		}
		if ( $reverse_leading ) {
			$surrounding_data['leading'] = array_reverse($surrounding_data['leading']);
		}

		$surrounding_data['current']['page_number'] = (int) ceil(($index+1)/$this->items_pre_page);

		return $surrounding_data;
	}
}
