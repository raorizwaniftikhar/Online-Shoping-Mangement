<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	$section="Products";
	$a->authenticate();
	$page_title="Product Categories";
	$go_back_link='no';
	
	if($_REQUEST['command']=='add'){
		$name=trim($_REQUEST['category']);
		if($c->name_exists($name)){
			$msg='Error: Category already exists';
		}
		else{
			$c->add_category($name);
		}
	}
	else if($_REQUEST['command']=='delete' && $_REQUEST['id']>0){
		//if(!$c->get_subcat_count($_REQUEST['id'])){
			$c->delete_category($_REQUEST['id']);
			$msg="Category has been deleted";
		/*}else{
			$msg="This Category Contains Sub-Categories";		
		}*/
		header("location:categories.php?msg=$msg");
	}
	else if($_REQUEST['command']=='update' && $_REQUEST['id']>0){
		$name=$_REQUEST['category'];
		$c->update_category($_REQUEST['id'],$name,'no');
		header("location:categories.php");
	}
	else if($_REQUEST['command']=='delete_sub' && $_REQUEST['id']>0){
		if(!$c->get_product_count($_REQUEST['id'])){
			$c->delete_subcategory($_REQUEST['id']);

		}else{
			$msg="This Sub-Category Contain Products";		
		}
		header("location:categories.php?msg=$msg");
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
		if(f.category.value==''){
			alert("Category is not entered");
			f.category.focus();
			return false;
		}
		f.command.value='add';
		f.submit();
	}
	function edit_record(name,id){
		var f=document.frmAdd;		
		var s=prompt("Edit Category",name);
		if(s!='' && s!=null){
			f.category.value=s;
			f.command.value='update';
			f.id.value=id;
			f.submit();
		}
		else{
			return false;
		}
	}
	function add_record(name){
		var f=document.frmAdd;		
		var s=prompt("Category Name",name);
		if(s!='' && s!=null){
			f.category.value=s;
			f.command.value='add';
			f.submit();
		}
		else{
			return false;
		}
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
                <div align="right" style="padding:10px"><a href="javascript:void" onclick="add_record('<?php echo $row['name']?>')">New Category</a></div>
                <form name="frmAdd" onsubmit="return validate()" method="post" >
                        <input type="hidden" name="command" />
                        <input type="hidden" name="category" />
                        <input type="hidden" name="id" />
                            <?php
                                $result=$db->query("select * from product_categories");
                                while($row=$db->fetch_array($result)){
                            ?>
                        <div class="cat_heading">
                        <table width="100%" style="font-weight:normal">
                            <tr>
                                <td width="480px" style="padding:3px"><b><?php echo $row['name']?></b></td>
                                <td align="center"><a href="add-subcategory.php?categoryid=<?php echo $row['id']?>">New Sub Category</a> | <a href="?command=delete&id=<?php echo $row['id']?>" onclick="if(confirm('Do you really want to delete this entry')){return true;}else{return false;}">Delete</a> | <a href="javascript:void" onclick="edit_record('<?php echo $row['name']?>',<?php echo $row['id']?>)">Edit</a></td>
                            </tr>
                        </table>
                        </div>
                        <div style="padding:5px">
                            <ul class="cat_ul_list">
								<?php
                                    $sub_result=$db->query("select * from product_subcategories where categoryid=".$row['id']);
                                    while($sub_row=$db->fetch_array($sub_result)){
                                ?>
                                <li style="border-bottom:solid 1px #CCC; padding:3px;">
                                	<table width="100%" border="0">
                                    	<tr>
                                        	<td width="621"><?php echo $sub_row['name']?> <span style="color:#F90">(<?php echo $c->get_product_count($sub_row['id']);?>)</span></td>
                                            <td><a href="?command=delete_sub&id=<?php echo $sub_row['id']?>" onclick="if(confirm('Do you really want to delete this entry')){return true;}else{return false;}">Delete</a> | <a href="edit-subcategory.php?subid=<?php echo $sub_row['id']?>">Edit</a></td>
                                   		</tr>
                                 	</table>
                                </li>
								<?php
                                        }
                                ?>
                            </ul>
                        </div>
                        <?php
                            }
                        ?>
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