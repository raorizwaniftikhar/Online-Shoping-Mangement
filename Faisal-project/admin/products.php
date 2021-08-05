<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/preferences.php");
	include("../includes/classes/categories.php");
	include("../includes/classes/paging.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	include("../includes/functions.php");
	include("../includes/classes/products.php");
	$section="Products";
	$a->authenticate();
	$page_title="Products";
	$go_back_link='no';
	if($_REQUEST['command']=='featured' && $_REQUEST['id']>0){
		$id=intval($_REQUEST['id']);
		$db->query("update products set featured='featured' where id=".$id);
		header("location:products.php");
		exit();
	}else if($_REQUEST['command']=='normal' && $_REQUEST['id']>0){
		$id=intval($_REQUEST['id']);
		$db->query("update products set featured='normal' where id=".$id);
		header("location:products.php");
		exit();
	}
	else if($_REQUEST['command']=='delete' && $_REQUEST['id']>0){
		$id=$_REQUEST['id'];
		$pro->delete_product($_REQUEST['id']);
		$msg="Product Has Been Deleted";
		//header("location:products.php?msg=".$msg);
		//exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>

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
            <div style="float:right"><a href="add-product.php">Add Products</a></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                    
                    <form name="frmAdd" onsubmit="return validate()" method="post" >
                        <input type="hidden" name="command" />
                        <input type="hidden" name="category" />
                        <input type="hidden" name="id" />
						<?php
							
							$query="select * from products where locked='no'";
							$results_per_page=10;
							$page=intval($_REQUEST['page']);
							if($page<1) $page=1;

							$pg=new Paging($db,$query,$page,$results_per_page);
							$start=$pg->get_start();							
						?>

				<table width="723">
					<div class="pagingBar">
                    	<div style="float:left">
                        	Total Records <?php echo $pg->get_total_records() ?>
                        </div>
                        <div style="float:right">
						<?php $pg->render_pages() ?>
                        </div>
                        <br style="clear:both" />
                    </div>
						<?php
                            $result=$db->query("select * from products where locked='no' order by id desc limit $start,$results_per_page");
                            while($row=$db->fetch_array($result)){
								
                        ?>

                        <tr valign="top">
                            <td width="83"><img src="../product-pics/thumb1-<?php echo $pro->get_display_image($row['id']);; ?>" width="160px" /></td>
                            <td width="390" style="padding-right:20px">
                                <div><b><?php echo $row['title']?></b></div>
                                <div style="color:#999; width:300px;"><?php echo substr($row['description'],0,250).' ...'; ?></div>
                                <?php if ($row) { ?>price:<span style="color:#093; font-weight:bold"> <?php echo $row['price']?></span><?php } ?>
                            </td>
                            <td width="5" style="border-left:dashed 1px #CCC">&nbsp;</td>
                            <td width="225" align="left">
                                <ul>
                                    <li><a href="edit-product.php?pid=<?php echo $row['id'] ?>&return=products&page=<?php echo $page; ?>">Edit</a></li>
                                     <?php if($row['featured']=='normal'){?>
                                    <li><a href="?command=featured&id=<?php echo $row['id'] ?>" >Featured</a></li>
                                     <?php }else if($row['featured']=='featured'){?>
                                    <li><a href="?command=normal&id=<?php echo $row['id'] ?>" >Normal</a></li>
                                    <?php }?>
                                    <li><a href="?command=delete&id=<?php echo $row['id'] ?>" onclick="return confirm('Do you want to Delete?')">Delete</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr><td colspan="4"><hr size="1" /></td></tr>
                        <?php
                            }
                        ?>
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