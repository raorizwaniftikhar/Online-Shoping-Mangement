<?php
	class Members{
		var $db;
		private $msg;
		function __construct($db){
			$this->db=$db;
		}
		function get_row($id){
			$result=$this->db->query("select * from members where id=$id");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function get_type($id){
			$result=$this->db->query("select member_type from members where id=$id");
			$row=$this->db->fetch_array($result);
			return $row['member_type'];
		}

		function del($id){
			$result=$this->db->query("delete from members where id=$id");
			return $result;
		}
		
		function update_login($id,$status){
			$result =$this->db->query("update members set login = '".$status."' where id = ".$id);
			return $result;
		}
		function email_exist($email){
			$row=$this->db->fetch_array_by_query("select * from members where email = '".$email."'");
			if($row){
				return true;
			}
			else{
				return false;
			}
		}
		function username_exist($username){
			$row=$this->db->fetch_array_by_query("select * from members where username= '".$username."'");
			if($row){
				return true;
			}
			else{
				return false;
			}
		}
		function change_password($id,$password){
			$result=$this->db->query("update members set password='$password' where id=$id");	
			if($result)
			{
				return true;
			}
		}
		
		function update_last_login($id){
			$t=time();
			$this->db->query("update members set last_login=$t , logins=logins+1 where id=$id");
		}
		function get_userid($username){
			$result=$this->db->query("select * from members where username='$username' ");
			$row=$this->db->fetch_array($result);
			return $row['serial'];
		}
		function updated_email_already_exists($email,$id){
			$result=$this->db->query("select * from members where email='$email' and id<>$id");
			$no=$this->db->num_rows($result);
			if($no>0){
				return true;
			}
			else{
				return false;
			}
		}
		function change_lock($id){
			$row=$this->get_row($id);
			if($row['locked']=='yes')
			{
				$this->db->query("update members set locked='no' where id=$id");
			}
			else{
				$this->db->query("update members set locked='yes' where id=$id");
			}
		}
		function is_locked($email){
			if($this->db->count_rows_by_query("select * from members where email = '$email' and locked = 'yes'")>0){
				return true;
			}else{
				return false;
			}
		}
		function get_row_by_email($email){
			$result=$this->db->query("select * from members where email='$email'");
			$row=$this->db->fetch_array($result);
			return $row;
		}
		function get_available_credits($user_id){
			$row=$this->db->fetch_array_by_query("select credits from members where id=$user_id");
			return $row['credits'];
		}
		function reduce_user_credits($user_id,$credits_to_reduce){

			$available=$this->get_available_credits($user_id);
			$remaining=$available-$credits_to_reduce;
			return $this->db->query("update members set credits=$remaining where id=$user_id");
		}
		function get_profile_percentage($user_id){
			$row=$this->db->fetch_array_by_query("select * from members where id=$user_id");
			
			$total_fields=13;
			$fields_completed=7;
			
			if ($row['pic']!='')	$fields_completed++;
			if ($row['address']!='')	$fields_completed++;
			if ($row['city']!='')	$fields_completed++;
			if ($row['state']!='')	$fields_completed++;
			if ($row['zip']!='')	$fields_completed++;
			if ($row['phone']!='')	$fields_completed++;
			
			return ceil($fields_completed/$total_fields*100);
		}
		function add_friend($fid,$memberid){
			$status=$this->already_friend($fid,$memberid);
			if( $status==""){
				$date_invitation=time();
				$query="insert into friends(member1,member2,invitation_date,status) values('$memberid','$fid','$date_invitation','invited') ";
				$result=$this->db->query($query);
				if($result){
					return true;
				}
				else{
					$this->msg=$this->db->get_error();
					return false;
				}
			}
			else{
				if($status=="accepted")
					$this->msg="Already In Your FriendList";
				else if($status=="invited"){
					$this->msg="Already Invited";
				}
				else{
					$this->msg="You Have Already Sent Request that has been Rejected..";
				}
				return false;
			}
		}
		function update_friend($fid,$memberid,$status){
			
			$query="update friends set status='$status' where (member1='$memberid' and member2='$fid') or (member2='$memberid' and member1='$fid')";
			$result=$this->db->query($query);
			return $result;
		}
		function already_friend($fid,$memberid){
			$query="select * from friends where (member1='$memberid' and member2='$fid') or (member2='$memberid' and member1='$fid') ";
			$result=$this->db->query($query);
			$row=$this->db->fetch_array($result);
			if($row){
				return $row['status'];
			}
			else{
				return "";
			}
		}
		function my_friends($memberid,$limit='',$status='accepted'){
			$where="";
			if($limit != ""){
				$where =" limit 0 , ".$limit;
			}
			$query="select * from friends where (member1=".$memberid." or member2=".$memberid.") and status='$status'".$where;
			$result=$this->db->query($query);
			return $result;
		}
		function my_total_frinds($memberid,$status='accepted'){
			$query="select * from friends where (member2=".$memberid." or member1=".$memberid.") and status='$status'";
			$count=$this->db->count_rows_by_query($query);
			return $count;
		}
		function get_message(){
			return $this->msg;
		}
		function get_total_members(){
			$t=time();
			return $this->db->count_rows_by_query("select * from members where  member_type='user'");
		}
		function get_total_compnies(){
			$t=time();
			return $this->db->count_rows_by_query("select * from members where  member_type='company'");
		}
		function get_total_auctions($id){
			$query="select * from products where createdby=".$id;
			$count=$this->db->count_rows_by_query($query);
			return $count;
		}
		function get_company_logos(){
			$query_result=$this->db->query("select * from members where member_type='company' and pic!=''  limit 0,5");			
			return $query_result;
		}
		function check_invitation($id,$type){
			$result=$this->db->query("select id from invitations where sender_id=$id and type='$type'");
			if ($this->db->count_rows($result)>0)
				return true;
			else
				return false;
		}
		 function checkUser($uid, $oauth_provider,$name,$email,$firstname,$lastname,$gender,$username,$twitter_otoken,$twitter_otoken_secret) 
		{
			$query = mysql_query("SELECT * FROM `members` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
			$result = mysql_fetch_array($query);
			if (!empty($result)) {
				# User is already present
			} else {
				#user not present. Insert a new Record
				$query = mysql_query("INSERT INTO `members` (oauth_provider, oauth_uid, username,email,firstname,lastname,gender,twitter_oauth_token,twitter_oauth_token_secret) VALUES ('$oauth_provider', '$uid', '$username','$email','$firstname','$lastname','$gender','$twitter_otoken','$twitter_otoken_secret')") or die(mysql_error());
				$query = mysql_query("SELECT * FROM `members` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
				$result = mysql_fetch_array($query);
				return $result;
			}
			return $result;
		}
		function get_name_by_id($id){
			$result=$this->db->query("select * from members where id='$id'");
			$row=$this->db->fetch_array($result);
			return $row['first_name']." ".$row['last_name'];
		}
    



	}$m=new Members($db);
?>