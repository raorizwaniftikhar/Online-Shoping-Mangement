<?php
	include("includes/config.php");
	include("includes/classes/db.php");
	include("includes/classes/auth.php");
	include("includes/classes/preferences.php");
	include("includes/classes/blogs.php");
	$a->logout();
	unset($_SESSION['chat_toid']);
	unset($_SESSION['chat_fromid']);
	unset($_SESSION['carts']);
	header("location: index.php");
?>
