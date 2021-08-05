<?php
	class Company{
		private $db;
		function __construct($db){
			$this->db=$db;
		}
		function auth_login($username,$password){
			$query="select id from members where (username = '".$username."' or email=  '".$username."')and password = '" .$password."' and member_type='company'" ; 
			if($this->db->count_rows_by_query($query)){
				$array_query=$this->db->fetch_array_by_query($query);
				return $array_query['id'];
			}else{
				return false;
			}
		}
		function add_company($arr){
			$cols=implode(",",array_keys($arr));
			$values=implode("','",$arr);
			$values="'".$values."'";
			$result=$this->db->query("insert into members ($cols) values($values)");
			if($result){
				return $this->db->get_insert_id();
			}
			else{
				return false;
			}
		}
		function update_company($arr,$id){
			$q='';
			foreach($arr as $key=>$value){
				if($q=='')
					$q.="$key='$value'";
				else
					$q.=",$key='$value'";
			}
			$query="update members set $q where id=$id";
			$result = $this->db->query($query);
			return $result;
		}
		
		function delete_company($id){
			$result =$this->db->query("delete from members where id=$id");
			return $result;
		}
		function already_exist($name,$id=0){
			$id=intval($id);
			
			if($id>0){
				$query="select * from members where company_name='$name' and id<>$id";
			}else{
				$query="select * from members where company_name='$name'";
			}
			if($this->db->count_rows_by_query($query)){
				return true;
			}else{
				return false;
			}
		}
		function username_already_exist($username,$id=0){

			
			if($id>0){
				$query="select * from members where username='$username' and id<>$id";
			}else{
				$query="select * from members where username='$username'";
			}
			
			if($this->db->count_rows_by_query($query)){
				return true;
			}else{
				return false;
			}
		}
		function get_row($id){
			$result=$this->db->query("select * from members where id=$id");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function get_logo($name){
			return BASE_URL."member-pics/thumb-".$name;
		}
		function filter_chars($text){
			$text=str_replace(" ","-",$text);
			$arr=array("/","?","&","%","\\",":");
			$text=str_replace($arr,"",$text);
			return $text;
		}
		
	}
	$company=new Company($db);
?>