<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/auth.php");
	include("../includes/classes/members.php");
	include("../includes/classes/products.php");	
	include("includes/classes/navigation-menu.php");
	$section="Orders";
	$a->authenticate();
	$page_title="Order Detail";
	
	$id=intval($_REQUEST['id']);
	if ($_REQUEST['command']=='update'){
		$id=intval($_REQUEST['id']);
		$status=$_REQUEST['status'];
		$result_update=$db->query("update orders set order_status='".$status."' where id=".$id);
		$order_rows=$db->fetch_array_by_query("select * from orders where id=".$id);
		$m_rows=$m->get_row($order_rows['member_id']);
		$email_member=$m_rows['email'];

		$header="From: $from_name <no-reply>\r\n";
		$header.="Content-type:text/html";
		//$ok=mail($email_member,"Your Order Status on Outlet","You order Status Has been updated, Now Your Order Status is '".$status."' you can login to to check your order detail");
		if($result_update && $ok){
			$msg="Update Status Successfully";
		}
		else{
			$msg="Error While Updating";
		}
	}
	$query="select * from orders where id=".$id." and order_type='bill'";
	$result_order=$db->query($query);
	$order_row=$db->fetch_array($result_order);
	if(!$order_row){
		header("location: orders.php");
		exit();
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
 <script language="javascript">
function print_doc(){
	window.print();
}
function printPageContent() {
    var DocumentContainer=document.getElementById("printarea");
    var WindowObject = window.open('', "PrintWindow", "width=750,height=550,top=200,left=200,toolbars=no,scrollbars=yes,status=no,resizable=false");
    WindowObject.document.writeln(DocumentContainer.innerHTML);
    //WindowObject.document.close();
    WindowObject.focus();
    //WindowObject.showModalDialog();// .print();
	WindowObject.print();
    WindowObject.close();

}
</script>
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
            <div style="float:right;padding:6px"><input type="button" value="Print" onclick="printPageContent()"/></div>
            <div style="clear:both;font-size:1px"></div>
        </div>
         <div id="printarea" style="width:750px;">
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
                                              <td>Phone:</td><td><?php $row=$db->get_row("members","id",$order_row['member_id']); echo $row['phone'];?></td>
                                        </tr>
                                        <tr>
                                        	<td>Address: </td><td><?php echo $row['address'];?></td>
                                            
                                        </tr>
                                        <tr>
                                            <td>Order Date:</td><td><?php echo date("Y.m.d",$order_row['order_date']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td><td><?php echo ucfirst($order_row['order_status']); ?></td>
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
                            <tr>
                            	<td>
                                	<table>
                                    	<tr>
                                        	<td>Status:</td>
                                            <td>
                                            	<select name="status">
                                                	<option value="new">New</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="canceled">Canceled</option>
                                                </select>
                                                <script language="javascript">
													document.form1.status.value='<?php echo $order_row["order_status"];?>';
												</script>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" align="right"><input type="submit" value="Update Status" /></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
         </form>
       </div>
    </div>
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>