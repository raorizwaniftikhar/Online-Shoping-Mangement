<?php
	class Database{
		
		/*<?php 
			$link = mysql_connect('nisar1.yourwebhostingmysql.com', 'bssusa', '*password*'); 
			if (!$link) { 
				die('Could not connect: ' . mysql_error()); 
			} 
			echo 'Connected successfully'; 
			mysql_select_db(bssusa); 
		?> */
		
		/*var $err_msg = "";
		var $servername="chicagostore1.yourwebhostingmysql.com";
		var $db_user="cstore";
		var $db_password="cstore";
		var $db_name="cstore";*/

		var $servername="localhost";
		var $db_user="root";
		var $db_password="";
		var $db_name="project";
		function __construct(){
			mysql_connect($this->servername,$this->db_user,$this->db_password) or die("Error in connection to the database server");
			mysql_select_db($this->db_name) or die("Error opening database");
		}
		function query($query){
			
			$result=mysql_query($query);
			if(!$result){
				echo $this->err_msg = '<div style="border:dashed 1px #ff0000; background:#ffffcc; padding:10px; margin:5px; color:#ff0000">'.mysql_error().'<br><br>'.$query.'</div>';
				return false;
			}else{
				return $result;
			}
		}
		function count_rows_by_query($query){
			$result=$this->query($query);
			return mysql_num_rows($result);
		}		
		function fetch_array($result){
			return mysql_fetch_array($result);
		}
		function fetch_assoc($result){
			return mysql_fetch_assoc($result);
		}
		function count_rows($result){
			return mysql_num_rows($result);
		}
		function num_rows($result){
			return mysql_num_rows($result);
		}
		function insert_id(){
			return intval(mysql_insert_id());
		}
		
		function fetch_array_by_query($query){
			$result=$this->query($query);
			return mysql_fetch_array($result);
		}
		function get_insert_id(){
			return intval(mysql_insert_id());
		}
		function get_error(){
			return $this->err_msg;
		}
		function insert($arr,$table_name){
			$cols=implode(",",array_keys($arr));
			$values=implode("','",$arr);
			$values="'".$values."'";
			$query="insert into $table_name ($cols) values($values)";
			$result=$this->query($query);
			if($result){
				return $this->insert_id();
			}
			else{
				return false;
			}
		}
		function update($arr,$id,$table_name){
			$q='';
			foreach($arr as $key=>$value){
				if($q=='')
					$q.="$key='$value'";
				else
					$q.=",$key='$value'";
			}
			$query="update $table_name set $q where id=$id";
			$result = $this->query($query);
			return $result;
		}
		function get_row($table_name,$field,$field_value){
			return $this->fetch_array_by_query("select * from $table_name where $field='$field_value'");
		}
	}
	$db = new Database();
?>