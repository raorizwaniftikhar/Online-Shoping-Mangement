<?php
	include("../includes/config.php");
	include("../includes/classes/db.php");
	include("../includes/classes/categories.php");
	include("../includes/classes/products.php");
	include("../includes/classes/upload-image.php");
	include("../includes/functions.php");
	include("includes/classes/auth.php");
	include("includes/classes/navigation-menu.php");
	
	$id=intval($_REQUEST['id']);
	$query="select * from product_subcategories where categoryid=".$id;
	$sub=$db->query($query);
	$str="";
	while($r=$db->fetch_array($sub)){
		
        	$str.='<option value="'.$r[id].'">'.$r[name].'</option>';
    }
	echo $str;
?>