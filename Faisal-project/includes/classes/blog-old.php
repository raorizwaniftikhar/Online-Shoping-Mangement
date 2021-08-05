<?php
	class blog{
		var $db;
		
		function __construct($db){
			$this->db = $db;
		}		
		function add_blog($member_id,$blogName,$blogaddress){
			$sql="select * from blogs where blogaddress='$blogaddress' and userid = $member_id";
			if($this->db->count_rows_by_query($sql)==0){
				$sql="insert into blogs (userid, blogname,blogaddress,locked) values ('$member_id','$blogName','$blogaddress','no')";
				if($this->db->query($sql))
					return "Your Blog is Created Successfully.";
				else
					return "Blog Not Created. Try Again Later.";
			}else{
				return "This Blog Address Already Exist. Try Some Different";
			}
		}		
		function add_blog_category($blog_id,$categoryname){
			$sql="select * from blogs_categories where name='$categoryname' and blogid=$blog_id";
			if($this->db->count_rows_by_query($sql)==0){
				$sql="insert into blogs_categories (blogid,name) values ('$blog_id','$categoryname')";
				if($this->db->query($sql))
					return "Category Created";
				else
					return "Category Not Created";
			}else{
				return "Category Already Exist";
			}
		}
		function insert_into_blog_comments($name,$email,$web,$comments,$postid,$date){
			$sql="insert into blogs_comments (name,email,web,comments,postid,date,locked) values('$name','$email','$web','$comments','$postid','$date','no')";
			$this->db->query($sql);
		}
		function update_blog_category($serial,$categoryname){
			$sql="select * from blogs_categories where serial!='$serial' and name = '$categoryname'";
			if($this->db->count_rows_by_query($sql)==0){
				$sql="update blogs_categories set name='$categoryname' where serial=$serial";
				if($this->db->query($sql))
					return "Category Updated";
				else
					return "Category Not Updated";
			}else{
				return "Category Already Exist";
			}
		}
		function unlock_multiple_blog_comments($serial){
			$serial=intval($serial);
			$sql="update blogs_comments set locked='no' where serial in ($serial)";
			$result=$this->db->query($sql);
			return $result;
		}
		function unlock_single_blog_comment($serial){
			$serial=intval($serial);
			$sql="update blogs_comments set locked='no' where serial=$serial";
			$result=$this->db->query($sql);
			return $result;
		}		
		function lock_multiple_blog_comments($serial){
			$serial=intval($serial);
			$sql="update blogs_comments set locked='yes' where serial in ($serial)";
			$result=$this->db->query($sql);
			return $result;
		}
		function lock_single_blog_comment($serial){
			$serial=intval($serial);
			$sql="update blogs_comments set locked='yes' where serial in ($serial)";
			$result=$this->db->query($sql);
			return $result;
		}
		function delete_multiple_blog_comments($serial){
			$serial=intval($serial);
			$sql="delete from blogs_comments where serial in ($serial)";
			$result=$this->db->query($sql);
			return $result;			
		}
		function delete_single_blog_comment($serial){
			$serial=intval($serial);
			$sql="delete from blogs_comments where serial=$serial";
			$result=$this->db->query($sql);
			return $result;			
		}
		function delete_cat($serial){
			$sql="delete from blogs_posts_cats where categoryid=$serial";
			$sql1="delete from blogs_subcategories where categoryid=$serial";
			$sql2="delete from blogs_categories where serial=$serial";
			if($this->db->query($sql) and $this->db->query($sql1) and $this->db->query($sql2))
				return "All Postes, Subcategories and Category Deleted";
			else
				return "Unknown System Error! Some values Not Deleted";
		}
		function delete_blogpost_and_category($serial){
			$sql="delete from blogs_posts_cats where postid in ($serial)";
			$this->db->query($sql);		
			$sql="delete from blogs_posts where serial in ($serial)";
			$result=$this->db->query($sql);
			return $result;
		}
		function add_blog_subcategory($categoryid,$subcategoryname){

			$sql="select * from blogs_subcategories where categoryid=$categoryid and name='$subcategoryname'";
			if($this->db->count_rows_by_query($sql)==0){
				$sql="insert into blogs_subcategories (categoryid,name) values ('$categoryid','$subcategoryname')";
				if($this->db->query($sql))
					return "Sub Category Created";
				else
					return "Sub Category Not Created";
			}else{
				return "Sub Category Already Exist";
			}
		}
		
		function update_blog_subcategory($serial,$subcategoryname){
			$sql="select * from blogs_subcategories where serial!=$serial and name='$subcategoryname'";
			if($this->db->count_rows_by_query($sql)==0){
				$sql="update blogs_subcategories set name='$subcategoryname' where serial=$serial";
				if($this->db->query($sql))
					return "Sub Category Updated";
				else
					return "Sub Category Not Updated";
			}else{
				return "Sub Category Already Exist";
			}
		}
		
		function delete_subcat($serial){
			$sql="delete from blogs_posts_cats where subcategoryid=$serial";
			$sql2="delete from blogs_subcategories where serial=$serial";
			if($this->db->query($sql) and $this->db->query($sql2))
				return "All Postes and Subcategory Deleted";
			else
				return "Unknown System Error! Some values Not Deleted";
		}
		
		function add_blog_post($blogid,$date,$title,$sub_title,$fulltext){
			$sql="insert into blogs_posts (blogid,date,title,sub_title,`fulltext`) values('$blogid','$date', '$title','$sub_title', '$fulltext')";
			if($this->db->query($sql))
				return "New Blog Post Published";
			else
				return "New Blog Post Not Published";
		}
		
		function update_blog_post($postid,$date,$title,$sub_title,$fulltext){
			$sql="update blogs_posts set title='$title', sub_title='$sub_title',`fulltext`='$fulltext', date='$date' where serial=$postid";
			if($this->db->query($sql))
				return "Blog Post Updated";
			else
				return "Blog Post Not Updateds";
		}
		
		function relate_posts_cats($cats,$subcats,$postid){
			$is_uncategorized=true;
			if(is_array($cats)){
				for($i=0; $i<count($cats); $i++){
					$catid=$cats[$i];
					$subcategoryid=0;
					$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($catid,$subcategoryid,$postid)";
					$this->db->query($sql);
					$is_uncategorized=false;
				}
			}else if($cats!=""){
				$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($cats,$subcategoryid,$postid)";
				$this->db->query($sql);
				$is_uncategorized=false;
			}
			
			if(is_array($subcats)){
				for($i=0; $i<count($subcats); $i++){
					$subcatid=$subcats[$i];
					$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($subcatid,$postid)";
					$this->db->query($sql);
					$is_uncategorized=false;
				}
			}else if($subcats!=""){
				$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($subcats,$postid)";
				$this->db->query($sql);
				$is_uncategorized=false;
			}
			
			if($is_uncategorized){
				$subcats=0;
				$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($subcats,$postid)";
				$this->db->query($sql);
			}
		}
		
		function deletePost($serial){
			$sql="delete from blogs_posts_cats where postid=$serial";
			$this->db->query($sql);
			$sql="delete from blogs_comments where postid=$serial";
			$this->db->query($sql);			
			$sql="delete from blogs_posts where serial=$serial";
			if($this->db->query($sql)){
				return "Post Deleted";
			}else{
				return "Post Not Deleted";
			}
		}
		function check_blog_exist($member_id){
			if($this->db->count_rows_by_query("select * from blogs where userid = $member_id")){
				return true;
			}else{
				return false;
			}
		}
		function get_query_blogpost(){
			$sql="select * from blogs_posts";
			return $sql;
		}
		function get_query_user_blogpost($serial){
			$sql="select * from blogs_posts where blogid='$serial'";
			return $sql;
		}
		function get_blogs_posts_by_limit(){
			$sql="select * from blogs_posts order by serial desc limit 0,10";
			$result=$this->db->query($sql);
			return $result;
		}
		function get_blog_comments($postid){
			$sql="select * from blogs_comments where postid=$postid and locked = 'no'";
            $result=$this->db->query($sql);
			return $result;
		}
		function get_row_blogs_posts($postid){
			 $sql="select * from blogs_posts where serial=$postid";
             $result=$this->db->query($sql);
             $row=$this->db->fetch_array($result);
			 return $row;
		}
		function get_blogs_posts_pagewise($blog_id,$start,$recordPerPage){
			$sql="select * from blogs_posts where blogid = $blog_id order by serial desc limit $start,$recordPerPage";
			$result=$this->db->query($sql);
			return $result;
		}
		function get_post_title($post_id){
			$row = $this->db->fetch_array_by_query("select * from blogs_posts where serial=$post_id");
			return $row['title'];
		}
		function get_cat_post_count($cat_id){
			return $this->db->count_rows_by_query("select * from blogs_posts_cats where  categoryid= $cat_id");
		}
		function get_sub_cat_post_count($sub_cat_id){
			return $this->db->count_rows_by_query("select * from blogs_posts_cats where  subcategoryid= $sub_cat_id");
		}
		function get_comments_count($post_id){
			return $this->db->count_rows_by_query("select serial from blogs_comments where postid = $post_id and locked = 'no'");
		}
		function get_blog_row_by_userid($member_id){
			return $this->db->fetch_array_by_query("select * from blogs where userid = $member_id");
		}
		function get_blog_row_by_serial($serial){
			return $this->db->fetch_array_by_query("select * from blogs where serial = $serial");
		}
		function get_blog_categories_by_serial($serial){			
			$serial=intval($serial);
			$result=$this->db->query("select * from blogs_categories where blogid='$serial'");
			return $result;
		}
		function get_blog_category_by_catid($catid){			
			$catid=intval($catid);
			$result=$this->db->query("select * from blogs_subcategories where categoryid=$catid");
			return $result;
		}
		function get_blog_posts_by_id($blogid){
			$sql="select * from blogs_posts where blogid = '$blogid'";
			$result=$this->db->query($sql);
			return $result;
		}
		function get_query_blog_comments($postSerials){
			$sql="select * from blogs_comments where postid in ($postSerials)";
			return $sql;
		}
		function get_query_disapprove_comments($postSerials){
			$sql="select * from blogs_comments where postid in ($postSerials) and locked='yes' order by date desc";
			return $sql;
		}
		function get_query_approve_comments($postSerials){
			$sql="select * from blogs_comments where postid in ($postSerials) and locked='no' order by date desc";
			return $sql;
		}
		function get_query_comments($postSerials){
			$sql="select * from blogs_comments where postid in ($postSerials) order by date desc";
			return $sql;
		}
		function get_popular_blog_post(){
			$sql="select postid,COUNT(*) AS CNT from blogs_comments GROUP BY `groupid` ORDER BY CNT DESC  limit 0,1";
			return $this->db->query($sql);
		}
		function evaluate_cats_for_add($blog_id,$cats,$subcats,$postid,$is_uncategorized,$catsRelatedWithThePosts){
			
			if(is_array($subcats)){
				for($i=0; $i<count($subcats); $i++){
					$subcatDetail=explode(",",$subcats[$i]);
					$catid=$subcatDetail[0];
					$subcatid=$subcatDetail[1];
					$sql="insert into blogs_posts_cats (blogid,categoryid,subcategoryid,postid) values('$blog_id','$catid','$subcatid','$postid')"; 
					$this->db->query($sql);
					$is_uncategorized=false;
					if($catsRelatedWithThePosts=='')
						$catsRelatedWithThePosts=$catid;
					else
						$catsRelatedWithThePosts=$catsRelatedWithThePosts.",".$catid;
				}
			}else if($subcats!=""){
				$subcatDetail=explode(",",$subcats);
				$catid=$subcatDetail[0];
				$subcatid=$subcatDetail[1];
				$sql="insert into blogs_posts_cats (blogid,categoryid,subcategoryid,postid) values('$blog_id','$catid','$subcatid','$postid')";
				$this->db->query($sql);
				$is_uncategorized=false;
				if($catsRelatedWithThePosts=='')
					$catsRelatedWithThePosts=$catid;
				else
					$catsRelatedWithThePosts=$catsRelatedWithThePosts.",".$catid;
			}
			$catsRelatedWithThePosts=explode(",",$catsRelatedWithThePosts);
			
			if(is_array($cats)){
				for($i=0; $i<count($cats); $i++){
					$catid=$cats[$i];
					if(!in_array($catid,$catsRelatedWithThePosts)){
						$subcategoryid=0;
						$sql="insert into blogs_posts_cats (blogid,categoryid,subcategoryid,postid) values('$blog_id','$catid','$subcategoryid','$postid')";
						$this->db->query($sql);
						$is_uncategorized=false;
					}
				}
			}else if($cats!=""){
				if(!in_array($cats,$catsRelatedWithThePosts)){
					$subcategoryid=0;
					$sql="insert into blogs_posts_cats (blogid,categoryid,subcategoryid,postid) values('$blog_id','$cats','$subcategoryid','$postid')";
					$this->db->query($sql);
					$is_uncategorized=false;
				}
			}
			
			if($is_uncategorized){
				$catid=0;
				$subcategoryid=0;
				$sql="insert into blogs_posts_cats (blogid,categoryid,subcategoryid,postid) values('$blog_id','$catid','$subcategoryid','$postid')";
					$this->db->query($sql);
			}
		
		}
		function evaluate_cats_for_edit($cats,$subcats,$postid,$is_uncategorized,$catsRelatedWithThePosts){
			if(is_array($subcats)){
				for($i=0; $i<count($subcats); $i++){
					$subcatDetail=explode(",",$subcats[$i]);
					$catid=$subcatDetail[0];
					$subcatid=$subcatDetail[1];
					$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($catid,$subcatid,$postid)";
					$this->db->query($sql);
					$is_uncategorized=false;
					if($catsRelatedWithThePosts=='')
						$catsRelatedWithThePosts=$catid;
					else
						$catsRelatedWithThePosts=$catsRelatedWithThePosts.",".$catid;
				}
			}else if($subcats!=""){
				$subcatDetail=explode(",",$subcats);
				$catid=$subcatDetail[0];
				$subcatid=$subcatDetail[1];
				$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($catid,$subcatid,$postid)";
				$this->db->query($sql);
				$is_uncategorized=false;
				if($catsRelatedWithThePosts=='')
					$catsRelatedWithThePosts=$catid;
				else
					$catsRelatedWithThePosts=$catsRelatedWithThePosts.",".$catid;
			}
			$catsRelatedWithThePosts=explode(",",$catsRelatedWithThePosts);
			
			if(is_array($cats)){
				for($i=0; $i<count($cats); $i++){
					$catid=$cats[$i];
					if(!in_array($catid,$catsRelatedWithThePosts)){
						$subcategoryid=0;
						$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($catid,$subcategoryid,$postid)";
						$this->db->query($sql);
						$is_uncategorized=false;
					}
				}
			}else if($cats!=""){
				if(!in_array($cats,$catsRelatedWithThePosts)){
					$subcategoryid=0;
					$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($cats,$subcategoryid,$postid)";
					$this->db->query($sql);
					$is_uncategorized=false;
				}
			}
			
			if($is_uncategorized){
				$catid=0;
				$subcategoryid=0;
				$sql="insert into blogs_posts_cats (categoryid,subcategoryid,postid) values($catid,$subcategoryid,$postid)";
					$this->db->query($sql);
			}
		}
	}
	$blog = new blog($db);
	
	$blog_name = "admin";
	$blog_address = "admin";
	$blog_user_id = 1;
?>