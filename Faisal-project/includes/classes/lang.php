<?php
	class Lang{
		private $db;
		function __construct($db){
			$this->db=$db;
		}
		function get_text($id){
			$result=$this->db->query("select * from language where id=$id");
			$row=$this->db->fetch_array($result);
			return $row['text'];
		}
		function add_text($text){
			$this->db->query("insert into language values('','$text')");
		}
	}
	$lang=new Lang($db);
?>