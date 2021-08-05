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
	if($a->get_id() <= 0){
		header("location: login.php");
		exit();
	}
	$query="select * from orders where id=".$id." and order_type='wish' and member_id=".$a->get_id();
	$result_order=$db->query($query);
	$order_row=$db->fetch_array($result_order);
	if(!$order_row){
		header("location: wishlist.php");
		exit();
	}
	$page_title=" Wishlist Detail";
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
        <?php /*?><div id="slider" style="min-height:300px; margin-top:10px;">
        	<?php include("includes/slider.php"); ?>
        </div><?php */?>
        <div id="content" >
            <div id="leftcontainer" >
                <?php include("includes/member-left.php");?>
            </div>
            <div id="centercontainer3" >
            	<div id="heading" style="margin-left:15px;margin-top:10px;font-size:18px;font-family:Verdana, Geneva, sans-serif;font-weight:bold"><?php echo $page_title;?></div>
                <div>
                    <div ><?php echo $msg; ?></div>
                    <form name="form1" action="" method="post">
                        <input type="hidden" name="command" value="update" />
                        <input type="hidden" name="id" value="<?php echo $id; ?>"  />
                        <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                            <tr>
                                <td style="padding-top:10px" valign="top">
                                    <table border="0px" cellpadding="0px" cellspacing="0px" >
                                        <tr>
                                            <td>
                                                <table style="margin:10px;">
                                                    <tr>
                                                        <td>Customer Name:</td><td><?php echo $m->get_name_by_id($order_row['member_id']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Save Date:</td><td><?php echo date("m/d/Y, h:m:i",$order_row['order_date']); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <table border="1" style="border-collapse:collapse" width="650px" cellpadding="3px">
                                                    <tr bgcolor="#666666" style="color:#FFF"><td width="20px">&nbsp;</td><td width="150px">Product</td><td>Qty</td><td>Rate</td><td>Price</td></tr>
                                                    <?php
                                                        $result=$db->query("select * from order_detail where order_id=".$order_row['id']);
                                                        $count=1;
                                                        $total=0;
                                                        while ($row=$db->fetch_assoc($result)){
                                                    ?>
                                                        <tr>
                                                            <td align="center"><?php echo $count++; ?></td>
                                                            <td><?php $product_row=$pro->get_product($row['product_id']); echo $product_row['title']; ?></td>
                                                            <td><?php echo $row['qty'];?></td>
                                                            <td><?php echo $row['unit_rate'];?></td>
                                                            <td><?php echo $row['qty'] * $row['unit_rate']; ?></td>
                                                        </tr>
                                                    <?php
                                                        $total += ($row['qty']*$row['unit_rate']);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" align="right"><b>Total</b></td>
                                                        <td><?php echo  $total; ?></td>
                                                    </tr>
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
                 </form>
                </div>
            </div>
            
            <!-- centercontainer ends here-->
        </div><!-- content ends here-->
       <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>