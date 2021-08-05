<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	$section="Preferences";
	$a->authenticate();
	$page_title="Web Pages";
	if ($_REQUEST['command']=='del'){
		$id=$_REQUEST['id'];
		$result=$web_page->del_page($id);
		if ($result)
			$msg="Page Deleted Successfully";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>
<?php 
	$web_page->header_functions();
	$web_page->del_form();
 ?>
</head>
<body>
<div id="container">
    <div id="header"><?php include("includes/header.php"); ?></div>
    <div id="topBar"><?php include("includes/top-bar.php"); ?></div>
    <div id="menu"><?php include("includes/menu.php"); ?></div> 
    <div id="content">
    	    
        <div class="locationBar">
            <div style="float:left" class="pageHeading">&nbsp; <?php echo $page_title; ?></div>
            <div style="float:right;padding:6px"><input type="button" value="New Page" onclick="window.location='add-page.php'" /></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                        <table border="0px" cellpadding="0px" cellspacing="0px" >
                            
                            <tr>
                                <td valign="top">
                                    <table border="1" style="border-collapse:collapse" width="650px" cellpadding="3px">
                                        <tr bgcolor="#666666" style="color:#FFF"><td width="20px">&nbsp;</td><td width="150px">Name</td><td>Title</td><td align="center">Options</td>
                                        </tr>
                                        <?php
											$result=$web_page->get_pages();
											$count=1;
											while ($row=$db->fetch_assoc($result)){
										?>
                                            <tr>
                                                <td align="center"><?php echo $count++; ?></td><td><?php echo $row['name']; ?></td><td><?php echo $row['title']; ?></td><td align="center"><a href="edit-page.php?id=<?php echo $row['id']; ?>">Edit</a> | <a href="#" onclick="return del(<?php echo $row['id']; ?>)">Delete</a></td>
                                            </tr>
                                        <?php
											}
										?>
                                    </table>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>