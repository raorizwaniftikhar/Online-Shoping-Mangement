<?php
	class c_business{
		var $db;
		var $error;
		function __construct($db){
			$this->db=$db;
		}
		function delete_business($id,$userid=0){
			$id=intval($id);
			$where=" ";
			if($userid !=0)
				$where.= " and userid=$userid";
			$result=$this->db->query("delete from business where id=$id ".$where);
			if($result){
				$this->del_all_services($id);
				$this->del_all_pics($id,$userid);
			}
			return $result;
			
		}
		function unlock_business($id){
			$id=intval($id);
			return $this->db->query("update business set locked = 'no' where serial=$id");
		}
		function lock_business($id){
			$id=intval($id);
			return $this->db->query("update business set locked = 'yes' where serial=$id");
		}
		function add_business($arr,$userid=0)
		{
			extract($arr);
			if (count($category)==0){
				$this->error="Atleast one category Should be selected";
				return false;	
			}
			if (count($category)>1){
			$category=implode(',',$category);
			}else{
				$category=$category[0];
			}
			return $result=$this->db->query("insert into business (userid,categoryid,title,description,address,city,state,zip,website,website2,email,mobile,phone) values ($userid,'$category','$title','$profile','$address','$city','$state','$zip','$website','$website2','$email','$mobile','$phone')");
		}
		function add_business_service($id,$title,$text){
			return $result=$this->db->query("insert into business_services (companyid,service_title,service_text) values ($id,'$title','$text')");
		}
		function get_website_link($id){
			$id=intval($id);
			$query="select * from websites where member_id=$id";
			$result=$this->db->query($query);
			$row=$this->db->fetch_array($result);
			if($row)
				return USER_WEB_LINK.$row['domain'];
		}
		function edit_business($id,$arr,$userid=0){
			extract($arr);
			if (count($category)==0){
				$this->error="Atleast one category Should be selected";
				return false;	
			}
			if (count($category)>1){
			$category=implode(',',$category);
			}else{
				$category=$category[0];
			}
			$where=" ";
			if($userid !=0)
				$where.= " and userid=$userid";
			$result=$this->db->query("update business set categoryid='$category',title='$title',description='$profile',address='$address',city='$city',state='$state',zip='$zip',website='$website',website2='$website2',email='$email',mobile='$mobile',phone='$phone' where id=$id ".$where );
			//echo "update business set categoryid=$category,title='$title',description='$profile',address='$address',city='$city',state='$state',zip='$zip',website='$website',email='$email',mobile='$mobile',phone='$phone' where id=$id";
			//die();
			return $result;
		}
		function edit_business_new($id,$arr){
			extract($arr);
			//echo "update business set categoryid=$category,title='$title',description='$profile',address='$address',city='$city',state='$state',zip='$zip',website='$website',email='$email',mobile='$mobile',phone='$phone' where mid=$id";die();
			$query="update business set categoryid=$category,title='$title',description='$profile',address='$address',city='$city',state='$state',zip='$zip',website='$website',email='$email',mobile='$mobile',phone='$phone' where mid=$id";

			$result=$this->db->query($query);
			
			/*if(!$result){
				$result=$this->db->query("insert into business (categoryid,title,description,address,city,state,zip,website,email,mobile,phone,mid) values ($category,'$title','$profile','$address','$city','$state','$zip','$website','$email','$mobile','$phone','$id')");
			}
			*/
			//echo "update business set categoryid=$category,title='$title',description='$profile',address='$address',city='$city',state='$state',zip='$zip',website='$website',email='$email',mobile='$mobile',phone='$phone' where id=$id";
			//die();
			return $result;
		}
		function del_all_services($id){
			$this->db->query("delete from business_services where companyid=$id");
		}
		function del_all_pics($id,$userid=0){
			$result=$this->db->query("select * from business_pics where companyid=$id");
			while ($row=$this->db->fetch_assoc($result)){
				if($userid==0){
					@unlink("../custom-images/business_images/$row[name]");
					@unlink("../custom-images/business_images/thumb-$row[name]");
				}
				else{
					@unlink("custom-images/business_images/$row[name]");
					@unlink("custom-images/business_images/thumb-$row[name]");
				}
			}
			$this->db->query("delete from business_services where companyid=$id");
		}
		function update_business($id,$categoryid,$username,$password,$email,$title,$services,$address,$city,$state,$zip,$phone,$fax)
		{
			$title = addslashes($title);
			$services = addslashes($services);
			$address = addslashes($address);
			$city = addslashes($city);
			$state = addslashes($state);
			$zip = addslashes($zip);
			$phone = addslashes($phone);
			$fax = addslashes($fax);			
			$queryResult=$this->db->query("update business set username='$username',password='$password',email='$email', categoryid = $categoryid, title = '$title', services = '$services', address = '$address', city= '$city', state='$state',zip='$zip',phone='$phone',fax='$fax' where serial = $id");

			if($queryResult)
			{
				return $queryResult;
			}
			else
				return false;
		}
		
		function get_total_business($start = 0, $no_of_business = -1)
		{
			$limit = "";
			$no_of_business = intval($no_of_business);
			if($no_of_business > 0)
			{
				$limit = " limit $start, $no_of_business";
			}
			$query = "select * from business where locked = 'no' order by date_created desc $limit";
			return $this->db->query($query);
		}
		
		function get_category($categoryid)
		{
			$categoryid = intval($categoryid);
			$query="select * from business_categories where serial=$categoryid";
			$result=$this->db->query($query);
			return $this->db->fetch_array($result);
		}
		function get_category_name_by_cat_ids($cat_ids){
			$query="select * from business_categories where serial in ($cat_ids)";
			$result=$this->db->query($query);
			$name='';
			while($row=$this->db->fetch_assoc($result)){
				$name.=$row['name'].',';
			}
			$name=substr($name,0,-1);
			return $name;
		}
		function get_category_name($categoryid)
		{
			$category_row = $this->get_category_name_by_cat_ids($categoryid);
			return $category_row;
		}

		function get_row($id){
			$id=intval($id);
			$result=$this->db->query("select * from business where serial=$id");
			return $this->db->fetch_array($result);
		}
		function already_registered_email($email){
			$sql="SELECT * FROM business where email='$email'";
			$count=$this->db->num_rows($this->db->query($sql));
			if($count>0){
				return true;
			}else{
				return false;
			}			
		}
		function already_registered_username($username){
			$sql="SELECT * FROM business where username='$username'";
			$count=$this->db->num_rows($this->db->query($sql));
			if($count>0){
				return true;
			}else{
				return false;
			}			
		}
		function change_password($id,$pass){
			$sql="UPDATE business set password='$pass' where serial=$id";
			$result=$this->db->query($sql);
			if($result){
				return true;
			}else{
				return false;
			}
		}
		function get_error(){
			return $this->error;
		}
		function get_professional_id($username,$password){
			$sql="select * from business where username='$username' and password='$password'";
			$result=$this->db->query($sql);
			$row=$this->db->fetch_array($result);			
			return $row['serial'];
		}
	}
	$business=new c_business($db);
?>