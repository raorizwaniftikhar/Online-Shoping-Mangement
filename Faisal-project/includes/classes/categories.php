<?php
	class product_categories{
		private $db;
		function __construct($db){
			$this->db=$db;
		}
		function add_category($name){
			$seo_name=$this->filter_chars($name);
			$result=$this->db->query("insert into product_categories(name) values('$name')");
			return $result;
		}
		function update_category($id,$name){
			$result=$this->db->query("update product_categories set name='$name' where id=$id");
			return $result;
		}
		function delete_category($id){
			$this->db->query("delete from product_categories where id=$id");			
		}
		function get_row($id){
			$result=$this->db->query("select * from product_categories where id=$id");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function name_exists($name,$id=0){
			$result=$this->db->query("select * from product_categories where name='$name' and id<>$id");
			if($this->db->num_rows($result)>0)
				return true;
			else
				return false;
		}
		function get_id($name){
			$result=$this->db->query("select * from product_categories where name='$name'");
			$row=$this->db->fetch_array($result);
			return $row['id'];
		}
		function add_subcategory($categoryid,$name){
			if($this->get_row($categoryid)==false) return false;			
			$result=$this->db->query("insert into product_subcategories(categoryid,name) values($categoryid,'$name')");
			return $result;
		}
		function update_subcategory($id,$name,$categoryid){
			$result=$this->db->query("update product_subcategories set categoryid=$categoryid,name='$name' where id=$id");
			return $result;
		}
		function get_subrow($id){
			$result=$this->db->query("select * from product_subcategories where id=$id");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function delete_subcategory($id){
			$this->db->query("delete from product_subcategories where id=$id");
		}
		function sub_exists($id,$categoryid,$name){
			$result=$this->db->query("select * from product_subcategories where categoryid=$categoryid and name='$name' and id<>$id");
			if($this->db->num_rows($result)>0)
				return true;
			else
				return false;
		}
		function get_subname($subid){
			$result=$this->db->query("select * from product_subcategories where id=$subid");
			$row=$this->db->fetch_array($result);
			return $row['name'];
		}
		function get_parentname($id){
			$result=$this->db->query("select * from product_categories where id=(select categoryid from product_subcategories where id=$id)");
			$row=$this->db->fetch_array($result);
			return $row['name'];
		}
		function get_parentid($id){
			$result=$this->db->query("select * from product_categories where id=(select categoryid from product_subcategories where id=$id)");
			$row=$this->db->fetch_array($result);
			return $row['id'];
		}
		function get_product_count($sub_cat_id){
			$result=$this->db->query("select count(*) as total from products where sub_cat_id=$sub_cat_id");
			$row=$this->db->fetch_array($result);
			return $row['total'];
		}
		function filter_chars($text){
			$text=str_replace(" ","-",$text);
			$arr=array("/","?","&","%","\\",":");
			$text=str_replace($arr,"",$text);
			return $text;
		}
	}
	$c=new product_categories($db);
?>