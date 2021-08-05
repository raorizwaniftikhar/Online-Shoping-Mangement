<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	include("includes/classes/paging.php");
	include("includes/classes/categories.php");	

	$id=intval($_REQUEST['id']);
	$page_row=$web_page->get_page_by_id($id);
	if(!$page_row){
		header("location: index.php");
		exit();
	}
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
        <div id="content" >
            <div style="padding:10px;">
            	<h1><?php echo $page_row['title'];?></h1>
                <div style="font-family:Verdana, Geneva, sans-serif;font-size:14px;color:#FFF;margin-top:10px;"><?php echo $page_row['description'];?></div>
                <div style="font-family:Verdana, Geneva, sans-serif;font-size:14px;margin-top:10px;"><?php echo $page_row['text'];?></div>
            </div>
        </div><!-- content ends here-->
       <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>