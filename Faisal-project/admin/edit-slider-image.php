<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("../includes/classes/upload-image.php");
	include("includes/classes/auth.php");
	
	include("includes/classes/navigation-menu.php");
	
	$section="Preferences";
	$a->authenticate();
	$page_title="Edit Slider Images";
	$total_pics=5;
	
	$id=$_REQUEST['id'];
	$result=$db->query("select * from slider_images where id=$id");
	$row=$db->fetch_assoc($result);
	
	if ($_REQUEST['add']=='pic'){
		$pic=$_FILES['pic'];
		$title=$_REQUEST['title'];
		$url=$_REQUEST['url'];
		$description=$_REQUEST['description'];
		$section=$_REQUEST['section'];
		if ($pic['tmp_name']!=''){
			$name=time();
			$upload_img->upload_image_with_thumbnail($pic,"../slider-images/",$name,"950",'380','both');
			$name=$upload_img->get_image_name();
			@unlink("../slider-images/$row[name]");
			$result=$db->query("update slider_images set title='$title',name='$name',url='$url' where id=$id");
		}
		else{
			$result=$db->query("update slider_images set title='$title' ,url='$url',description='$description',section='$section' where id=$id");	
		}
		header("location:slider-images.php?msg=Successfully Updated");
		exit();
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
		if(f.title.value==''){
			alert("Please enter the title");
			f.title.focus();
			return false;
		}
		f.command.value='add';
		return true;
	}
	function del(ser,name){
		if (confirm("Are you sure to Delete?")){
			var f=document.delForm;
			f.id.value=ser;
			f.command.value='del';
			f.name.value=name;
			f.submit();
		}
		return false;
	}
</script>
</head>
<body>
<form name="delForm" action="" method="post">
    <input type="hidden" name="id" />
    <input type="hidden" name="command" />
    <input type="hidden" name="name" />
</form>
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
            <div class="headings alt">
                <h2><?php echo $row[title]; ?></h2>
            </div>
            <div class="content_box">                     
               <div style="float:right;"><input type="button" value="Back" onclick="window.location='slider-images.php'"/></div>
                <div style="clear:both;font-size:1px"></div>                
               	<?php include("includes/msg_code.php"); ?>                
                <form name="sliderform" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="add" value="pic" />
                    <table>
                        <tr><td>Picture: </td><td><input type="file" name="pic" /></td></tr>
                        <tr><td>&nbsp;</td><td><img src="../slider-images/<?php echo $row[name]; ?>" width="150" height="100" /></td></tr>
                        <tr><td>Title: </td><td><input size="33" type="text" name="title" value="<?php echo $row[title]; ?>" /></td></tr>
                        <tr><td>URL: </td><td><input size="33" type="text" name="url" value="<?php echo $row[url]; ?>" /></td></tr>
                        <tr><td>Description<?php echo $i; ?>: </td><td><textarea name="description"  style="width:220px;"><?php echo $row['description']; ?></textarea></td></tr>
                        <tr><td>Section<?php echo $row['section']; ?></td><td><select name="section"><option value="main">Main</option><option value="featured">Featured</option></select></tr>
                        <script language="javascript">
							document.sliderform.section.value='<?php echo $row['section']; ?>';
						</script>
                        <tr><td></td><td><input type="submit" value="Submit" style="width:100px;" /></td></tr>
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