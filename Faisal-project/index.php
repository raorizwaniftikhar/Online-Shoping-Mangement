<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/preferences.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	include("includes/classes/paging.php");
	include("includes/classes/categories.php");	
	if($_REQUEST['command']=='login'){
		extract($_REQUEST);
		$result=$db->query("select * from members where (username='$username' or email='$username') and password='$password'");
		if ($db->count_rows($result)>0){
			$row=$db->fetch_assoc($result);
			if ($row['locked']=='yes'){
			
				$a->create_session($row['id']);
				$a->update_status('online');
				$redirect_url=$_REQUEST['redirect_url'];
				/*if ($redirect_url)
					header("location: $redirect_url");
				else{
					header("location:index.php");
				}
				exit();*/
			}
		}
		else{
			$msg="Invalid Username / Email or Password";
		}
	}
	if($_REQUEST['command']=='register'){
		extract($_REQUEST);
		$arr= array();
		$arr['first_name']=$first_name;
		$arr['last_name']=$last_name;
		$arr['username']=$username;
		$arr['email']=$email;
		$arr['password']=$password;
		if($member->username_exist($username)){
			$msg="UserName Already Exist";
			
		}
		else if($member->email_exist($email)){
			$msg="Email Already Exist";
		}
		else{
			$result=$db->insert($arr,"members");
			if($result){
				$id=$db->get_insert_id();
				$a->create_session($id);
				/*<!--header("location: index.php");
				exit();-->*/
			}
			else{
				$msg="Error ";
			}
		}
	}
	$page_title=" Home ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require("includes/common-header.php")?>
</head>
<body style=" background-color: #FC7862;">

    <div id="outer-wrapper" >
    	<?php require("includes/header.php")?>
   		<?php require("includes/navi.php")?>
        <div id="slider" style="min-height:300px; margin-top:10px;">
        	<?php include("includes/slider.php"); ?>
        </div>
        
       <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>