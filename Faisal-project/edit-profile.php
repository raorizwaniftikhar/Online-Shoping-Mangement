<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/preferences.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	include("includes/classes/paging.php");
	include("includes/classes/categories.php");	
	if($a->get_id() <= 0){
		header("location: login.php");
		exit();
	}
	if($_REQUEST['command']=="update_user"){
		$data=array();
		$id=$a->get_id();
		extract($_REQUEST);
		$data['first_name']=$first_name;
		$data['last_name']=$last_name;
		$data['gender']=$gender;
		$data['city']=$city;
		$data['address']=$address;
		$data['phone']=$phone;
		$db->update($data,$id,"members");
		$msg="Your profile has been updated";
	}
	$page_title=" Edit Profile";
	
	$m_row=$m->get_row($a->get_id());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require("includes/common-header.php")?>
</head>
<body style=" background:url(images/My-white-wood-FF16.jpg);">
    <div id="outer-wrapper" >
    	<?php require("includes/header.php")?>
   		<?php require("includes/navi.php")?>
        <?php /*?><div id="slider" style="min-height:300px; margin-top:10px;">
        	<?php include("includes/slider.php"); ?>
        </div><?php */?>
        <div id="content" >
            <div id="leftcontainer" >
                <?php include("includes/member-left.php");?>
            </div>
            <div id="centercontainer3" >
            	<div id="heading" style="margin-left:15px;margin-top:10px;font-size:18px;font-family:Verdana, Geneva, sans-serif;font-weight:bold"><?php echo $page_title;?></div>
                <div>
                    <div ><?php echo $msg; ?></div>
                    <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                        <tr>
                            <td style="padding-top:10px" valign="top">
                                <table border="0px" cellpadding="0px" cellspacing="0px" >
                                    
                                    <tr>
                                        <td valign="top">
                                            <table border="1" style="border-collapse:collapse" width="650px" cellpadding="3px">
                                            	<div id="login-area" style="width:350px;padding:0px 10px;">
                                                    <form name="form1" action="" method="post" >
                                                    <input type="hidden" name="command" value="update_user" />
                                                        <table cellpadding="5" cellspacing="0">
                                                              <tr>
                                                                  <td ><label>First Name:</label></td>
                                                                  <td><input class="field" type="text"   size="28" name="first_name" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['first_name'];?>"/></td>
                                                              </tr>
                                                            
                                                              <tr>
                                                                  <td ><label>Last Name:</label></td>
                                                                  <td><input class="field" type="text" size="28" name="last_name" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['last_name'];?>"/></td>
                                                              </tr>
                                                              <tr>
                                                                  <td ><label>Gender:</label></td>
                                                                  <td>
                                                                  	<input class="field" type="radio" name="gender" style="color:#FFA953;  border-radius:5px;" value="male" <?php if($m_row['gender']=="male") {echo 'checked="checked"'; } ?> />Male &nbsp;
                                                                    <input class="field" type="radio" name="gender" style="color:#FFA953;  border-radius:5px;" value="female" <?php if($m_row['gender']=="female") {echo 'checked="checked"'; } ?>/>FeMale &nbsp;
                                                                  </td>
                                                              </tr>
                                                              <tr>
                                                                  <td ><label>User Name:</label></td>
                                                                  <td><input class="field" type="text" size="28" name="username" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['username'];?>" readonly="readonly"/></td>
                                                              </tr>
                                                              <tr>
                                                                  <td ><label>Email:</label></td>
                                                                  <td><input class="field" type="text" size="28" name="email" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['email'];?>" readonly="readonly"/></td>
                                                              </tr>
                                                              <tr>
                                                                  <td ><label>address:</label></td>
                                                                  <td><input class="field" type="text" size="28" name="address" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['address'];?>" /></td>
                                                              </tr>
                                                              <tr>
                                                                  <td ><label>City:</label></td>
                                                                  <td><input class="field" type="text" size="28" name="city" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['city'];?>" /></td>
                                                              </tr>
                                                              <tr>
                                                                  <td ><label>Phone:</label></td>
                                                                  <td><input class="field" type="text" size="28" name="phone" style="color:#FFA953;  border-radius:5px;"  value="<?php echo $m_row['phone'];?>" /></td>
                                                              </tr>
                                                              <tr>
                                                              <td ></td>
                                                                <td><input class="btn"   type="submit"   value="Update" style="background:#FFA953; border:1px solid #FFA953; color:#FFFFFF; border-radius:5px; padding:3px 8px;"/></td>
                                                              </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                            </table>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- centercontainer ends here-->
        </div><!-- content ends here-->
       <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>