<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/navigation-menu.php");
	$section="Preferences";
	$page_title="Web Pages";
	$id=$_REQUEST['id'];
	if ($_REQUEST['sbtPage']=='Submit'){
		$web_page->edit_page($_REQUEST,$id);
		header("location: pages.php");
		exit();
	}
	$go_back_link='yes';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>
<?php $web_page->header_include_textarea(); ?>
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
            <div style="float:right;padding:6px"></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                        <table border="0px" cellpadding="0px" cellspacing="0px" >
                            
                            <tr>
                                <td valign="top">
                                    <?php $web_page->render_page_html($id); ?>
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