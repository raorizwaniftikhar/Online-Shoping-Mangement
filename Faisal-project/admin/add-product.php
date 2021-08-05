<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/categories.php");
	include("../includes/classes/products.php");
	include("../includes/classes/upload-image.php");
	include("../includes/functions.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	
	$section="Products";
	$a->authenticate();
	$page_title="Add Product";
	$go_back_link='yes';
	$show_menu='no';
	
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
                    <form name="frmAdd" onsubmit="return validate()" method="post" enctype="multipart/form-data">
				       <input type="hidden" name="command" />
                        <table border="0">
                            
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <tr valign="top">
                                <td>
                                    <table border="0px" cellpadding="0px" cellspacing="0px">
                                        <tr><td align="left"><b>Product Detail</b></td></tr>
                                        <tr><td align="left">&nbsp;</td></tr>
                                        <?php if($msg!=''){ ?> <tr><td class="error"><?php echo $msg?></td></tr> <?php } ?>
                                        <tr>
                                            <td valign="top">
                                                <table border="0px" class="label">
                                                    <tr>
                                                        <td>Category:</td>
                                                        <td colspan="3">	
                                                            <select name="categoryid" style="width:220px" onchange="get_sub(this.value)">
                                                            	<option value="">Select Category</option>
                                                            <?php
                                                                $cat_result=$db->query("select * from product_categories");
                                                                while($cat_row=$db->fetch_array($cat_result)){
                                                                    //$sub_result=$db->query("select * from product_subcategories where categoryid=".$cat_row['id']);
                                                                    //echo '<optgroup label="'.$cat_row['name'].'">';
                                                                    //while($sub_row=$db->fetch_array($sub_result)){
                                                            ?>
                                                                    <option value="<?php echo $cat_row['id']?>"><?php echo $cat_row['name']?></option>
                                                            <?php //} 
                                                                   // echo '<optgroup>';
                                                                }
                                                            ?>
                                                            </select>
                                                        </td>
                                                    </tr>
													<tr>
                                                    	<td>Sub Category</td>
                                                        <td colspan="3">
                                                        	<select name="sub_cat_id" id="sub_cat">
                                                            	<option value="">Select Sub Cat</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr><td>Name:</td><td><input type="text" name="name" style="width:400px" /></td></tr>
                                                    <!--<tr><td nowrap="nowrap">Item Number:</td><td><input type="text" name="itemno" style="width:400px" /></td></tr>-->
                                                    <tr valign="top"><td>Description:</td><td><textarea name="description" rows="3" style="width:400px"></textarea></td></tr>                                    
                                                    <tr valign="top"><td>Detail:</td><td><textarea name="detail" rows="10" style="width:405px" class="mceEditor"></textarea></td></tr>
                                                    <tr valign="top"><td>&nbsp;</td><td><input type="checkbox" name="newarrival"  />New Arrival</td></tr>
                									<!--<tr><td>Price ($):</td><td><input type="text" name="price" size="5" /></td></tr>-->
                                                    <!--<tr><td>Shipping ($):</td><td><input type="text" name="shipping" size="5" /></td></tr>-->
                                                    <tr><td colspan="2">&nbsp;</td></tr>
                                        <tr>
                                            <td>Price:</td>
                                            <td><input type="text"  id="price" name="price"/></td>
                                        </tr>
                                        <tr><td colspan="2">&nbsp;</td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="padding:20px"><div style="border-left:1px #CCC dashed; height:300px">&nbsp;</div></td>
                                <td>
                                    <table>
                                        <tr><td align="left" colspan="2"><b>Product Pictures</b></td></tr>
                                        <tr><td align="left">&nbsp;</td></tr>                        
                                        <?php for($i=1;$i<=9;$i++){ ?>
                                        <tr><td>Pic<?php echo $i?>:</td><td><input type="file" name="pic<?php echo $i?>" size="38" /></td></tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	<table>
                                        
                                        <tr><td colspan="2">&nbsp;</td></tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" value="Save" /></td>
                                        </tr>
                                    </table>
                                </td>
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