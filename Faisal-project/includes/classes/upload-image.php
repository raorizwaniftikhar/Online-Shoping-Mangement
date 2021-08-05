<?php
class UploadImage{
		var $image_width;
		var $image_height;
		var $thumb_width='100';
		var $thumb_height='100';
		var $fix_aspect='both';
		var $prefix="thumb";
		var $type;
		var $attribute;
		var $image_name;
		var $image_full_path;
		var $error_msg;
		var $restrict_image_size=false;
		var $restricted_width;
		var $restricted_height;
		var $allowed_extension=array('jpg','png','gif','jpeg');
		
		function __construct(){}
		
		function upload_image($source,$destination,$name=''){
			
			$default_name=$source['name'];
			$source_path=$source['tmp_name'];
			list($width,$height,$type,$attr)=getimagesize($source['tmp_name']);
			if ($this->restrict_image_size==true){
				if ($width!=$this->restricted_width && $height!=$this->restricted_height){
					$msg="<b>Error</b><br>Uploaded Image<br>Width: $width<br>Height: $height<br><br>Allowed Image<br>";
					$msg.="Width: ".$this->restricted_width;
					$msg.="<br>Height: ".$this->restricted_height;
					die($msg);
				}	
			}
			$info=pathinfo($default_name);
			$ext=$info['extension'];
			if (in_array(strtolower($ext),$this->allowed_extension)){
				if (@move_uploaded_file($source_path,$destination.$default_name)){
					$img_info=pathinfo($destination.$default_name);
					if ($name!=''){
						$name=$name.'.'.$img_info['extension'];
						rename($destination.$default_name,$destination.$name);	
					}
					else
						$name=$default_name;
					list($width,$height,$type,$attr)=getimagesize($destination.$name);
					$this->image_width=$width;
					$this->image_height=$height;
					$this->type=$type;
					$this->attribute=$attr;
					$this->image_full_path=$destination.$name;
					$this->image_name=$name;
					return true;
				}
				else{
					$this->error_msg="Image not found on given source \"$source_path\" ";	
					return false;
				}
			}
			else{
				echo "You Uploaded the file named <b>'$default_name'</b><br>Allowed extensions are ";
				foreach($this->allowed_extension as $img)
					echo $img.', ';
				die('');
			}
		}
		
		function upload_image_with_thumbnail($source,$destination,$name='',$width=100,$height=100,$fix_aspect="both",$prefix="thumb"){
			if ($this->upload_image($source,$destination,$name)){
				$this->set_thumb_settings($width,$height,$fix_aspect,$prefix);
				if ($this->create_thumbnail($this->image_full_path,$destination))
					return true;
				else{
					$this->error_msg="Error Creating Thumb";
					return false;
				}
			}
			else{
				$this->error_msg="Error Uploading Image";
				return false;
			}
		}
		
		function upload_fixed_size_image($source,$destination,$name='',$width=100,$height=100,$fix_aspect="both"){
			if ($this->upload_image_with_thumbnail($source,$destination,$name,$width,$height,$fix_aspect)){
				unlink($this->image_full_path);
				rename($destination.$this->prefix.'-'.$this->image_name,$destination.$this->image_name);
				return true;
			}
			else{
				$this->error_msg="Error Uploading Image";
				return false;	
			}
		}
		
		function set_thumb_settings($width=100,$height=100,$fix_aspect="both",$prefix="thumb"){
			if ($fix_aspect=='both'){
				$this->thumb_width=$width;
				$this->thumb_height=$height;	
			}
			else if ($fix_aspect=='width'){
				$this->thumb_width=$width;
				$this->thumb_height=floor(($width/$this->image_width)*$this->image_height);
			}
			else if ($fix_aspect=='height'){
				$this->thumb_height=$height;
				$this->thumb_width=floor(($height/$this->image_height)*$this->image_width);
			}
			$this->prefix=$prefix;
		}
		
		function restrict_image_size($width,$height){
			$this->restrict_image_size=true;
			$this->restricted_width=$width;
			$this->restricted_height=$height;
		}
		
		function create_thumbnail($source,$destination){
			$img_info=pathinfo($source);
			if (strtolower($img_info['extension'])=='jpg' || strtolower($img_info['extension'])=='jpeg')
				$source_image=imagecreatefromjpeg($source);
			else if (strtolower($img_info['extension'])=='png')
				$source_image=imagecreatefrompng($source);
			else if (strtolower($img_info['extension'])=='gif')
				$source_image=imagecreatefromgif($source);
			else{
				$this->error_msg="Invalid File Format. Only jpg,png,gif images are allowed";
				return false;
			}
			$src_width=imagesx($source_image);
			$src_height=imagesy($source_image);
			$virtual_image=imagecreatetruecolor($this->thumb_width,$this->thumb_height);
			//imagecopyresized($virtual_image,$source_image,0,0,0,0,$this->thumb_width,$this->thumb_height,$src_width,$src_height);
			imagecopyresampled($virtual_image,$source_image,0,0,0,0,$this->thumb_width,$this->thumb_height,$src_width,$src_height);
			$thumb_name=$this->prefix.'-'.$this->image_name;
			if (strtolower($img_info['extension'])=='jpg' || strtolower($img_info['extension'])=='jpeg')
				imagejpeg($virtual_image,$destination.$thumb_name,90);
			else if (strtolower($img_info['extension'])=='png')
				imagepng($virtual_image,$destination.$thumb_name);
			else if (strtolower($img_info['extension'])=='gif')
				imagegif($virtual_image,$destination.$thumb_name);
			return true;			
		}
		
		function get_image_name(){
			return $this->image_name;	
		}
		
		function get_image_full_path(){
			return $this->image_full_path;	
		}
		
		function get_error(){
			return $this->error_msg;	
		}
	}
	$upload_img=new UploadImage();
?>