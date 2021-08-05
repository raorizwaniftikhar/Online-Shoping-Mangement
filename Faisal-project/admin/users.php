<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");

	include("../includes/classes/categories.php");
	include("../includes/classes/members.php");
	include("../includes/classes/paging.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	include("../includes/classes/report.php");
	$section="Users";
	$a->authenticate();
	$page_title="Users";
	$go_back_link='no';
	
	$tab='users';
	$a->authenticate();
	$r=new Report('Users');
	$r->set_report_width(730);
	$r->add_column('id','');
	$r->add_column('username','Username ',50);
	$r->add_column('first_name','Firstname',70);
	$r->add_column('last_name','Lastname',100);
	$r->add_column('gender','Gender',43);
	$r->add_column('email','Email ',120);
	//$r->add_column('address','Address',100);
	//$r->add_column("concat(city,'/',state,'/',zip)",'City/State/Zip',90);
	//$r->add_column('phone','Phone',40);
	//$r->add_column('contact_name','Contact Name',100);
	//$r->add_column('contact_email','Contact Email',100);
	//$r->add_column('password','Password',60);
	
	$r->add_tables('members');
	$r->add_links('users.php','id','Delete','id','delete');
	$r->add_links('users-detail.php','id','Detail','id','detail');
	if($_REQUEST['command']=='delete' && $_REQUEST['id']>0){
		$m->del($_REQUEST['id']);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>
<?php
	$r->render_css();
	$r->render_javascript();
?>

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
            <div style="float:right"><a href="add-user.php">Add user</a></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                    
                    <td valign="top" style="padding-top:10px">
                        <?php
							$r->render_html();
						?>
                        </td>
                    </td>
                </tr>
            </table>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>