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
	$id=$_REQUEST['pid'];
	$return=$_REQUEST['return'];
	$page=$_REQUEST['page'];
	$product_row=$pro->get_row($id);
	if(!$product_row){
		header("location:products.php");
		exit();
	}
	
	$page_title="Edit Product";
	$go_back_link='yes';
	$show_menu='no';
	
	if($_REQUEST['command']=='update'){
		$categoryid=intval($_REQUEST['categoryid']);

		$name=addslashes($_REQUEST['name']);
		$newarrival=$_REQUEST['newarrival'];
		$description=addslashes($_REQUEST['description']);
		$detail=mysql_escape_string($_REQUEST['detail']);
		$price=$_REQUEST['price'];
		$sub_cat_id=$_REQUEST['sub_cat_id'];
		//$price=floatval($_REQUEST['price']);
		$t=time();
		//$endtime=$pro->get_time_from_datetime($_REQUEST['endtime']);
		$arr=array('categoryid'=>$categoryid,'sub_cat_id'=>$sub_cat_id,'title'=>$name,'description'=>$description,'detail'=>$detail,'date_created'=>$t,'price'=>$price,"newarrival"=>$newarrival);
		$result=$db->update($arr,$id,"products");
		if($result){
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
		header("location:$return.php?page=$page");
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
		var f=document.frmEdit;
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
		else if(f.detail.value==""){
			alert("please Enter Detail");
			f.detail.focus();
			return false;
		}
		else if(f.price.value==""){
			alert("Please Enter Price");
			f.price.focus();
			return false;
		}
		f.command.value='update';

		return true;		//f.submit();
	}
	$(function() {
		$('#starttime').datetimepicker({
			ampm: true
		});
	   $('#endtime').datetimepicker({
			ampm: true
		});
	});
	
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
                        <form name="frmEdit" onsubmit="return validate()" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="product_type" <?php echo $product_row['product_type']?> />
                        <input type="hidden" name="command" />
                        <input type="hidden" name="id" value="<?php echo $id?>" />
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
                                                            <select name="categoryid" style="width:220px">
                                                            <?php
                                                                $cat_result=$db->query("select * from product_categories");
                                                                while($cat_row=$db->fetch_array($cat_result)){
                                                                    
                                                            ?>
                                                                    <option value="<?php echo $cat_row['id']?>"><?php echo $cat_row['name']?></option>
                                                            <?php
																}
                                                            ?>
                                                            </select>
                                                            <script language="javascript">
                                                                document.frmEdit.categoryid.value='<?php echo $product_row['categoryid']?>';
                                                            </script>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Sub Category</td>
                                                        <td colspan="3">
                                                        	<select name="sub_cat_id" id="sub_cat">
                                                            	<option value="">Select Sub Cat</option>
                                                                <?php
                                                                $cat_result=$db->query("select * from product_subcategories where categoryid=".$product_row['categoryid']);
                                                                while($cat_row=$db->fetch_array($cat_result)){
                                                                    
																?>
																		<option value="<?php echo $cat_row['id']?>"><?php echo $cat_row['name']?></option>
																<?php
																	}
																?>
                                                            </select>
                                                            <script language="javascript">
                                                                document.frmEdit.sub_cat_id.value='<?php echo $product_row['sub_cat_id']?>';
                                                            </script>
                                                        </td>
                                                    </tr>
                                                    <tr><td>Name:</td><td><input type="text" name="name" style="width:400px" value="<?php echo $product_row['title']?>" /></td></tr>
                                                    <!--<tr><td nowrap="nowrap">Item Number:</td><td><input type="text" name="itemno" value="<?php echo $product_row['itemno']?>" style="width:400px" /></td></tr>-->
                                                    <tr valign="top"><td>Description:</td><td><textarea name="description" rows="3" style="width:400px"><?php echo $product_row['description']?></textarea></td></tr>                                    
                                                    <tr valign="top"><td>Detail:</td><td><textarea name="detail" rows="10" style="width:405px" class="mceEditor"><?php echo stripslashes($product_row['detail']);?></textarea></td></tr>
                                                    <tr><td colspan="2">&nbsp;</td></tr>
                                             		<tr>
                                                        <td>Price:</td>
                                                        <td><input type="text"  id="minbid" name="price"  value="<?php echo $product_row['price'];?>"/></td>
                                                    </tr>
                                                    <tr valign="top"><td>&nbsp;</td><td><input type="checkbox" name="newarrival" value="true" <?php if($product_row['newarrival']=='true') { echo 'checked="checked"'; }?>/>New Arrival</td></tr>
                                        <tr><td colspan="2">&nbsp;</td></tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" value="Update" /></td>
                                        </tr>      
                                                </table>
                                            </td>
                                        </tr>
                                       <?php /*?> <tr>
                                <td colspan="2">
                                    <table>
                                     <?php /*?>   <!--<tr>
                                            <td>Bid Starts:</td>
                                            <td>
                                             <input type="text" id="starttime"  name="starttime" <?php if($product_row['start_time'] != "") { echo 'value="'.date("m/d/Y h:i a",$product_row['start_time']).'"';} else { echo 'value="'.$_REQUEST['starttime'].'"'; }   ?>/> </td>
                                        </tr>
                                        <tr>
                                            <td>Bid Ends:</td>
                                            <td><input type="text"  id="endtime" name="endtime" <?php if($product_row['end_time'] != "") { echo 'value="'.date("m/d/Y h:i a",$product_row['end_time']).'"';} else { echo 'value="'.$_REQUEST['endtime'].'"'; }  ?>/></td>
                                        </tr>--><?php *
                                        <tr>
                                            <td>Minimum Points:</td>
                                            <td><input type="text"  id="minbid" name="minbid" <?php if($product_row['start_time'] != "") { echo 'value="'.$product_row['min_bid'].'"';} else { echo 'value="'.$_REQUEST['minbid'].'"'; }  ?>/></td>
                                        </tr>
                                        <tr><td colspan="2">&nbsp;</td></tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" value="Enable Bidding" /></td>
                                        </tr>
                                    </table>
                                </td>
                        </tr><?php */?>
                                    </table>
                                </td>
                                <td style="padding:20px"><div style="border-left:1px #CCC dashed; height:300px">&nbsp;</div></td>
                                <td>
                                    <table>
                                        <tr><td align="left" colspan="2"><b>Product Pictures</b></td></tr>
                                        <tr><td align="left">&nbsp;</td></tr>                        
                                        <?php 
                                            for($i=1;$i<=9;$i++){ 
                                                $pic='pic'.$i;
                                        ?>
                                        <tr valign="top">
                                            <td>
                                                Pic<?php echo $i?>:</td><td><input type="file" name="pic<?php echo $i?>" size="38" />
                                                <?php if($product_row[$pic]!=''){ ?>
                                                <br />
                                                <img src="../product-pics/thumb1-<?php echo $product_row[$pic] ?>" align="absmiddle" />
                                                <span style="color:#999; font-style:italic">To change this picture, click browse</span>
                                                <br /><br />
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
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