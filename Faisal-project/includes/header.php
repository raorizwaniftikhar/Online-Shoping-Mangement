<div id="header">    
    <div class="header-left" >
        
    </div><!-- header-left ends here-->
    <div class="header-right" >
  <!--      <a href="#">My account</a> -->
       <!-- <a href="#">Order Status </a>-->
     <!--   <a href="#">Wish List</a>
        <a href="#">Gift</a>
        <a href="#">Certification</a>-->
        <!--<a href="#">About Us</a>
        <a href="#">Contact Us</a>
        <a href="#">Services</a>-->
        <?php if($a->get_id() <= 0) {?>
            <a href="logreg.php" >Create Account / Sign In</a>
        <?php } else{?>
        	<a href="myaccount.php">My Account<?php //echo $m->get_name_by_id($a->get_id()); ?></a>
            <a href="logout.php" >Logout</a>
        <?php }?>
       <!-- <div id="view-cart-icon">
            <a href="#"> <img src="images/cart-icon.png" width="52" height="49" border="0" /></a>
        </div> -->
       	<div style="float:left; margin-top:8px;padding:15px 0 0 0;width:300px">
        	<img src="images/logo.png"	 width="290" height="100"/>
        </div>
        <div id="view-text" >
            <div style="float:left;">
            	<a href="cart.php" style="padding-left:0px;"><img src="images/cart-icon.png" width="52" height="49" border="0" align="middle"/></a>
                <a href="cart.php" style="padding-left:0px;">View Cart</a>
            </div>
            <div style="float:right;padding-top:10px;">
                <form id="search-bar" action="products.php">
                    <input type="text" name="searchbar" size="30" />
                    <input type="submit"  value="Search"  border="0" style=" color:#FFFFFF;border-radius:10px; padding:3px 10px;letter-spacing:1px;background:#191919; border:1px solid #191919; " />
                </form>
				
        	</div>
			<div style="float:right;padding-top:15px;">
			   <a href="index.php">Home</a> &nbsp&nbsp |
			   <a href="contactus.php">Contact us</a>
			   
			</div>
            <div style="clear:both"></div>
        </div>
       
    </div><!-- header-right ends here-->
</div><!--header ends here-->