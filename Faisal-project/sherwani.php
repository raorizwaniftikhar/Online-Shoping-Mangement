<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/preferences.php");
	include("includes/classes/auth.php");
	include("includes/classes/web-pages.php");
	include("includes/classes/cart.php");
	include("includes/classes/products.php");
	include("includes/classes/members.php");
	include("includes/classes/paging.php");
	include("includes/classes/categories.php");	
	if($_REQUEST['command']=='login'){
		extract($_REQUEST);
		$result=$db->query("select * from members where (username='$username' or email='$username') and password='$password'");
		if ($db->count_rows($result)>0){
			$row=$db->fetch_assoc($result);
			if ($row['locked']=='yes'){
			
				$a->create_session($row['id']);
				$a->update_status('online');
				$redirect_url=$_REQUEST['redirect_url'];
				/*if ($redirect_url)
					header("location: $redirect_url");
				else{
					header("location:index.php");
				}
				exit();*/
			}
		}
		else{
			$msg="Invalid Username / Email or Password";
		}
	}
	if($_REQUEST['command']=='register'){
		extract($_REQUEST);
		$arr= array();
		$arr['first_name']=$first_name;
		$arr['last_name']=$last_name;
		$arr['username']=$username;
		$arr['email']=$email;
		$arr['password']=$password;
		if($member->username_exist($username)){
			$msg="UserName Already Exist";
			
		}
		else if($member->email_exist($email)){
			$msg="Email Already Exist";
		}
		else{
			$result=$db->insert($arr,"members");
			if($result){
				$id=$db->get_insert_id();
				$a->create_session($id);
				/*<!--header("location: index.php");
				exit();-->*/
			}
			else{
				$msg="Error ";
			}
		}
	}
	$page_title=" Home ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require("includes/common-header.php")?>
</head>
<body style=" background-color: #FC7862;">
    <div id="outer-wrapper" >
    	<?php require("includes/header.php")?>
   		<?php require("includes/navi.php")?>
        
        <div id="content" >
		<div id="leftcontainer" >
                <?php include("includes/left.php");?>
            </div>
            <div id="centercontainer" >
			
                   <div ><?php echo $msg; ?></div>
                   	<?php
						
						if($id > 0){
							$where=" and categoryid=".$id;
						}
						else if($sub_cat_id > 0){
							$where=" and sub_cat_id=".$sub_cat_id;
						}
						$query="select * from products where sub_cat_id='174' ".$where;
						$results_per_page=9;
						$page=intval($_REQUEST['page']);
						if($page<1) $page=1;

						$pg=new Paging($db,$query,$page,$results_per_page);
						$start=$pg->get_start();
						
						$query.=" order by id desc limit $start,$results_per_page";	
						$res_pr=$db->query($query);
                        while($row=$db->fetch_array($res_pr)){
					?>
                   <div id="product">
                     <a href="product-detail.php?id=<?php echo $row['id'];?>"><img src="product-pics/<?php echo $pro->get_display_image($row['id']);?>" width="120" height="100" border="0"/></a>
                     <div id="info" style="margin-top:10px;"><?php echo substr($row['title'],0,14);?></div>
        	             <div id="info" style="padding:0px 5px;	margin:0px;float:left" > <a href="product-detail.php?id=<?php echo $row['id'];?>">Details</a> </div>
                         <div id="info" style="padding:0px 5px;margin:0px;float:right;color:#F00" ><?php echo $row['price']; ?></div>
                         <div style="clear:both"></div>
					</div>
                   <?php } ?>
              	  <div style="clear:both"></div>
                  <?php if($pg->get_total_records() >0) {?>
                  <div class="pagingBar" style="margin:10px;">
                    	<div style="float:left">
                        	Total Records <?php echo $pg->get_total_records() ?>
                        </div>
                        <div style="float:right">
						<?php $pg->render_pages() ?>
                        </div>
                        <br style="clear:both" />
                    </div>
                  <?php } else {?>
                  			<div style="font-family:Verdana, Geneva, sans-serif;font-size:16px;color:#F00;">No Product Found</div>
                  <?php } ?>
            </div>
            
            <!-- centercontainer ends here-->
	        <!-- content ends here-->
      
    </div><!-- outer-wrap ends here-->
</body>
</html>