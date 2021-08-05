<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	
	$section="Preferences";
	$a->authenticate();
	$page_title="Slider Images";
	if ($_REQUEST['command']=='del'){
		$id=$_REQUEST['id'];
		$picname=$_REQUEST['name'];
		if($picname!="" && file_exists("../slider-images/".$picname)){
			unlink("../slider-images/".$picname);
		}
		$query=$db->query("delete from slider_images where id=$id");
		$msg="Image delete seccfully";
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
        <div class="content_container">
            <div class="headings alt">
                <h2>Image Listings</h2>
            </div>
            <div class="content_box">                     
               <div style="float:right;"><input type="button" value="New Image" onclick="window.location='upload-slider-images.php'" /></div>
                    <div style="clear:both;font-size:1px"></div>                
                <table class="img">
					<?php
                        $cols=3;
                        $result=$db->query("select * from slider_images");
                        $count=0;
                        while (1){
                            echo "<tr>";
                            for ($i=0;$i<$cols;$i++){
                                $row=$db->fetch_assoc($result);
                                if ($row){
                                    $count++;
                    ?>
                                    <td>
                                        <table width="250">
                                            <tr><td align="center"><img src="../slider-images/<?php echo $row[name]; ?>" width="200" height="150" style="border:2px solid #999; padding:2px;" /></td></tr>
                                            <tr><td align="center"><?php echo $row[title]; ?></td></tr>
                                            <tr>
                                                <td align="center">
                                                    <a href="edit-slider-image.php?id=<?php echo $row[id]; ?>">Edit</a>&nbsp;|&nbsp;
                                                    <a href="#" onclick="return del(<?php echo $row[id]; ?>,'<?php echo $row['name']?>')">Delete</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                    <?php	
                                }	
                            }
                            echo "</tr>";
                            if (!$row)
                                break;
                        }
                        if ($count==0){
                    ?>
                            <tr><td><b>No Image Uploaded</b></td></tr>
                    <?php
                        }
                    ?>
                </table>            
            </div>
		</div>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>