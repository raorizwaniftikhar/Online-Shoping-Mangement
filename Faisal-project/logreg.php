<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/preferences.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	if($a->get_id() > 0){
		header("location: index.php");
		exit();
	}
	if($_REQUEST['command']=='login'){
		extract($_REQUEST);
		$result=$db->query("select * from members where (username='$username' or email='$username') and password='$password'");
		if ($db->count_rows($result)>0){
			$row=$db->fetch_assoc($result);
			if ($row['locked']=='no'){
				$a->create_session($row['id']);
				header("location: index.php");
				exit();
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
		$arr['address']=$address;
		$arr['phone']=$phone;
		$arr['locked']='no';
		if($m->username_exist($username)){
			$msg="UserName Already Exist";
		}
		else if($m->email_exist($email)){
			$msg="Email Already Exist";
		}
		else{
			$result=$db->insert($arr,"members");
			if($result){
				$id=$db->get_insert_id();
				$a->create_session($id);
				header("location: index.php");
				exit();
			}
			else{
				$msg="Error ";
			}
		}
	}
	$page_title="Login / Register";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<?php require("includes/common-header.php")?>
    <script language="javascript">
function validate_user(){
	var f= document.loginfrm;
	if(f.username.value==""){
		alert("Please Enter Username");
		f.username.focus();
		return false;
	}
	else if(f.password.value==""){
		alert("Please Enter Password");
		f.password.focus();
		return false;
	}
	else{
		f.command.value="login";
		return true;
	}
}
</script>
<script language="javascript">
function validate_register(){
	var f=document.registerfrm;
	if(f.first_name.value==''){
		alert("Please Enter First Name");
		f.first_name.focus();
		return false;
	}
	else if(f.last_name.value==''){
		alert("Please Enter Last Name");
		f.last_name.focus();
		return false;
	}
	else if(f.username.value==''){
		alert("Please Enter UserName");
		f.username.focus();
		return false;
	}
	else if(f.email.value==''){
		alert("Please Enter Email");
		f.email.focus();
		return false;
	}
	else if(f.password.value==''){
		alert("Please Enter Password");
		f.password.focus();
		return false;
	}
	else if(f.password.value != f.confpassword.value){
		alert("Password Missmatch");
		f.password.focus();
		return false;
	}
	else if(f.address.value==""){
		alert("Please Enter Address");
		f.address.focus();
		return false;
	}
	else if(f.phone.value==""){
		alert("Please Enter Phone");
		f.phone.focus();
		return false;
	}
	else{
		
		f.command.value='register';
		return true;
	}
}
</script>
<style>
	label{
		font-family:Verdana, Geneva, sans-serif;
		font-weight:bold;
		font-size:12px;
	}
</style>
</head>
<body style=" background-color: #FC7862;">
    <div id="outer-wrapper" >
    <?php require("includes/header.php")?>
    <?php require("includes/navi.php")?>
        <div id="content" >
            <div id="container">
            <h1>Login&nbsp;&nbsp;/&nbsp;&nbsp;Sign&nbsp;Up</h1>
            <div style="color:#F00; font-family:Verdana, Geneva, sans-serif;font-size:14px;"><?php echo $msg;?></div>
                <p id="contactArea" >
                    <div id="login-area" style="width:350px;padding:0px 10px;">
                         <h2> Login<h2>
                        <form id="loginfrm" name="loginfrm" action="" method="post" onsubmit="return validate_user()" >
                        <input type="hidden" name="command" />
                            <table cellpadding="5" cellspacing="0">
                                  <tr>
                                  <td ><label>Username / Email:</label></td>
                                  <td><input class="field" type="text"   size="28" onfocus="select();" name="username" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $_REQUEST['username'];?>"/></td>
                                  </tr>
                                
                                  <tr>
                                  <td ><label>Password:</label></td>
                                  <td><input class="field" type="password" size="28"onfocus="select();" name="password" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $_REQUEST['password'];?>"/></td>
                                  </tr>
                                  
                                  <tr>
                                  <td ></td>
                                    <td><input class="btn"   type="submit"   value="Sign In" style="background:#FFA953; border:1px solid #FFA953; color:#FFFFFF; border-radius:5px; padding:3px 8px;"/></td>
                                  </tr>
                            </table>
                        </form>
                    </div>
                    <div id="register-area" style="padding:0px 10px;">
                     <h2>Sign Up<h2>
                            <form id="registerfrm" name="registerfrm" action="" method="post" onsubmit="return validate_register()" >
                                <input type="hidden" name="command" />
                                    <table cellpadding="5" cellspacing="0">
                                    
                                          <tr>
                                          <td ><label>First Name: <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="text" name="first_name"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" value="<?php echo $_REQUEST['first_name'];?>" /></td>
                                          </tr>
                                          <tr>
                                          <td ><label>Last Name: <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="text" name="last_name"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" value="<?php echo $_REQUEST['last_name']; ?>"/></td>
                                          </tr>
                                          
                                          <tr>
                                          <td ><label>Username:  <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="text" name="username"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" value="<?php echo $_REQUEST['username'];?>"/></td>
                                          </tr>
                                          
                                           <tr>
                                          <td ><label>Email:  <span style="color:#F20000"> *</span></label></td>
                                            <td><input class="field" type="email" name="email"  multiple="multiple" size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" value="<?php echo $_REQUEST['email'];?>"/></td>
                                          </tr>
                                        
                                          <tr>
                                          <td ><label>Password:  <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="password" name="password"   size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                          </tr>
                                          
                                           <tr>
                                              <td ><label> Retype Password:  <span style="color:#F20000"> *</span></label></td>
                                              <td><input class="field" type="password" name="confpassword"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                          </tr>
                                          <tr>
                                              <td ><label> Address:  <span style="color:#F20000"> *</span></label></td>
                                              <td><input class="field" type="text" name="address"  size="28" style="color:#FFA953;  border-radius:5px;" /></td>
                                          </tr>
                                          <tr>
                                              <td ><label>Phone:  <span style="color:#F20000"> *</span></label></td>
                                              <td><input class="field" type="text" name="phone"  size="28" style="color:#FFA953;  border-radius:5px;" /></td>
                                          </tr>
                                          <tr>
                                          <td >         </td>
                                          <td><input class="btn"   type="submit"   value="Sign Up" style="background:#FFA953; border:1px solid #FFA953; color:#FFFFFF; border-radius:5px; padding:3px 8px;color:#FFA953;  border-radius:5px;"/></td>
                                          </tr>
                                    </table>
                            </form>
                    </div>
                 </p>
            </div>
        </div>
        <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>