<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/auth.php");
	include("../includes/classes/members.php");
	include("includes/classes/navigation-menu.php");
	$section="Orders";
	$a->authenticate();
	$page_title="Order History";
	$where=" where 1 ";
	if($_REQUEST['cmd']=="delete"){
		$id=intval($_REQUEST['id']);
		$rr=$db->query("delete from orders where id=".$id);
		if($rr){
			$db->query("delete from order_detail where order_id=".$id);
			$msg="Order Deleted Successfully";
			header("location: orders.php?msg=".$msg);
			exit();
		}
		
	}
	if ($_REQUEST['command']=='filter'){
		$where.=" and order_status='".$_REQUEST['status']."'";
	}
?>
 <?php
 //fething categories
 
 if(isset($_GET['From'])&&isset($_GET['To']))
 {
	 $From=$_GET['From'];
	  $To=$_GET['To'];
$sql=mysql_query("select * FROM orders WHERE order_date BETWEEN '$From' And '$To'");
 }
 else
 {
	 $sql=mysql_query("select * FROM orders
LEFT JOIN order_detail
ON orders.id=order_detail.order_id
LEFT JOIN products
ON products.id=order_detail.product_id");  
 }
$count=0;

  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include("includes/common-head.php"); ?>

<script language="javascript" >
function validate(){
	document.form1.submit();
}
function del(id){
	var f=document.form1;
	if(confirm("Are You Sure You Wan't To Delete This Order")){
		f.id.value=id;
		f.cmd.value="delete";
		f.submit();
	}
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
			 
            <div style="float:right;padding:6px">
            	<form name="form1" action="" method="post" >
                	<input type="hidden" name="command" value="filter" />
                    <input type="hidden" name="id"  />
                    <input type="hidden" name="cmd" />
                    Sort By:
                    <select name="status" onchange="validate()">
                        <option value="new">New</option>
                        <option value="pending">Pending</option>
                        <option value="delivered">Delivered</option>
                        <option value="canceled">Canceled</option>
                    </select>
                    <script language="javascript">
						document.form1.status.value='<?php echo $_REQUEST[status];?>';
					</script>
				</form>
            </div>
            <div style="clear:both;font-size:1px"></div>
        </div>
		<form name="" action="orders.php" method="get">
      
      <table>
      
      <tr>
      	<td>From&nbsp;&nbsp;&nbsp;</td>
        <td><input type="date" value="" placeholder="DD-MM-YYYY" name="From"></td>
        	<td>&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;</td>
        <td><input type="date" value="" placeholder="DD-MM-YYYY" name="To">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
        
        <td><button type="submit" style="background-color:#090;width:100px;height:40px;" value="Search"><font style="color:#FFF">Search</font></button></td>
      </tr>
      </table>
      
      </form>
            <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                <tr>
                    <td style="padding-top:10px" valign="top">
                        <table border="0px" cellpadding="0px" cellspacing="0px" >
                            
                            <tr>
                                <td valign="top">
                                    <table border="1" style="border-collapse:collapse" width="650px" cellpadding="3px">
                                        <tr bgcolor="#666666" style="color:#FFF"><td width="20px">&nbsp;</td><td width="150px">Customer Name</td><td>Order Date</td><td>Status</td><td align="center">Options</td>
                                        </tr>
                                        <?php
											$result=$db->query("select * from orders ".$where." and order_type='bill' order by id desc");
											$count=1;
											while ($row=$db->fetch_assoc($result)){
										?>
                                            <tr>
                                                <td align="center"><?php echo $count++; ?></td>
                                                <td><?php echo $m->get_name_by_id($row['member_id']); ?></td>
                                                <td><?php echo date('Y.m.d',$row['order_date']); ?></td>
                                                <td><?php echo ucfirst($row['order_status']); ?></td>
                                                <td align="center">
                                                	<a href="order-detail.php?id=<?php echo $row['id'];?>">Detail</a> |
                                                	<a href="#" onclick="return del(<?php echo $row['id']; ?>)">Delete</a>
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
    <br style="clear:both" />
    <div id="footer"><?php include("includes/footer.php"); ?> </div>
</div>
</body>
</html>