<?php
error_reporting(0);
	define("DOMAIN","ecommerce");
	define("ADMIN_URL","admin");
	define("APP_TITLE","G Fashion-Online Shopping");
	
	define("HOST_URL","http://".$_SERVER['HTTP_HOST']."/");
	
	define("ROOT_DIR",dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
	
	$location_arr=explode("/",substr($_SERVER['SCRIPT_NAME'],1));
	define("BASE_URL",HOST_URL.$location_arr[0]."/".$location_arr[1]."/");
	define("CLIENT_URL",BASE_URL);
	
	define("THUMB_PREFIX","thumb");
	define("THUMB_WIDTH",70);
	define("THUMB_HEIGHT",110);
	define("VIDEOS_URL","videos/");
	define("VIDEOS_DIR",ROOT_DIR."videos/");
	session_start();
?>