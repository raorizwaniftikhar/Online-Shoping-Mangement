<?php
	function filter_chars($text){
		$text=str_replace(" ","-",$text);
		$arr=array("/","?","&","%","\\",":");
		$text=str_replace($arr,"",$text);
		return $text;
	}
?>