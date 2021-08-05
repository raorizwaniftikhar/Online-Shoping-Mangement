<?php
class Cart{
	private $db;
	private $pg;
	private $start;
	private $results_per_page;
	private $where;
	function __construct($db){
		$this->db=$db;
	}
	
	function get_price($vid){
		$result=$this->db->query("select price from product_variant where id=$vid");
		$row=$this->db->fetch_array($result);
		return $row['price'];
	}
	function get_total_free_offer_items_by_q($q,$offer_on_qty){
		if($offer_on_qty<=$q){
			if(($q%$offer_on_qty)==0){
				$free_qty=$q/$offer_on_qty;	
				return $free_qty;
			}else{
				$free_qty=floor($q/$offer_on_qty);
				return $free_qty;	
			}			
		}
	}	
	function get_dicount_price($vid){
		$result=$this->db->query("select discount_price from product_variant where id=$vid");
		$row=$this->db->fetch_array($result);
		return $row['discount_price'];
	}
	function remove_variant($vid){
		$vid=intval($vid);
		$max=count($_SESSION['carts']);
		for($i=0;$i<$max;$i++){
			if($vid==$_SESSION['carts'][$i]['productid']){
				unset($_SESSION['carts'][$i]);
				break;
			}
		}
		$_SESSION['carts']=array_values($_SESSION['carts']);
		header("location: cart.php?msg=Product has been Removed");
		exit();
	}	
	//////////////////////////////////////////////////////
	function get_product($id){
		$result=$this->db->query("select * from products where id=$id");
		return $row=$this->db->fetch_array($result);
	}
	function get_sub_cat_total($sub_cat){
		$result=$this->db->query("select count(*) as total from products where sub_cat_id='$sub_cat' ");
		$sub_cat_row=$this->db->fetch_array($result);
		return $sub_cat_row['total'];
	}
	function get_subname($subid){
		$result=$this->db->query("select * from product_subcategories where id=$subid");
		$row=$this->db->fetch_array($result);
		return $row['name'];
	}	
	function get_order_total(){
		$max=count($_SESSION['carts']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$vid=$_SESSION['carts'][$i]['productid'];
			$q=$_SESSION['carts'][$i]['qty'];

			$product_id=$vid;
			$check_offer=$this->db->query("select * from products where id=$product_id");
			$row_offer=$this->db->fetch_array($check_offer);
			$price=$row_offer['price'];
			$sum+=$price*$q;
		}
		return $sum;
	}		
	function addtocart($vid,$q){
		if($vid<1 or $q<1) return ;
		
		if(is_array($_SESSION['carts'])){
			if($this->product_exists($vid)) return false;
			$max=count($_SESSION['carts']);
			$_SESSION['carts'][$max]['productid']=$vid;
			$_SESSION['carts'][$max]['qty']=$q;
		}
		else{
			$_SESSION['carts']=array();
			$_SESSION['carts'][0]['productid']=$vid;
			$_SESSION['carts'][0]['qty']=$q;
		}
		return true;
	}
	function product_exists($vid){
		$vid=intval($vid);
		$max=count($_SESSION['carts']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($vid==$_SESSION['carts'][$i]['productid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}
	function has_items(){
		$max=count($_SESSION['carts']);
		return $max;
	}
	function clear_cart(){
		unset($_SESSION['carts']);
	}	
	function render_js(){
?>
<script language="javascript">
	function addtocart(vid){			
		document.form1.productid.value=vid;
		document.form1.command.value='add';
		document.form1.submit();
	}
	function del(vid){		
		if(confirm('Do you really mean to delete this item')){
			document.form1.vid.value=vid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your shopping cart, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){				
		document.form1.command.value='update';
		document.form1.submit();
	}
	function select_category(sub_cat_id){
		var f=document.frmProducts;
		f.sub_cat_id.value=sub_cat_id;
		f.command.value="change_category";
		f.submit();
	}
</script>
<?php
	}
	function render_cart(){		
?>
<form name="form1" method="post">
<input type="hidden" name="vid" />
<input type="hidden" name="command" />
  <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
          <td width="37px" class="addcart_head">Sr</td>
          <td width="496px" style="text-align:left !important; padding-left:10px;" class="addcart_head">Item Description</td>
          <td width="150px" class="addcart_head">Quantity</td>
          <td width="112px" class="addcart_head">Unit Price</td>
          <td width="158px" class="addcart_head">Total Price</td>
      </tr>
      <?php 	  	  
		  $max=count($_SESSION['carts']);
		  $total_saving=0;
		  for($i=0;$i<$max;$i++){
			  $vid=$_SESSION['carts'][$i]['variantid'];
			  $q=$_SESSION['carts'][$i]['qty'];
			  $vname=$this->get_variant_name($vid);
			  if($q==0) continue;
	  ?>
      <tr>
          <td class="addcart_list sno"><?php echo $i+1?></td>
          <td class="addcart_list"  style="text-align:left !important; padding-left:5px;">
              <div class="addcart_detail">
                  <div class="addcart_pic"><a href="product-detail.php?vid=<?php echo $vid?>"><img src="product-pics/thumb1-<?php echo $this->get_variant_image($vid);?>" style="max-width:45px; max-height:51px;" border="0" /></a></div>
                  <div class="add_cart_text">
                      <div class="addcart_pro_head"><a href="product-detail.php?vid=<?php echo $vid?>"><?php echo $vname?></a></div>
                      <div class="addcart_pro_text"><?php echo $this->get_variant_description($vid)?></div>
                      <div class="addcart_pro_text" style="float:right; margin-right:3px;">
					  	<?php 
						  $product_id=$this->get_product_id_from_vid($vid);
						  echo $this->get_product_offer($product_id,$q)
						?>
                      </div>
                      <div class="clear"></div>
                  </div>
                  <div class="clear"></div>
              </div>
          </td>
          <td class="addcart_list">
              <div><input type="text" class="addchar_item" name="variant<?php echo $vid?>" value="<?php echo $q?>"/></div>
              <div class="add_item_link"><a href="javascript:update_cart()">Update</a></div>
          </td>
          <td class="addcart_list" valign="top" style="padding:13px 0 0 10px">
              <table width="100%" class="price">
                  <td>$</td>
                  <td>
				  	<?php 
						$check_offer=$this->db->query("select * from products where id=$product_id");
						$row_offer=$this->db->fetch_array($check_offer);
						if($row_offer['offer']=='yes' && $row_offer['offer_on_qty']<=$q && $row_offer['offer_type']=='off'){
							echo '<span style="color:#c00">'.$this->get_dicount_price($vid).'</span>';
						}else{								
							echo $this->get_price($vid);
						}
					?>
                  </td>
              </table>
          </td>
          <td class="addcart_list" valign="middle" style="padding:3px 0 0 10px; border-right:0 !important">
              <table width="100%" class="total_price">
                  <tr>
                      <td>$</td>
                      <td align="left" style="padding:0 0 0 20px;">
					  	<?php 							
							if($row_offer['offer']=='yes' && $row_offer['offer_on_qty']<=$q && $row_offer['offer_type']=='off'){
								$discount_price=$this->get_dicount_price($vid);
								$saving=($this->get_price($vid)-$discount_price)*$q;
								echo '<span style="color:#c00">'.$discount_price*$q.'</span>';
							}else if($row_offer['offer']=='yes' && $row_offer['offer_on_qty']<=$q && $row_offer['offer_type']=='free'){								
								$free_qty=$this->get_total_free_offer_items_by_q($q,$row_offer['offer_on_qty']);
								$saving=$this->get_price($vid)*$free_qty;
								echo '<span style="color:#c00">'.$this->get_price($vid)*$q.'</span>';
							}else{
								$saving=0;								
								echo $this->get_price($vid)*$q;
							}
						?>
                      </td>
                  </tr>
                  <tr>
                  	<td colspan="2" class="delete_item" style="padding-top:8px">
                    	<a href="javascript:del(<?php echo $vid?>)">delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if($saving!=0){?>
                    	<span style="color:green;font-size:11px;">Saving:<b>$<?php echo $saving?></b></span>
                        <?php }?>
                    </td>                    
                  </tr>
              </table>
          </td>
      </tr> 
      <?php
	  		$total_saving=$total_saving+$saving;					
		  }
	  ?>                                                              
      <tr>
      	  <?php if($total_saving==0){?>
          <td colspan="5" class="addcart_totalprice">Order Total:&nbsp;&nbsp;<span style="font-size:18px;color:#c00;">$ <?php echo number_format($this->get_order_total(),2)?></span></td>
          <?php }else{?>
          <td colspan="3" class="addcart_totalprice" align="right" style="color:green;">Total Saving:&nbsp;&nbsp;<span style="font-size:18px;color:#c00;">$ <?php echo $total_saving?></span></td>
          <td colspan="2" class="addcart_totalprice" align="right">Order Total:&nbsp;&nbsp;<span style="font-size:18px;color:#c00;">$ <?php echo number_format($this->get_order_total(),2)?></span></td>
          <?php }?>
      </tr>
  </table>		
</form>
<?php
	}
	function show_products($pg,$start,$results_per_page,$where,$sub_cat_id){		
		$this->pg=$pg;
		$this->start=$start;
		$this->results_per_page=$results_per_page;
		$this->where=$where;
?>   
    <form name="form1">
        <input type="hidden" name="productid" />
        <input type="hidden" name="command" />
    </form>	    
    <table width="100%">
    	<tr>	
        	<td width="10%"></td>
            <td><h1 align="center" style="margin:0 0 13px 0;padding:0px;">Our Products</h1></td>
    		<td align="right" width="10%" valign="middle">
            	<a href="shoppingcart.php" style="text-decoration:none">
                	<img src="images/show_cart.png" border="0"/><span style="font-size:10px; color:#C60; font-weight:bold"><?php echo '('.count($_SESSION['carts']).')';?></span>
               	</a>
            </td>
        </tr>
    </table>
	<table border="0" cellpadding="2px" width="718px">    	
    	<tr>
        	<td colspan="2" style="border-bottom:1px solid #000 dashed;">            	
                <div class="pagingBar">
                    <div style="float:left">
                        <span style="font-size:12px">Products:</span>
                        <span style=" font-size:18px; font-weight:bold;"><?php echo $this->pg->get_total_records()?></span>
                    </div>
                    <div style="float:right">
                    <?php $this->pg->render_pages() ?>
                    </div>
                    <br style="clear:both" />
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<div class="bar2">
                	<table width="100%" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td>Category</td>
                            <td align="right" style="padding-right:3px;">
                            	<form name="frmProducts">                                    
                                	<input type="hidden" name="command" value="" />
                                    <input type="hidden" name="sub_cat_id" value="" />
                                </form>
                                    <select name="sub_cat_id" class="option_field" onchange="select_category(this.value)">
                                    	<option value="0">-ALL-</option>
										<?php  
                                        $cat_result =$this->db->query("select * from product_categories");
                                        while($c_row = mysql_fetch_array($cat_result)){?>
                                        <optgroup label="<?php echo $c_row['name']?>">
                                             <?php		  
                                              $cat_id = $c_row['id'];                                                      
                                              $c_result = $this->db->query("select * from product_subcategories where categoryid='$cat_id'");
                                                while($c_row = mysql_fetch_array($c_result)){
													if($sub_cat_id==$c_row['id']){
                                             ?>	
                                             			<option value="<?php echo $c_row['id']?>" selected="selected">
                                             <?php }else{?>
`			                                            <option value="<?php echo $c_row['id']?>">
											 <?php }?>
                                                <?php  	if($this->get_sub_cat_total($c_row['id'])!=0)
															echo $c_row['name'].' ...('.$this->get_sub_cat_total($c_row['id']).')'; 
													    else
															echo $c_row['name'];
												?>
                                              </option>
                                            <?php
                                                }
                                            ?>
                                        </optgroup>
                                         <?php										
                                         }
                                         ?>
                                    </select>                                                           
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<table cellpadding="0" cellspacing="3" border="0" width="717px" class="shop_items">
                    <tr>
					<?php
						$count=1;						
                        $result=$this->db->query("select * from products $this->where limit $this->start,$this->results_per_page");
                        while($row=$this->db->fetch_array($result)){
								if($row['pic1']==''){
								$pic="product-pics/thumb1-no-image.gif";
								}
							else{
								$pic="product-pics/thumb1-".$row['pic1'];
								if(!file_exists($pic)){
									$pic="product-pics/thumb1-no-image.gif";
								}
							}
						
                    ?>
    						<td width="231px" valign="top">
                            	<div class="item_heading2"><?php echo $this->get_subname($row['sub_cat_id'])?></div>
                                <div align="center" class="item_img" valign="middle">
                                	<a href="product-details.php?id=<?php echo $row['id']?>">
                                    	<img src="<?php echo $pic?>" border="0"/>
                                    </a>
                                </div>
                                <div class="item_heading1"><a href="product-details.php?id=<?php echo $row['id']?>"><?php echo substr($row['name'], 0, 30).'...'?></a></div>
                              	<div class="item_detail"><?php echo stripcslashes($row['short_description']);?></div>
                                <div class="price" align="center">Price: <b>$<?php echo $row['price']?></b></div>
                                <div align="center" class="buy_btn"><input type="image" src="images/buynow.jpg" onclick="addtocart(<?php echo $row['id']?>)" /></div>
                            </td><?php 
							if($count%3==0){
								echo '</tr><tr>';
							}
							$count++;
						}
						if($count==1){
							echo '<td align="center" style="color:green;">No Records Found in Database</td>';
						}
						?>
                    </tr>                       
                 </table>
             </td>
         </tr>
     </table>	
<?php
	}
		function show_search_products2($pg,$start,$results_per_page,$where){		
		$this->pg=$pg;
		$this->start=$start;
		$this->results_per_page=$results_per_page;
		$this->where=$where;
?>   
   
    <table width="100%">
    	<tr>	
        	<td width="10%"></td>
    		<td align="right" width="10%" valign="middle">
            	<a href="shoppingcart.php" style="text-decoration:none">
                	<img src="images/show_cart.png" border="0"/><span style="font-size:10px; color:#C60; font-weight:bold"><?php echo '('.count($_SESSION['carts']).')';?></span>
               	</a>
            </td>
        </tr>
    </table>
	<table border="0" cellpadding="2px" width="100%">    	
    	<tr>
        	<td colspan="2" style="border-bottom:1px solid #C3C">            	
                <div class="pagingBar">
                    <div style="float:left">
                        <span style="font-size:12px">Products:</span>
                        <span style="color:#C3C; font-size:18px; font-weight:bold;"><?php echo $this->pg->get_total_records()?></span>
                    </div>
                    <div style="float:right">
                    <?php $this->pg->render_pages() ?>
                    </div>
                    <br style="clear:both" />
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<div class="bar2">
                <form name="frmProducts">                                    
                    <input type="hidden" name="command" value="" />
                    <input type="hidden" name="sub_cat_id" value="" />
                </form>

                	<table border="0" width="100%" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td>Search Results</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<table cellpadding="0" cellspacing="3" border="0"  width="100%" class="shop_items">
                    <tr>
					<?php
						$count=1;						
                        $result=$this->db->query("select * from products $this->where limit $this->start,$this->results_per_page");
                        while($row=$this->db->fetch_array($result)){
									if($row['pic1']==''){
								$pic="product-pics/thumb1-no-image.gif";
								}
							else{
								$pic="product-pics/thumb1-".$row['pic1'];
								if(!file_exists($pic)){
									$pic="product-pics/thumb1-no-image.gif";
								}
							}
                    ?>
    						<td width="231px" valign="top">
                            	<div class="item_heading2"><?php echo $this->get_subname($row['sub_cat_id'])?></div>
                                <div align="center" class="item_img" valign="middle">
                                	<a href="product-details.php?id=<?php echo $row['id']?>">
                                    	<img src="<?php echo $pic?>" border="0"/>
                                    </a>
                                </div>
                                <div class="item_heading1"><a href="product-details.php?id=<?php echo $row['id']?>"><?php echo substr($row['name'], 0, 30).'...'?></a></div>
								<div class="item_detail"><?php echo stripcslashes($row['short_description']);?></div>
                                <div class="price" align="center">Price: <b>$<?php echo $row['price']?></b></div>
                                <div align="center" class="buy_btn"><input type="image" src="images/buynow.jpg" onclick="addtocart(<?php echo $row['id']?>)" /></div>
                            </td><?php 
							if($count%4==0){
								echo '</tr><tr>';
							}
							$count++;
						}
						if($count==1){
							echo '<td align="center" style="color:green;">No Records Found in Database</td>';
						}
						?>
                    </tr>                       
                 </table>
             </td>
         </tr>
     </table>	
<?php
	}
}
	$cart=new Cart($db);	
	if($_REQUEST['command']=='add' && $_REQUEST['productid']>0){		
		$vid=$_REQUEST['productid'];		
		$ok=$cart->addtocart($vid,1);
		if(!$ok){
			$msg="Product was already added to your shoping cart";
		}
		else
			$msg="Product was added to Shopping Cart";
		header("location:cart.php?msg=".$msg);
		exit();
	}
	else if($_REQUEST['command']=='delete' && $_REQUEST['vid']>0){
		$cart->remove_variant($_REQUEST['vid']);
	}
	else if($_REQUEST['command']=='clear'){
		$cart->clear_cart();
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['carts']);
		for($i=0;$i<$max;$i++){
			$vid=$_SESSION['carts'][$i]['productid'];
			$q=intval($_REQUEST['product'.$vid]);
			if($q>0 && $q<=999){
				$_SESSION['carts'][$i]['qty']=$q;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
			}
		}
		$msg="Product Updated Successfully";
		
		header("location: cart.php?msg=".$msg);
		exit();
	}	
?>