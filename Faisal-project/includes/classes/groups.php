<?php
	class Groups{
		private $db;
		function __construct($db){
			$this->db=$db;
		}
		function add_group($memberid,$name,$description){
			$date_created=time();
			$result=$this->db->query("insert into groups (memberid,name,description,date_created) values($memberid,'$name','$description','$date_created')");
			if($result){
				$groupid=$this->db->get_insert_id();
				$res=$this->db->query("Insert into group_members (groupid,memberid,join_date) values('$groupid','$memberid','$date_created')");
				return $groupid;
			}
			
		}
		function update_group($groupid,$mebmerid,$name,$description){
			$result=$this->db->query("update groups set name='$name',description='$description' where id=$groupid and memberid=$mebmerid");
			return $result;
		}
		function delete_group($id,$memberid){
			$result =$this->db->query("delete from groups where id=$id and memberid=$memberid");
			if($result){
				$rult =$this->db->query("delete from group_wall where groupid=$id ");
				if($rult){
					$rults =$this->db->query("delete from comments where postid=$id and entity='group'");
					if($rults){
						$final_result=$this->db->query("delete from group_members where groupid=".$id);
						return $final_result;
						
					}
				}
			}
		}
		function get_row($id){
			$result=$this->db->query("select * from groups where id=$id");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function group_admin($id){
			$id=intval($id);
			$row=$this->db->fetch_array_by_query("SELECT memberid FROM groups WHERE  id='$id'");
			return $row['memberid'];	
		}
		function member_is_admin($group_id,$userid){
			$row=$this->db->fetch_array_by_query("SELECT count(*) as total FROM groups WHERE memberid='$userid' and id='$group_id'");
			return $row['total'];	
			
		}
		function is_group_member($group_id,$userid){
			if($this->member_is_admin($group_id,$userid)){
				return true;
			}else{
				$row=$this->db->fetch_array_by_query("SELECT count(*) as total FROM group_members WHERE memberid='$userid' and groupid='$group_id'");
				return $row['total'];
			}
		}
		function total_group_members($group_id){
			$row=$this->db->fetch_array_by_query("SELECT count(*) as total FROM group_members WHERE  groupid='$group_id'");
			return $row['total'];
		}
		function get_thumb1($name){
			return BASE_URL."/group-pics/thumb1-".$name;
		}
		function get_thumb2($name){
			return BASE_URL."/group-pics/thumb2-".$name;
		}
		function get_pic($name){
			return BASE_URL."/group-pics/".$name;
		}
		function update_pic($id,$memberid,$pic){
			$result=$this->db->query("update groups set picture='$pic' where id=$id and memberid=$memberid");
			return $result;
		}

		function get_thumb1_width($name){
			$full_path=ROOT."/group-pics/thumb1-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesx($img);
		}
		function get_thumb1_height($name){
			$full_path=ROOT."/group-pics/thumb1-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesy($img);
		}
		function get_thumb2_width($name){
			$full_path=ROOT."/group-pics/thumb2-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesx($img);
		}
		function get_thumb2_height($name){
			$full_path=ROOT."/group-pics/thumb2-".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesy($img);
		}
		function get_pic_height($name){
			$full_path=ROOT."/group-pics/".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesy($img);
		}
		function get_pic_width($name){
			$full_path=ROOT."/group-pics/".$name;
			$img=imagecreatefromjpeg($full_path);
			return imagesx($img);
		}
		function get_display_image($id){
			$row=$this->db->fetch_array_by_query("select * from groups where id=$id");
			for ($i=1;$i<=9;$i++){
				if ($row['pic'.$i]!='')
					return $row['pic'.$i];
			}
			return 'no-image.gif';
		}
		function get_member_groups($memberid){
			$query="select * from group_members where memberid=".$memberid;
			$total_groups=$this->db->count_rows_by_query($query);
			return $total_groups;
		}
	}
	$group=new Groups($db);
?>