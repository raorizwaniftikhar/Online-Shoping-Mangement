<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("../includes/classes/members.php");
	include("../includes/classes/paging.php");
	include("../includes/classes/company.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	include("../includes/functions.php");
	include("../includes/classes/products.php");
	include("../includes/classes/report.php");
	$section="Users";
	$a->authenticate();
	$page_title="Users Detail";
	$go_back_link='no';
	
	$tab='users';
	$a->authenticate();
	$id=intval($_REQUEST['id']);
	$select_user_row= $m->get_row($id);
	$states=get_us_stats_list();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>


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
            <table cellspacing="5">
                                    <tr>
                                        <td class="register_lable">First Name :</td><td class="register_textbox1"><?php if($select_user_row['first_name'] != ""){  echo $select_user_row['first_name']; }else { echo "Not Specified"; }?></td>
                                    </tr>
                                    <tr>
                                        <td class="register_lable">Last Name :</td><td class="register_textbox1"><?php if($select_user_row['last_name'] != ""){  echo $select_user_row['last_name']; }else { echo "Not Specified"; } ?></td>
                                    </tr>
                                    <tr>
                                        <td class="register_lable">Your Email :</td><td class="register_textbox1"><?php if($select_user_row['email'] != ""){  echo $select_user_row['email']; }else { echo "Not Specified"; } ?></td>
                                    </tr>
	                                <tr>
                                        <td class="register_lable">UserName :</td><td class="register_textbox1"><?php if($select_user_row['username'] != ""){  echo $select_user_row['username']; }else { echo "Not Specified"; } ?></td>
                                    </tr>
                                    <tr>
                                        <td class="register_lable">Gender :</td><td class="register_select1">
                                           <?php if($select_user_row['gender'] != ""){  echo $select_user_row['gender']; }else { echo "Not Specified"; }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="register_lable">Address :</td>
                                        <td class="register_textbox1"><?php if($select_user_row['address'] != "") { echo $select_user_row['address']; } else { echo "Not Specified";} ?></td>
                                    </tr>
                                    <tr>
                                        <td class="register_lable">City :</td>
                                        <td class="register_textbox1"><?php if($select_user_row['city'] != ""){ echo $select_user_row['city']; } else { echo "Not Specified" ;}?></td>
                                    </tr>
                                    <tr>
                                        <td class="register_lable">State :</td>
                                        <td class="register_select1">
                                        	<?php if($select_user_row['state'] != ""){ echo  $select_user_row['state']; } else { echo "Not Specified";} ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td class="register_lable">Zip :</td>
                                        <td><div class="register_option1" ><?php if($select_user_row['zip'] != ""){ echo $select_user_row['zip']; } else { echo "Not Specified";} ?></div></td>
                                    </tr>
                                    <tr>
                                    	<td class="register_lable">Phone :</td>
                                        <td class="register_textbox1" ><?php if($select_user_row['phone'] != "") { echo $select_user_row['phone']; } else { echo "Not Specified"; } ?></td>
                                    </tr>
                                    <?php if($select_user_row['pic'] != ""){ ?>
                                    <tr>
                                    	<td class="register_lable" ></td><td><img src="../member-pics/thumb-<?php echo $select_user_row['pic'];?>" /></td>
                                    </tr>
                                    <?php } ?>
                                    
                                </table>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>