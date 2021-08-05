<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	$section="Products";
	$a->authenticate();
	$page_title="Product Sub Categories";
	$go_back_link='no';
	
	if($_REQUEST['command']=='add'){

		$categoryid=intval($_REQUEST['categoryid']);
		$name=addslashes($_REQUEST['name']);
		$description=addslashes($_REQUEST['description']);
		$result=$c->add_subcategory($categoryid,$name,$description);
		if($result){
			header("location:categories.php");
		}
		else{
			$msg=$q."<br>".mysql_error();
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
		var f=document.frmAdd;
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
		f.command.value='add';
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
                    <form name="frmAdd" onsubmit="return validate()" method="post" >
	                    <input type="hidden" name="command" />
	                    <input type="hidden" name="id" />                        
                    	<table border="0px" cellpadding="2px" cellspacing="0px">
                            <tr>
                            	<td>Category:</td>
                                <td>
                                	<select name="categoryid" class="select">
                                	<?php
										$result=$db->query("select * from product_categories");
										while($row=$db->fetch_array($result)){
											$name=$row['name'];
											$id=$row['id'];
									?>
                                    	<option value="<?php echo $id?>"><?php echo $name?></option>
                                    <?php
										}
                                    ?>
                                    </select>
                                    <?php if($_REQUEST['categoryid']>0){ ?>
                                    <script language="javascript">
										document.frmAdd.categoryid.value=<?php echo $_REQUEST['categoryid']?>;
									</script>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                            	<td>Name:</td>
                                <td><input type="text" name="name" class="textbox" value="<?php $_REQUEST['name'];?>" /></td>
							</tr>
                            <tr valign="top">
                            	<td>Description:</td>
                                <td><textarea name="description" rows="3" style="width:400px"><?php $_REQUEST['description']?></textarea></td>
							</tr>                            
                        	<tr>
                            	<td>&nbsp;</td>
                                <td><input type="submit" value="Add Sub Category" /></td>
                            </tr>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
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