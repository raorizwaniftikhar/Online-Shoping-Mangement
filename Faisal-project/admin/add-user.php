<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/categories.php");
	include("../includes/classes/products.php");
	include("../includes/classes/upload-image.php");
	include("../includes/functions.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	
	$section="Users";
	$a->authenticate();
	$page_title="Users";
	$go_back_link='yes';
	//$show_menu='no';
	
	if($_REQUEST['command']=='add'){
		$categoryid=intval($_REQUEST['categoryid']);
		$name=addslashes($_REQUEST['name']);
		$newarrival=addslashes($_REQUEST['newarrival']);
		$itemno=$_REQUEST['itemno'];
		$description=addslashes($_REQUEST['description']);
		$detail=mysql_escape_string($_REQUEST['detail']);
		$price=$_REQUEST['price'];
		$sub_cat_id=$_REQUEST['sub_cat_id'];
		//$price=floatval($_REQUEST['price']);
		$t=time();
		
		//$endtime=$pro->get_time_from_datetime($_REQUEST['endtime']);
		$arr=array('categoryid'=>$categoryid,'sub_cat_id'=>$sub_cat_id,'title'=>$name,'description'=>$description,'detail'=>$detail,'date_created'=>$t,'price'=>$price,'newarrival'=>$newarrival);
		$result=$db->insert($arr,"products");
		if($result){
			$id=$db->insert_id();
			for($i=1;$i<=9;$i++){
				$pic='pic'.$i;
				if($_FILES[$pic]['name']=='') continue;
				$parts=pathinfo($_FILES[$pic]['name']);
				$ext=strtolower($parts['extension']);
				$filename=filter_chars($name).substr(md5(rand(1,9999)),4,7).$id.$i.".".$ext;
				$full_path="../product-pics/".$filename;
				if(move_uploaded_file($_FILES[$pic]['tmp_name'],$full_path)){
	
					$thumb1_path="../product-pics/thumb1-".$filename;
					$thumb2_path="../product-pics/thumb2-".$filename;
					
					createThumb($full_path,$thumb1_path,0,258);
					createThumb($full_path,$thumb2_path,110,0);
					
					$pro->update_pic($id,$i,$filename);
				}
			}
		}
		header("location: products.php");
		exit();
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
		$arr['type'] = $type;
		$q = mysql_query("insert into members(username,password,first_name,last_name,address,phone,email,locked,type)values('$username','$password','$first_name','$last_name','$address','$phone','$email','no','$type')");
		
	?>
    <script type="text/javascript">
    alert("user added successfully");
	window.location='users.php';
    </script>
    <?php
		}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="../jquery-ui/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-ui/js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="../jquery-ui/js/jquery-ui-timepicker-addon.js"></script>


<script language="javascript">

	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		editor_selector : "mceEditor",
		editor_deselector : "mceNoEditor"
	});

	function validate(){
		var f=document.frmAdd;
		if(f.name.value==''){
			alert("Product name is required");
			f.name.focus();
			return false;
		}
		else if(f.categoryid.value<1){
			alert("Please select a category");
			f.categoryid.focus();
			return false;
		}
		
		else if(f.price.value==""){
			alert("Please Enter Price");
			f.price.focus();
			return false;
		}
		//else if(f.companyid.value<1){
//			alert("Please select a company");
//			f.companyid.focus();
//			return false;
//		}
		
		f.command.value='add';
		return true;
	}
</script>
<script type="text/javascript">
		function get_sub(id){
			$.ajax({
				type: "POST",  
				url: "get_sub.php",
				data: "id="+id,
				success: function(response_text){ 
					if(response_text!= '')	{
						$('#sub_cat').html(response_text);
					}
					else{
						$("#sub_cat").html("<option value=''>Select One</option>");
					}
				}
			}); 
		}
		/*$(document).ready(function (){
			update_stats();
		setInterval(update_stats,5000);						
			
		});
		*/
 

</script>
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
</head>
<body>
<div id="container">
    <div id="header"><?php include("includes/header.php"); ?></div>
    <div id="topBar"><?php include("includes/top-bar.php"); ?></div>
    <?php if ($show_menu!='no'){ ?><div id="menu"><?php include("includes/menu.php"); ?></div><?php } ?>
    <div id="content">
    	<?php include("includes/msg_code.php"); ?>
        <div class="locationBar">
            <div style="float:left;" class="pageHeading">&nbsp; <?php echo $page_title; ?></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                    <form id="registerfrm" name="registerfrm" action="" method="post" onsubmit="return validate_register()" >
                       
                                <input type="hidden" name="command" />
                                    <table cellpadding="5" cellspacing="0">
                                    
                                          <tr>
                                          <td ><label>First Name: <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="text" name="first_name"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;"  /></td>
                                          </tr>
                                          <tr>
                                          <td ><label>Last Name: <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="text" name="last_name"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                          </tr>
                                          
                                          <tr>
                                          <td ><label>Username:  <span style="color:#F20000"> *</span></label></td>
                                          <td><input class="field" type="text" name="username"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                          </tr>
                                          
                                           <tr>
                                          <td ><label>Email:  <span style="color:#F20000"> *</span></label></td>
                              <td><input class="field" type="email" name="email"  multiple="multiple" size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;"/></td>
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
                                              <td ><label>Type:  <span style="color:#F20000"> *</span></label></td>
                                              <td><select name="type">
                                              <option>Accounts manager</option>
                                              <option>Sales manager</option>
                                              <option>Purchase manager</option>
                                              
                                              
                                              </select></td>
                                          </tr>
                                          <tr>
                                         
                                          <td><input class="btn"   type="submit"   value="Add User" style="background:#FFA953; border:1px solid #FFA953; color:#FFFFFF !important; border-radius:5px; padding:3px 8px;color:#FFA953;  border-radius:5px;"/> </td>
                                          </tr>
                                    </table>
                            </form>
                    </td>
                </tr>
            </table>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>