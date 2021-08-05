<?php
	class Preferences{
		var $db;
		function __construct($db){
			$this->db=$db;
		}
		
		function set_value($field,$value){
			return $result=$this->db->query("update preferences set value='$value' where name='$field'");
		}
		function get_value($field){
			$row=$this->db->fetch_array_by_query("select value from preferences where name='$field'");
			return $row['value'];
		}
	}
	
	$p=new Preferences($db);
?>