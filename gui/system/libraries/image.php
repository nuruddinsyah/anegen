<?php
/*
------------------------------------------------------------
 Luxi - Simple PHP Framework
------------------------------------------------------------
 Version : 1.9.01
 By : Muhammad Faruq Nuruddinsyah
 Division of D-Webs - DaftLabs, Dafturn Technology
------------------------------------------------------------
 License : GNU/LGPL (GNU Lesser GPL)
 Home Page : http://dafturn.org/daftlabs/dwebs/luxi
------------------------------------------------------------
 Copyright 2011. All Rights Reserved.
------------------------------------------------------------
 Library : Image Manipulation
------------------------------------------------------------
*/

class Image{
	var $image;
	var $image_type;
 	
	function Image($filename = ''){
		if($filename!=''){
			$this->load($filename);
		}
	}
	
	function load($filename){
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		if($this->image_type==IMAGETYPE_JPEG){
			$this->image = imagecreatefromjpeg($filename);
		}else if($this->image_type==IMAGETYPE_GIF){
			$this->image = imagecreatefromgif($filename);
		}else if($this->image_type==IMAGETYPE_PNG){
			$this->image = imagecreatefrompng($filename);
		}
	}
	
	function save($filename, $image_type = IMAGETYPE_JPEG){
		if($image_type==IMAGETYPE_JPEG){
			imagejpeg($this->image, $filename, 100);
		}else if( $image_type==IMAGETYPE_GIF){
			imagegif($this->image, $filename);			
		}else if( $image_type==IMAGETYPE_PNG){
			imagepng($this->image, $filename);
		}
	}
	
	function output($image_type = IMAGETYPE_JPEG) {
		if($image_type==IMAGETYPE_JPEG){
			header("Content-type: image/jpeg");
			imagejpeg($this->image, NULL, 100);
		}else if($image_type==IMAGETYPE_GIF){
			header("Content-type: image/gif");
			imagegif($this->image);			
		}else if($image_type==IMAGETYPE_PNG){
			header("Content-type: image/png");
			imagepng($this->image);
		}	
	}
	
	function get_width(){
		return imagesx($this->image);
	}
	
	function get_height(){
		return imagesy($this->image);
	}
	
	function resize_to_height($height){
		$ratio = $height / $this->get_height();
		$width = $this->get_width() * $ratio;
		$this->resize($width, $height);
	}
	
	function resize_to_width($width){
		$ratio = $width / $this->get_width();
		$height = $this->get_height() * $ratio;
		$this->resize($width, $height);
	}
	
	function scale($scale){
		$width = $this->get_width() * $scale/100;
		$height = $this->get_height() * $scale/100; 
		$this->resize($width, $height);
	}
	
	function resize($width, $height){
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->get_width(), $this->get_height());
		$this->image = $new_image;	
	}
}

?>
