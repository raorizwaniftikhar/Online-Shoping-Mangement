<?php
	function createThumb($src_pic,$dest_pic,$w=0,$h=0){
		
		if($src_pic=='' || $dest_pic=='') return false;
		if(!file_exists($src_pic)){
			echo "createThumb:file doesn't exist - ".$src_pic;
			return false;
		}
		
		$parts=pathinfo($src_pic);
		$type=strtolower($parts['extension']);
		
		if($type=='jpg' || $type=='jpeg'){
			$img=@imagecreatefromjpeg($src_pic);
		}
		else if($type=='gif'){
			$img=@imagecreatefromgif($src_pic);
		}
		else if($type=='png'){
			$img=@imagecreatefrompng($src_pic);
		}
		if(is_resource($img)){

			$width=imagesx($img);
			$height=imagesy($img);
			
			if($w==0 && $h>0){
				$w=$width/($height/$h);
			}
			else if($w>0 && $h==0){
				$h=$height/($width/$w);
			}
			else{
				die("Thumbnail width and height both can't be zero");
			}
			
			$thumb=imagecreatetruecolor($w,$h);
			imagecopyresampled($thumb,$img,0,0,0,0,$w,$h,imagesx($img),imagesy($img));

			imagejpeg($thumb,$dest_pic,90);
		}
		else{
			echo "<br>invalid picture - ".$src_pic;
			return false;
		}
	}
	function get_us_stats_list(){
		$states=array('AL'=>'Alabama', 'AK'=>'Alaska', 'AZ'=>'Arizona', 'AR'=>'Arkansas', 'CA'=>'California', 'CO'=>'Colorado', 'CT'=>'Connecticut', 'DE'=>'Delaware', 'FL'=>'Florida', 'GA'=>'Georgia', 'HI'=>'Hawaii', 'ID'=>'Idaho', 'IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa', 'KS'=>'Kansas', 'KY'=>'Kentucky', 'LA'=>'Louisiana', 'ME'=>'Maine', 'MD'=>'Maryland', 'MA'=>'Massachusetts', 'MI'=>'Michigan', 'MN'=>'Minnesota', 'MS'=>'Mississippi', 'MO'=>'Missouri', 'MT'=>'Montana', 'NE'=>'Nebraska', 'NV'=>'Nevada', 'NH'=>'New Hampshire', 'NJ'=>'New Jersey', 'NM'=>'New Mexico', 'NY'=>'New York', 'NC'=>'North Carolina', 'ND'=>'North Dakota', 'OH'=>'Ohio', 'OK'=>'Oklahoma', 'OR'=>'Oregon', 'PA'=>'Pennsylvania', 'RI'=>'Rhode Island', 'SC'=>'South Carolina', 'SD'=>'South Dakota', 'TN'=>'Tennessee', 'TX'=>'Texas', 'UT'=>'Utah', 'VT'=>'Vermont', 'VA'=>'Virginia', 'WA'=>'Washington', 'WV'=>'West Virginia', 'WI'=>'Wisconsin', 'WY'=>'Wyoming');
		return $states;
	}
		
	function filter_chars($text){
		$text=str_replace(" ","-",$text);
		$arr=array("/","?","&","%","\\",":");
		$text=str_replace($arr,"",$text);
		return $text;
	}
?>