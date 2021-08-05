<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("includes/classes/auth.php");
	if($_REQUEST['command']=='login'){
		$username=$_REQUEST['username'];
		$password=$_REQUEST['password'];
		$type = $_REQUEST['type'];
		if($type=='Admin')
		{
		$query="select * from admin where username='$username' and password='$password'";
		}
		else
			{
				
				$query="select * from members where username='$username' and password='$password' and type='$type'";
				
				
			}
		$result=$db->query($query);
		if($db->num_rows($result)>0){
			$row=$db->fetch_array($result);
			$_SESSION['type']= $_REQUEST['type'];
			
			$a->create_session(1); 
			$_SESSION['ip']=$row['ip'];
			$_SESSION['last_login']=$row['last_login'];		
			$ip=$_SERVER['REMOTE_ADDR'];
			//$db->query("update admin set ip='$ip', last_login=".time());
						header("location:index.php");
			exit(1);
		}
		else{
			$msg="Invalid username or password!";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
	function setFocus(){
		document.form1.username.focus();
	}
	function validate(){
		var f=document.form1;
		if(f.username.value==''){
			f.username.focus();
			return false;
		}
		else if(f.password.value==''){
			f.password.focus();
			return false;
		}
		f.command.value='login';
	}
</script>
<link type="text/css" rel="stylesheet" href="css/login.css" />
</head>
<body onload="setFocus();">
	<div class="box">
		<div class="welcome" id="welcometitle"><?php echo APP_TITLE; ?> Admin Panel, Please Login: <!--//  Welcome message -->
	</div>
	<div id="fields">
    <form name="form1" onsubmit="return validate()" method="post">
    <input type="hidden" name="command" />
        <table width="333">
			<?php if($msg!=''){ ?><tr><td>&nbsp;</td><td style="color:red"><?php echo $msg?></td></tr><?php } ?>
          <tr>
            <td width="79" height="35"><span class="login">USERNAME</span></td>
            <td width="244" height="35"><label>
              <input name="username" type="text" class="fields" id="username" size="30" />  <!--//  Username field  -->
            </label></td>
          </tr>
          <tr>
            <td height="35"><span class="login">PASSWORD</span></td>
            <td height="35"><input name="password" type="password" class="fields" id="password" size="30" /></td> <!--//  Password field -->
          </tr>
          <tr>
            <td height="35"><span class="login">Login As</span></td>
            <td height="35"><select name="type">
            <option>Admin</option>
                                              <option>Accounts manager</option>
                                              <option>Sales manager</option>
                                              <option>Purchase manager</option>
                                              
                                              
                                              </select></td> <!--//  Password field -->
          </tr>
          <tr>
            <td height="65">&nbsp;</td>
            <td height="65" valign="middle"><label>
              <input name="button" type="submit" class="button" id="button" value="LOGIN" />
              <!--//  login button -->
            </label></td>
          </tr>
        </table>
	</form>
	</div>
	 <!--//  lost password part -->
	<div class="copyright" id="copyright">
    
	  Copyright &copy; <?php echo TITLE?> 2011.  <a href="../">Go to website.</a></div>
	</div>
</body>
</html>