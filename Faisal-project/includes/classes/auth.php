<?php
	class auth{
		var $db;
		function __construct($db){
			session_start();
			$this->db=$db;
			if($_SESSION['uid']>0){
				$t=time();
				$uid=$_SESSION['uid'];
			}
		}
		function authenticate($this_url='',$redirect=true,$theme=false){
			if($this_url=='' && $_SERVER['REQUEST_URI']!=''){
				$this_url=basename($_SERVER['SCRIPT_FILENAME']).'?'.$_SERVER['QUERY_STRING'];
			}
			if($_SESSION['uid']<1){
				if($redirect){
					if($theme){
						header("location:".BASE_URL."/../login.php?redirect_url=".urlencode($this_url));
					}else{
						header("location:".BASE_URL."login.php?redirect_url=".urlencode($this_url));
					}
					exit();
				}
			}
			return $_SESSION['uid'];
		}
		
		function create_session($userid){
			$_SESSION['uid']=$userid;
		}
		function update_status($status){
			$uid=$this->get_id();
			$time=time();
			if(intval($uid) > 0)
				$result=$this->db->query("update members set status='$status' ,last_active = '$time' where id=$uid");
		}
		function get_status($id){
			$uid=$id;
			$result=$this->db->query("select * from  members  where id=$uid");
			$row=$this->db->fetch_array($result);
			return $row['status'];
		}
		function get_id(){
			return $_SESSION['uid'];
		}
		function get_type($id){
			$query="select * from members where id='$id'";
			$result=$this->db->query($query);
			$row=$this->db->fetch_array($result);
			$m_type=$row['m_type'];
			$query_type="select * from membership_types where id='$m_type'";
			$row_m_type=$this->db->fetch_array_by_query($query_type);
			return $row_m_type['name'];
			
		}
		function logout(){
			unset($_SESSION['uid']);
		}
		function who_iam(){
			$uid=intval($_SESSION['uid']);
			$result=$this->db->query("select * from members where id=$uid");
			$row=$this->db->fetch_array($result);
			if($row){
				return ucfirst($row['first_name']).' '.$row['last_name'];
			}
			else{
				return 'Guest ['.$_SERVER['REMOTE_ADDR'].']';
			}
		}
		function save_domain($domain){
			$_SESSION['domain']=$domain;
		}
		function get_domain(){
			return $_SESSION['domain'];
		}
		function check_permission($url=''){
			$member_id=$this->get_id();
			$redirect=false;
			if ($url==''){
				$this_url=basename($_SERVER['SCRIPT_FILENAME']);
				$redirect=true;
			}
			else{
				$this_url=$url;
			}
			$permissions_denied=array(
				'1'=>'coupons.php,add-coupons.php,edit-coupons.php,jobs.php,add-jobs.php,edit-jobs.php,my-website.php,',
				'2'=>'my-website.php',
				'3'=>'upgrade-membership.php'
			);
			$result=mysql_query("select m_type from members where id=$member_id");
			$member_row=mysql_fetch_assoc($result);
			$member_row['m_type'];
			foreach($permissions_denied as $mem_type=>$not_allowed){
				if ($mem_type==$member_row['m_type']){
					$arr=explode(',',$not_allowed);
					if (in_array($this_url,$arr)){
						if ($redirect===true){
							header("location: index.php");
							exit();
						}
						else{
							return false;
						}
					}
					break;
				}
			}
			return true;
		}

	}
	$a=new auth($db);
?>