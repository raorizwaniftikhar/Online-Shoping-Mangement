<?php
	class Paging{
		private $query;
		private $db;
		private $current_page;
		private $results_per_page;
		
		private $total_records;
		private $total_pages;
		
		function __construct($db,$query,$current_page=1,$results_per_page=15){
			$this->query=$query;
			$this->db=$db;
			$this->current_page= $current_page<1 ? 1 : $current_page;
			$this->results_per_page=$results_per_page;
			
			$result=$this->db->query($this->query);
			$this->total_records=$this->db->num_rows($result);
			$this->total_pages=ceil($this->total_records/$this->results_per_page);
		}
		function get_start(){
			$start=($this->current_page-1)*$this->results_per_page;
			return $start;
		}
		function get_total_records(){
			return $this->total_records;
		}
		function get_total_pages(){
			return $this->total_pages;
		}
		function render_pages($b=false){

			$grace=3;						// $grace pages on the left and $grace pages on the right of current page
			$range=$grace*2;

			$start  = ($this->current_page - $grace) > 0 ? ($this->current_page - $grace) : 1;
			$end=$start + $range;
			if($end > $this->total_pages){	//make sure $end doesn't go beyond total pages
				$end=$this->total_pages;
				$start= ($end - $range) > 0 ? ($end - $range) : 1;	//if there is a change in $end, adjust $start again
			}
			$qstring=$_SERVER['QUERY_STRING'];
			$regex='|&?page=\d+|';
			$qstring=preg_replace($regex,"",$qstring);
			$separator=$qstring=='' ? '?' : '?'.$qstring.'&';

if($b){
			if($start>1){
				echo '<a href="page_1" class="pageNo">1</a>...';
			}
			for($i=$start;$i<=$end;$i++){
				if($i==$this->current_page){
					echo "<span class=\"disabledPageNo\">$i</span>";		// Current page is not clickable and different from other pages
				} else {
					echo "<a href=\"page_$i\" class=\"pageNo\">$i</a>";
				}
			}
			if($end < $this->total_pages){
				echo "... <a href=\"page_{$this->total_pages}\" class=\"pageNo\">{$this->total_pages}</a>";	// If $end is away from total pages, add a link of the last page
			}
}
else{
			if($start>1){
				echo '<a href="'.$separator.'page=1" class="pageNo">1</a>...';
			}
			for($i=$start;$i<=$end;$i++){
				if($i==$this->current_page){
					echo "<span class=\"disabledPageNo\">$i</span>";		// Current page is not clickable and different from other pages
				} else {
					echo "<a href=\"".$separator."page=$i\" class=\"pageNo\">$i</a>";
				}
			}
			if($end < $this->total_pages){
				echo "... <a href=\"".$separator."page={$this->total_pages}\" class=\"pageNo\">{$this->total_pages}</a>";	// If $end is away from total pages, add a link of the last page
			}
}

		}
	}
?>