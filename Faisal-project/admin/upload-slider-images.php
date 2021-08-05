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
	$page_title="Add slider images";
	$total_pics=5;
	
	if ($_REQUEST['add']=='pic'){
		$count=0;
		for ($i=1;$i<=$total_pics;$i++){
			$pic=$_FILES['pic'.$i];
			$title=$_REQUEST['title'.$i];
			$link=$_REQUEST['link'.$i];
			
			$url=$_REQUEST['url'.$i];
			$description=$_REQUEST['description'.$i];
			if ($pic['tmp_name']!=''){
				$section=$_REQUEST['section'.$i]; 
				$name=time().$i;
				$upload_img->upload_image_with_thumbnail($pic,"../slider-images/",$name,"950",'380','both');
				$name=$upload_img->get_image_name();
				
				$result=$db->query("insert into slider_images (name,title,url,description,section) values ('$name','$title','$url','$description','$section')");
				$count++;
			}	
		}
		header("location:slider-images.php?msg=$count Images Uploaded");
		exit();
}?>
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
        <form name="sliderform" action="#" method="post" enctype="multipart/form-data">
            <input type="hidden" name="add" value="pic" />
            <table>
                <?php
                    for ($i=1;$i<=$total_pics;$i++){
                ?>
                        <tr><td>Picture<?php echo $i; ?>: </td><td><input type="file" name="pic<?php echo $i; ?>" /></td></tr>
                        <tr><td>Title<?php echo $i; ?>: </td><td><input size="33" type="text" name="title<?php echo $i; ?>" /></td></tr>
                        <tr><td>URL<?php echo $i; ?>: </td><td><input size="33" type="text" name="url<?php echo $i; ?>"  value="http://"/></td></tr>
                        <tr><td>Description<?php echo $i; ?>: </td><td><textarea name="description<?php echo $i; ?>" style="width:220px;"></textarea></td></tr>
                        <tr><td>Section</td><td><select name="section<?php echo $i;?>"><option value="main">Main</option><option value="featured">Featured</option></select></tr>
                <?php	
                    }
                ?>
                <tr><td></td><td><input type="submit" value="Submit" style="width:100px;" /></td></tr>
            </table>
        </form>           
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>