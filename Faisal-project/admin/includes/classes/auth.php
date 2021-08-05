<?php
	class auth{
		function __construct(){
			session_start();
		}
		function authenticate($redirect=true){
			if($_SESSION['aid']<1){
				$_SESSION['redirect_path']=dirname(BASE_URL).$_SERVER['REQUEST_URI'];
				if($redirect)	header("location:login.php");
			}
			return $_SESSION['aid'];
		}
		function create_session($id){
			$_SESSION['aid']=$id;
		}
		function logout(){
			unset($_SESSION['aid']);
			header("location:login.php");
		}
	}
	$a=new auth();
?>