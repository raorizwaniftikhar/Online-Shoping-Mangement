<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/preferences.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	$page_title=" Cart";
	
	if($_REQUEST['command']== "saveorder"){
		if($a->get_id() <=0){
			header("location: logreg.php"); 
			exit();
		}
		if($cart->get_order_total() <= 0){
			$cart->msg="Please Select At Least One Product";
		}
		else{
			$sub_total = 0;
			$data =$_SESSION['carts'];
			$i=1;
			$arr=array();
			$arr['member_id'] = $a->get_id();
			$arr['amount']= $cart->get_order_total();
			$arr['order_date']= date('Y.m.d');
			$arr['order_status']="new";
			if($_REQUEST['opt']=='wish'){
				$arr['order_type']='wish';
			}
			else{
				$arr['order_type']='bill';
			}
			$saved=$db->insert($arr,"orders");
			if($saved){
				$orderid=$db->get_insert_id();
				foreach($data as $product){
	
				  //$chunks = explode('|',$product);
				  $product_id = $product["productid"];
				  $product_qty = $product["qty"];
				  $product_array=$pro->get_product($product_id);
				  $product_amount = $product_array['price'];
				  $d= array();
				  $d['order_id']=$orderid;
				  $d['product_id']=$product_id;
				  $d['qty']=$product_qty;
				  $d['unit_rate']=$product_amount;
				  $db->insert($d,"order_detail");
				}
				if($_REQUEST['opt']=='wish'){
					//$cart->msg="Successfully Added In Your Wish List";
					header("location:paypal.php?item='$product_id'&amount='$product_amount'");
					
					
				}
				else
					//$cart->msg="We Have Received Your Order, We Will contact you soon. Thanx for Visit Us";
			header("location:paypal.php?item=$product_id&amount=$product_amount&qty=".$d['qty']);
			}
			 // echo "Product Id: ".$product_id." Quantity: ".$product_qty."<br>";
		}
	}
	
	$msg=$cart->msg;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require("includes/common-header.php")?>
 <?php $cart->render_js(); ?>
 <script language="javascript">
 	function validate(){
		if(confirm("Are You Sure You Want To Check Out")){
			document.form1.command.value='saveorder';
			return true;
		}
		else
			return false;
	}
 </script>
</head>
<body style=" background:url(images/My-white-wood-FF16.jpg);">
	<div id="outer-wrapper" >
		<?php require("includes/header.php")?>
		<?php require("includes/navi.php")?>
		<div id="content"  >
			<div id="container" >
            	 <h1>Outlet Cart</h1>      
                <form name="form1" method="post" action="" onsubmit="return validate()"> 
                    <input type="hidden" name="vid" />
                     <input type="hidden" name="productid" />
                    <input type="hidden" name="command" />
                    <div style="font-family:Verdana, Geneva, sans-serif;font-size:16px;color:#F00;"><?php echo $msg;?></div>
                      <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border:1px solid #B7B7B7;">
                          <tr>
                            <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px; text-align:center;">S/No</td>
                             <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Image</td>
                            <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Product</td>
                            <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Quantity</td>
                            <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Unit Price</td>
                            <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Total</td>
                            <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Options</td>
                          </tr>
                        <?php  if(count($_SESSION['carts']) > 0) {
                        
                            $sub_total = 0;
							$data =$_SESSION['carts'];
							$i=1;
                            foreach($data as $product){

							  //$chunks = explode('|',$product);
                              $product_id = $product["productid"];
                              $product_qty = $product["qty"];
							  $product_array=$pro->get_product($product_id);// $db->get_row("gm_products","prod_id",$product_id);
							  //addtocart($product_id,$product_qty);
                              $product_name = $product_array['title'];
                              $product_amount = $product_array['price']*$product_qty;
                              // calculate the subtotal
                              $sub_total = $sub_total + $product_amount;
                             // echo "Product Id: ".$product_id." Quantity: ".$product_qty."<br>";
                        ?>
                                           <tr>
                                             <td>&nbsp;&nbsp;<? echo $product_name; ?></td>
                                             <td width='80px' nowrap="nowrap">
											 
                                                 <input type="text" name="product<?php echo $product_id?>" value="<?php echo $product_qty; ?>" size="3"/>
                                				 <input type="button" value="Update" class="edit" onclick="javascript:update_cart()"/>
                                             </td>
                                             <td width='130px'><? echo $product_amount; ?></td>
                                           </tr>
                          
                          	<tr>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;"><?php echo $i;?>.</td>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;"><a href="product-detail.php?id=<?php echo $product_id;?>"><img src="product-pics/<?php echo $pro->get_display_image($product_id);?>" height="100" border="0"/></a></td>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;" nowrap="nowrap"><?php echo $product_array['title'];?></td>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;">
									
                                    <input type="text" name="product<?php echo $product_id?>" value="<?php echo $product_qty; ?>" size="3"/>
									<input type="image" src="images/edit.png"  value="Update" class="edit" onclick="javascript:update_cart()" align="absbottom"/>
                                </td>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;"><?php echo $product_array['price'];?></td>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;"><?php echo $product_amount; ?></td>
                                <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;"> <a href="javascript:del(<?php echo $product_id?>)" class="delete" ><img src="images/delete.gif" border="0"/></a></td>
                              </tr>
                        <?php
								$i++;
                            }
						}
                        ?>
                        <tr>
                        	<td colspan="5" align="right">Total AMount</td>
                            <td colspan="2"><b><?php echo $sub_total; ?></b></td>
                        </tr>
                        <tr>
                        	<td colspan="3" align="left"><input type="button" value="Continue Shopping - >>" id="btn"  onclick="window.location='index.php';"/></td>
                            <td colspan="3" align="right"><input type="button" value="Add To Wishlist" id="btn"  onclick="window.location='cart.php?command=saveorder&opt=wish';"/></td>
                            <td colspan="3" align="right"><input type="submit" value="Check Out" id="btn"  /></td>
                        </tr>
                    </table>
               </form>
         </div><!--end of conatiner-->
	  </div><!-- content ends here-->
	  <?php require("includes/footer.php")?>
	</div><!-- outer-wrap ends here-->
</body>
</html>