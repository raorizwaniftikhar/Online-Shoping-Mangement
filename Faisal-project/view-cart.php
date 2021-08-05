<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	$page_title=" Cart";
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
		<div id="content"  >
			<div id="container" >      
              <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border:1px solid #B7B7B7;">
                  <tr>
                    <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px; text-align:center;">S/No</td>
                     <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Image</td>
                    <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Product</td>
                    <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Quantity</td>
                    <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Unit Price</td>
                    <td style="font:14px Verdana; color:#FF8040; letter-spacing:1px;  text-align:center">Total</td>
                  </tr>
                  <tr>
                    <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;">1.</td>
                    <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;"><img src="iamges/shdfe.png" /></td>
                    <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;">degtery</td>
                    <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;">4</td>
                    <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;">879</td>
                    <td style="font:13px Verdana; color:#979797; letter-spacing:1px;  text-align:center;">53243</td>
                  </tr>
        	</table>
        	<button id="btn"> Add to Cart</button>
         </div><!--end of conatiner-->
	  </div><!-- content ends here-->
	  <?php require("includes/footer.php")?>
	</div><!-- outer-wrap ends here-->
</body>
</html>