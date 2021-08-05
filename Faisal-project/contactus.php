<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/preferences.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	
	if($_REQUEST['cmd']=='save'){
		//$arr=array("name"=>$_REQUEST['name'],"phone"=>$_REQUEST['phone'],"text"=>$_REQUEST['text'],"date"=>time());
		$from_name=$_REQUEST['name'];	
			$from_email=$_REQUEST['email'];	
			$subject="Query From Web";
			$message=addslashes($_REQUEST['text']);
			eval("\$body= \"$message\";");
			
			$header="From: $from_name <$from_email>\r\n";
			$header.="Content-type:text/html";
			
			$ok=mail("zafar_tanzeela@yahoo.com",$subject,$body,$header);
			if($ok){
				$msg="We have received your query we will contact you soon...";
			}
			else{
				$msg="Error";
			}
//		mail("tauqer15@gmail.com","query",$_REQUEST['
	}
	$page_title="Contact Us";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<?php require("includes/common-header.php")?>
    
<script language="javascript">
function validate(){
	var f=document.frmlogin;
	if(f.name.value==''){
		alert("Please Enter Name");
		f.name.focus();
		return false;
	}

	else if(f.email.value==''){
		alert("Please Enter Email");
		f.email.focus();
		return false;
	}else if(f.text.value==''){
		alert("Please enter text");
		f.text.focus();
		return false;
	}
	else{
		
		f.cmd.value='save';
		f.submit();
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
<body style="background-color: #FC7862;">
    <div id="outer-wrapper" >
    <?php require("includes/header.php")?>
    <?php require("includes/navi.php")?>
        <div id="content" >
            <div id="container">
            <h1><?php echo $page_title;?></h1>
            <div style="color:#F00; font-family:Verdana, Geneva, sans-serif;font-size:14px;"><?php echo $msg;?></div>
                <p id="contactArea" >
                    <div id="login-area" style="width:350px;padding:0px 10px;width:800px" >

                        <form name="frmlogin" action="" method="post" onSubmit="return validate()" style="border: 1px #CCC solid;
    padding: 48px;">
                            <input type="hidden" name="cmd"  />
                        <table>
                        	<tr>
                            	<td colspan="2"><?php echo $msg;?></td>
                            </tr>
                            <tr>
                                <td><label>Name: *</label></td>
                                <td><input type="text" name="name" /></td>
                            </tr>
                            <tr>
                                <td nowrap><label>email: *</label></td>
                                <td><input type="text" name="email" /></td>
                            </tr>
                            
                            <tr>
                                <td valign="top"><label>Text: *</label></td>
                                <td><textarea name="text" style="width:500px; height:200px"></textarea></td>
                            </tr>
                        </table>
                        <p>* Required Fields</p>
                        <div class="bottomArea">
                            <input type="submit" value="Send">
    <!--                                        <a href="forgot-password.php" class="forgotPswd">Forgot your password?</a>-->
                        </div>
                        </form>
                    </div>
                    
                 </p>
            </div>
        </div>
        <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>