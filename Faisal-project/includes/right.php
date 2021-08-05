<div id="head2" >Customer Support</div>
	<div align="center"><img src="images/help.png" /></div>	
<ul >
    <li><a href="#"><span style="color:#F00"><?php echo $p->get_value("customersupport");?></span></a></li>
</ul>
<hr style="color:#F00"/>
<div id="head2" >Featured Products</div>
    <ul>
    	<?php
		    $query="select * from products where locked='no' ";			
			$query.=" and featured='featured' order by rand() limit 0,4";	
			$res_pr=$db->query($query);
			while($f_row=$db->fetch_array($res_pr)){
		?>
		<li>
        	<table width="100%">
            	<tr>
                	<td>
                    	   <img src="product-pics/<?php echo $pro->get_display_image($f_row['id']);?>" width="50" height="50"/><br />
                    </td>
                    <td>
                    	<?php echo substr($f_row['title'],0,15);?><br /> 
           				 Rs <?php echo $f_row['price'];?><br />
                         <a href="product-detail.php?id=<?php echo $f_row['id'];?>"><strong>Detail</strong></a>
                    </td>
                </tr>
            </table>
         
        </li>
        <?php } ?>
    </ul>
</div><!-- rightcontainer ends here-->