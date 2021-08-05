<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	
	$page_title=" Product Detail";
	$id=intval($_REQUEST['id']);
	$query="select * from products where id=".$id;
	$p_row=$db->fetch_array_by_query($query);
	if(!$p_row){
		header("location: index.php");
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require("includes/common-header.php")?>
     <?php $cart->render_js(); ?>
	<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
	<script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });
    </script>
    <style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#gallery {
		padding-left: 5px;
		margin:0px;
	}
	#gallery ul { list-style: none; }
	#gallery ul li { display: inline; }
	#gallery ul img {
		border: 5px solid #FFF;
	}
	#gallery ul a:hover img {
		border: 5px solid #3e3e3e;
		color: #fff;
	}
	#gallery ul a:hover { color: #fff; }
	</style>
    
</head>
<body style=" background:url(images/My-white-wood-FF16.jpg);">
	<div id="outer-wrapper" >
		<?php require("includes/header.php")?>
		<?php require("includes/navi.php")?>
		<div id="content" style="height:300px;" >
            <div id="container" >
            	<form name="form1" method="post">
                    <input type="hidden" name="vid" />
                     <input type="hidden" name="productid" />
                    <input type="hidden" name="command" />
                    <div id="leftcontainer">
                        <img src="product-pics/<?php echo $pro->get_display_image($p_row['id']);?>" width="170px" height="200px" />
                        <div id="gallery" style="margin:0px;padding:0px;">
                            <ul>
                            	<?php
									$row=$db->fetch_array_by_query("select * from products where id=$id");
									$rows= array();
									for ($i=1;$i<=9;$i++){
										if ($row['pic'.$i]!='')
											$rows[]=$row['pic'.$i];
									}
									foreach($rows as $pic){
								?>
                                <li>
                                    <a href="product-pics/thumb1-<?php echo $pic;?>" title="">
                                        <img src="product-pics/thumb1-<?php echo $pic;?>" width="32" height="32" alt="" />
                                    </a>
                                </li>
                                <?php
									}
								?>
                            </ul>
                        </div>
                    </div>        
                    <div id="centercontainer2" >
                        <h>Product Details</h>
                        <ul >
                            <li style="list-style:none;"><strong>Name:</strong><span style="margin-left:20px;color:#F90"><?php echo $p_row['title'];?></span></li>
                            <li style="list-style:none;"><strong>Price:</strong><span style="margin-left:20px;color:#F00"><b>Rs. <?php echo $p_row['price'];?></b></span></li>
                            <li style="list-style:none;"><strong>Description:</strong><span style="margin-left:20px;"><?php echo $p_row['description'];?></span></li>
                        </ul>
                                                <div align="right"><input type="button" id="btn" class="addToCart" onclick="addtocart(<?php echo $p_row['id']; ?>)" value="Add to Cart" /></div>
                        <div>
								<strong>Detail:</strong><?php echo stripslashes($p_row['detail']);?>
                        </div>
                    </div>
                 </form>
        	</div>
		</div><!-- content ends here-->
		<?php require("includes/footer.php")?>
	</div><!-- outer-wrap ends here-->
</body>
</html>