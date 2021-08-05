<?php
	class Products{
		private $db;
		function __construct($db){
			$this->db=$db;
		}

		function delete_product($id){
			$result =$this->db->query("delete from products where id=$id");
			return $result;
		}
		function delete_pic($id,$picid){
			$column='pic'.$picid;
			return $result =$this->db->query("update products set $column='' where id=$id");
			
		}
		function get_row($id){
			$result=$this->db->query("select * from products where id=$id");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function get_category_list(){
			$result=$this->db->query("select * from product_categories ");
			return $result;
		}
		function get_sub_cat_by_cat_id($id){
			$result=$this->db->query("select * from product_subcategories where categoryid='$id' ");
			return $result;
		}	
		function get_thumb1($name){
			return BASE_URL."/productPics/thumb1-".$name;
		}
		function get_thumb2($name){
			return BASE_URL."/productPics/thumb2-".$name;
		}
		function get_pic($name){
			return BASE_URL."/productPics/".$name;
		}
		function update_pic($id,$index,$path){
			$name='pic'.$index;
			$result=$this->db->query("update products set $name='$path' where id=$id");
			return $result;
		}
		function get_product($id){
			$result=$this->db->query("select * from products where id=$id");
			return $row=$this->db->fetch_array($result);
		}
		function get_category($id){
			$result=$this->db->query("select * from product_subcategories where id=$id");
			$row=$this->db->fetch_array($result);
			return $row['name'];
		}
		function get_thumb1_width($name){
			$full_path=ROOT."/productPics/thumb1-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesx($img);
		}
		function get_thumb1_height($name){
			$full_path=ROOT."/productPics/thumb1-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesy($img);
		}
		function get_thumb2_width($name){
			$full_path=ROOT."/productPics/thumb2-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesx($img);
		}
		function get_thumb2_height($name){
			$full_path=ROOT."/productPics/thumb2-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesy($img);
		}
		function get_pic_height($name){
			$full_path=ROOT."/productPics/".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesy($img);
		}
		function get_pic_width($name){
			$full_path=ROOT."/productPics/".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesx($img);
		}
		function filter_chars($text){
			$text=str_replace(" ","-",$text);
			$arr=array("/","?","&","%","\\",":");
			$text=str_replace($arr,"",$text);
			return $text;
		}
		function get_display_image($id){
			$row=$this->db->fetch_array_by_query("select * from products where id=$id");
			for ($i=1;$i<=9;$i++){
				if ($row['pic'.$i]!='')
					return $row['pic'.$i];
			}
			return 'no-image.gif';
		}
		function get_time_from_datetime($datetime){
			$start=explode(" ",$datetime);
			$date=explode("/",$start[0]);
			$time=explode(":",$start[1]);
			$hrs=$time[0];
			if ($start[2]=='pm'&&$time[0]!=12)
				$hrs+=12;
			else if ($start[2]=='am'&&$time[0]==12)
				$hrs=00;
			
			return mktime($hrs,$time[1],0,$date[0],$date[1],$date[2]);
		}
		
		function getCatRow($id){
			$id=intval($id);
			$row=$this->db->fetch_array_by_query("select * from product_categories where id=".$id);
			return $row;
		}
		function getSubCatRow($id){
			$id=intval($id);
			$row=$this->db->fetch_array_by_query("select * from product_subcategories where id=".$id);
			return $row;
		}
		function getSubCatIds($id){
			$no=array();
			$id=intval($id);
			$i=0;
			$cat_result=$this->db->query("select * from product_subcategories where categoryid=".$id);
			 while($cat_row=$this->db->fetch_array($cat_result)){
				 $no[$i]=$cat_row['id'];
				 $i++;
			 }
			 return $no;
			
		}
		function total_products_incat($id){
			$no=0;
			$id=intval($id);
			$cat_result=$this->db->query("select * from product_subcategories where categoryid=".$id);
			 while($cat_row=$this->db->fetch_array($cat_result)){
				 $no=$this->noofcompanyProductsinsubcat($cat_row['id'])+$no;
			 }
			 return $no;
			
		}
		function haveSubCat($id){
			
			$id=intval($id);
			
			$no=$this->db->count_rows_by_query("Select * from product_subcategories where categoryid=".$id);
			if($no>0){
				return true;
			}else{
				return false;
			}
		}
		function render_cat_Menu(){
			 $cat_result=$this->db->query("select * from product_categories");
			 echo '<li><b><a href="auctions.php">All<span></span></a></b></li>';	 
			 while($cat_row=$this->db->fetch_array($cat_result)){
				$total_products_incat=$this->total_products_incat($cat_row['id']);
				if($total_products_incat!=0){
					echo '<li><b><a href="auctions_cat.php?id='.$cat_row['id'].'">'.$cat_row['name'].'<span>('.$total_products_incat.')</span></a></b>';	 
					if($this->haveSubCat($cat_row['id'])){	
						 echo '<ul>';
						$subcat_result=$this->db->query("select * from product_subcategories where categoryid=".$cat_row['id']);
						 while($subcat_row=$this->db->fetch_array($subcat_result)){
							 $noofProductsinsubcat=$this->noofcompanyProductsinsubcat($subcat_row['id']);
							 if($noofProductsinsubcat!=0){
								 echo '<li><a href="auctions_subcat.php?id='.$subcat_row['id'].'">'.$subcat_row['name'].'<span>('.$noofProductsinsubcat.')</span></a></li>';	 
							 }
						 }
						 echo '</ul></li>';
					}else{
						 echo '</li>';
					}
				}
			 }
		}
		function already_in_watchlist($product_id,$user_id){
			$query="select * from watchlist where memberid=".$user_id." and productid=".$product_id;
			$watch_lists_count=$this->db->count_rows_by_query($query);
			if($watch_lists_count){
				return true;
			}else{
				return false;
			}
		}
		function is_read_only($product_id,$user_id){
			$result=$this->db->query("select * from product_rating where product_id=$product_id and user_id=$user_id");
			if ($this->db->count_rows($result)>0)
				return "true";
			else
				return "false";
		}
		function update_keyword($keyword){
			if($keyword!=''){
				$keyword=strtolower($keyword);
				$total_count=$this->get_keyword_total($keyword);
				if($total_count==0){
					$result =$this->db->query("insert into search_keywords (keyword,total_count) values('$keyword',1)");
					return $result;
				}else{
					$total_count++;				
					$result =$this->db->query("update search_keywords set total_count=$total_count where keyword='$keyword'");
					return $result;
				}
			}
		}
		function get_keyword_total($keyword){
			$row=$this->db->fetch_array_by_query("select * from search_keywords where keyword='$keyword'");
			if($row)
				return $row['total_count'];
			else
				return 0;
		}
	}
	$pro=new Products($db);
?>