<?php
class Paggination
{

	/* These are defaults */
	public $TotalResults;
	public $CurrentPage = 1;
	public $PageVarName = "page";
	public $ResultsPerPage = 20;
	public $LinksPerPage = 10;
	public $result;
	public $numbers;

	function __construct() {
		$_RESULT_PER_PAGE 			= FRONT_RECORDS_PER_PAGE;
		$_TOTAL_LINKS 				= FRONT_RECORDS_LINKS_PER_PAGE;
		$_PAGE_PARAM                = FRONT_RECORDS_PAGE_PARAM;
		$TOTAL_ROWS_IN_A_PAGE       = $_RESULT_PER_PAGE;
		$this->ResultsPerPage       = $TOTAL_ROWS_IN_A_PAGE;
		$this->LinksPerPage         = $_TOTAL_LINKS;
		$this->PageVarName          = $_PAGE_PARAM;
	}

	private function InfoArray() {
		$this->TotalPages = $this->getTotalPages();
		$this->CurrentPage = $this->getCurrentPage();
		$this->ResultArray = array(
		"PREV_PAGE" => $this->getPrevPage(),
		"NEXT_PAGE" => $this->getNextPage(),
		"CURRENT_PAGE" => $this->CurrentPage,
		"TOTAL_PAGES" => $this->TotalPages,
		"TOTAL_RESULTS" => $this->TotalResults,
		"PAGE_NUMBERS" => $this->getNumbers(),
		"MYSQL_LIMIT1" => $this->getStartOffset(),
		"MYSQL_LIMIT2" => $this->ResultsPerPage,
		"START_OFFSET" => $this->getStartOffset(),
		"END_OFFSET" => $this->getEndOffset(),
		"RESULTS_PER_PAGE" => $this->ResultsPerPage,
		);
		return $this->ResultArray;
	}

	/* Start information functions */
	private function getTotalPages() {
		/* Make sure we don't devide by zero */
		if($this->TotalResults != 0 && $this->ResultsPerPage != 0) {
			$this->result = ceil($this->TotalResults / $this->ResultsPerPage);
		}
		/* If 0, make it 1 page */
		if(isset($this->result) && $this->result == 0) {
			return 1;
		} else {
			return $this->result;
		}
	}

	private function getStartOffset() {
		$offset = $this->ResultsPerPage * ($this->CurrentPage - 1);
		if($offset != 0) { $offset++; }
		return $offset;
	}

	private function getEndOffset() {
		if($this->getStartOffset() > ($this->TotalResults - $this->ResultsPerPage)) {
			$offset = $this->TotalResults;
		} elseif($this->getStartOffset() != 0) {
			$offset = $this->getStartOffset() + $this->ResultsPerPage - 1;
		} else {
			$offset = $this->ResultsPerPage;
		}
		return $offset;
	}

	private function getCurrentPage() {
		if(isset($_GET[$this->PageVarName])) {
			return $_GET[$this->PageVarName];
		} else {
			return $this->CurrentPage;
		}
	}

	private function getPrevPage() {
		if($this->CurrentPage > 1) {
			return $this->CurrentPage - 1;
		} else {
			return false;
		}
	}

	private function getNextPage() {
		if($this->CurrentPage < $this->TotalPages) {
			return $this->CurrentPage + 1;
		} else {
			return false;
		}
	}

	private function getStartNumber() {
		$links_per_page_half = $this->LinksPerPage / 2;
		/* See if curpage is less than half links per page */
		if($this->CurrentPage <= $links_per_page_half || $this->TotalPages <= $this->LinksPerPage) {
			return 1;
			/* See if curpage is greater than TotalPages minus Half links per page */
		} elseif($this->CurrentPage >= ($this->TotalPages - $links_per_page_half)) {
			return $this->TotalPages - $this->LinksPerPage + 1;
		} else {
			return $this->CurrentPage - $links_per_page_half;
		}
	}

	private function getEndNumber() {
		if($this->TotalPages < $this->LinksPerPage) {
			return $this->TotalPages;
		} else {
			return $this->getStartNumber() + $this->LinksPerPage - 1;
		}
	}

	private function getNumbers() {
		for($i=$this->getStartNumber(); $i<=$this->getEndNumber(); $i++) {
			$this->numbers[] = $i;
		}
		return $this->numbers;
	}



	public function getPaggingData()
	{

		/* Get our array of valuable paging information! */
		$PaggingData = $this->InfoArray();
		return $PaggingData;
	}

}
?>