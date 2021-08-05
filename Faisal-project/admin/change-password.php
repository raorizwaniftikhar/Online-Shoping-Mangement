<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	
	$section="Preferences";
	$a->authenticate();
	$page_title="Preferences";
	if ($_REQUEST['command']=='update'){
		$password=$_REQUEST['password'];
		$query=$db->query("update admin set password='$password'");
		$msg="Password Update Successfully";
		$customersupport=$_REQUEST['customersupport'];
		$p->set_value("customersupport",$customersupport);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>
<script language="javascript">
	function validate(){
		var f=document.frm1;
		if(f.password.value==''){
			alert("Please enter the password");
			f.password.focus();
			return false;
		}
		else if(f.confpassword.value != f.password.value){
			alert("Password MissMatch");
			f.password.focus();
			return false;
		}
		f.command.value='update';
		return true;
	}
</script>
</head>
<body>
<div id="container">
    <div id="header"><?php include("includes/header.php"); ?></div>
    <div id="topBar"><?php include("includes/top-bar.php"); ?></div>
    <div id="menu"><?php include("includes/menu.php"); ?></div> 
    <div id="content">
    	<?php include("includes/msg_code.php"); ?>
        <div class="locationBar">
            <div style="float:left" class="pageHeading">&nbsp; <?php echo $page_title; ?></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
        <div class="content_container">
            <div class="content_box">
                <form name="frm1" action="" method="post" onsubmit="return validate()">
                    <input type="hidden" name="command" />
                    <table>
                        <tr>
                            <td>New Password</td><td><input type="password" name="password" /></td>
                        </tr>
                        <tr>
                            <td>Confirm Password</td><td> <input type="password" name="confpassword" /></td>
                        </tr>
                        
                        <tr>
                        	<td>&nbsp;</td><td><input type="submit" value="Update" /></td>
                        </tr>
                    </table>                     
                 </form>
            </div>
		</div>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>