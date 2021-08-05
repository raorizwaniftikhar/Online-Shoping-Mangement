<?php
class Menu{
	
	private $db;
	var $msg;

	function __construct($db){
		$this->db = $db;
	}

}
$menu_category= new Menu($db);
?>