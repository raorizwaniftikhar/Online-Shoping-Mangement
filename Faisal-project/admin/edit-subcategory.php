<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	$section="Products";
	$a->authenticate();
	$page_title="Edit Sub Category";
	$go_back_link='no';
	$subid=intval($_REQUEST['subid']);
	$row=$c->get_subrow($subid);
	if(!$row){
		header("location:product_categories.php");
		exit();
	}

	
	if($_REQUEST['command']=='update'){
	
		$categoryid=intval($_REQUEST['categoryid']);
		$name=addslashes($_REQUEST['name']);
		$description=addslashes($_REQUEST['description']);
		
		$check_result=$db->query("select * from product_subcategories where name='$name' and categoryid=$categoryid and id<>$subid");
		if($db->num_rows($check_result)>0){
			$msg='Category already exists';
		}
		else if($categoryid<1){
			$msg='Category is not selected';
		}
		else{
			$result=$c->update_subcategory($subid,$name,$categoryid,$description);
			if($result){
				header("location:categories.php");
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>
<script language="javascript">
	function validate(){
		var f=document.frmEdit;
		if(f.categoryid.value==''){
			alert("Category is not selected");
			f.categoryid.focus();
			return false;
		}
		else if(f.name.value==''){
			alert('Name is missing');
			f.name.focus();
			return false;
		}
		f.command.value='update';
		f.submit();
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
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                    <form name="frmEdit" onsubmit="return validate()" method="post" >
	                    <input type="hidden" name="command" />
	                    <input type="hidden" name="subid" value="<?php echo $subid?>" />                        
                    	<table border="0px" cellpadding="2px" cellspacing="0px">
                            <tr>
                            	<td>Category:</td>
                                <td>
                                	<select name="categoryid" class="select">
                                	<?php
										$cat_result=$db->query("select * from product_categories");
										while($cat_row=$db->fetch_array($cat_result)){
											$name=$cat_row['name'];
											$id=$cat_row['id'];
									?>
                                    	<option value="<?php echo $id?>"><?php echo $name?></option>
                                    <?php			
										}
                                    ?>
                                    </select>
                                    <?php if($row['categoryid']>0){ ?>
                                    <script language="javascript">
										document.frmEdit.categoryid.value=<?php echo $row['categoryid'] ?>;
									</script>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                            	<td>Name:</td>
                                <td><input type="text" name="name" class="textbox" value="<?php echo $row['name'];?>" /></td>
							</tr>
                            <tr valign="top">
                            	<td>Description:</td>
                                <td><textarea name="description" rows="3" style="width:400px"><?php echo $row['description']?></textarea></td>
							</tr>                            
                        	<tr>
                            	<td>&nbsp;</td>
                                <td><input type="submit" value="Update Sub Category" /></td>
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