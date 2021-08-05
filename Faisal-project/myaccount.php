<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	include("includes/classes/paging.php");
	include("includes/classes/preferences.php");
	include("includes/classes/categories.php");	
	if($a->get_id() <= 0){
		header("location: login.php");
		exit();
	}
	$where=" where 1 ";
	if ($_REQUEST['command']=='filter'){
		$where.=" and order_status='".$_REQUEST['status']."'";
	}
	$page_title=" My Orders ";
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
                    <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                        <tr>
                            <td style="padding-top:10px" valign="top">
                                <table border="0px" cellpadding="0px" cellspacing="0px" >
                                    
                                    <tr>
                                        <td valign="top">
                                            <table border="1" style="border-collapse:collapse" width="650px" cellpadding="3px">
                                                <tr bgcolor="#666666" style="color:#FFF">
                                                	<td width="20px">&nbsp;</td><td>Order Date</td><td>Status</td><td align="center">Amount</td><td align="center">Options</td>
                                                </tr>
                                                <?php
                                                    $result=$db->query("select * from orders ".$where." and order_type='bill' and member_id=".$a->get_id()." order by id desc");
                                                    $count=1;
                                                    while ($row=$db->fetch_assoc($result)){
                                                ?>
                                                    <tr>
                                                        <td align="center"><?php echo $count++; ?></td>
                                                        <td><?php echo date("m/d/Y, h:m:i",$row['order_date']); ?></td>
                                                        <td><?php echo ucfirst($row['order_status']); ?></td>
                                                        <td align="center">
                                                            <?php echo $row['amount'];?>
                                                        </td>
                                                        <td align="center">
                                                        	<a href="order-detail.php?id=<?php echo $row['id'];?>">Detail</a>
                                                            
                                                        </td>
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
            </div>
            
            <!-- centercontainer ends here-->
        </div><!-- content ends here-->
       <?php require("includes/footer.php")?>
    </div><!-- outer-wrap ends here-->
</body>
</html>