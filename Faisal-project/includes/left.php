<div class="left_section">   
    <div class="cat_Leftheading">CATEGORIES</div>
	<div class="left_cat_bg">
        <div id="treecontrol" style="margin-top:0;margin-bottom:0;">
            <table width="100%" >
            	
         	</table>
        </div>
        <ul id="gray" class="treeview-famfamfam">
			<?php 			
                $cat_result=$pro->get_category_list();
                while($cat_row = mysql_fetch_array($cat_result)){
            ?>
            <li class="cat_list_head">
                <span><a href="products.php?cat_id=<?php echo $cat_row['id']?>"><?php echo $cat_row['name']?></a></span>
                <ul>
					<?php 
                      $cat_id = $cat_row['id'];                                                      
                      $subcat_result = $pro->get_sub_cat_by_cat_id($cat_id);
                      while($subcat_row = mysql_fetch_array($subcat_result)){
                    ?>
                    <li ><span><a href="products.php?sub_cat_id=<?php echo $subcat_row['id']?>"><?php echo ucfirst($subcat_row['name'])?></a> <span style="color:#C60">(<?php echo $c->get_product_count($subcat_row['id'])?>)</span></span></li>
                    <?php								  
                      }
                    ?>
                </ul>
            </li>
			<?php
                }
            ?>	                   
        </ul>    
 	</div>
</div><?php /*?><div id="head" >Categories</div>
<ul>
	<?php
		$cat_result=$db->query("select * from product_categories");
		while($cat_row=$db->fetch_array($cat_result)){
	?>
        <li><a href="products.php?cat_id=<?php echo $cat_row['id'];?>"><?php echo $cat_row['name'];?></a></li>
	<?php 
		}
		?>
</ul>
<?php */?>


<!--<div id="head" >Popular Brands</div>
<ul >
    <li><a href="#">Apple </a></li>
    <li><a href="#">Blackberry</a></li>
    <li><a href="#">Nokia </a></li>
    <li><a href="#">Samsung</a></li>
    <li><a href="#">HP </a></li>
    <li><a href="#">LG </a></li>
    <li><a href="#">Sony Ercison </a></li>
    <li><a href="#">USB drive</a></li>
    <li><a href="#">Nokia  </a></li>
    <li><a href="#">Nokia </a></li>
</ul>
-->