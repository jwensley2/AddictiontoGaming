<?php

function ci_create_thumbnail($original, $output_path, $dst_w = 50, $dst_h = 50){
	$original = realpath($original);
	
	//Get the path info and pull out the directory
	$path_parts = pathinfo($output_path);
	$dir =& $path_parts['dirname'];
	
	//Check if the destination directory exists, create it if it doesn't
	if(!is_dir($dir)){
		mkdir($dir);
	}
	
	//Get the image width, height, type and attributes
	list($src_w, $src_h, $type, $attr) = getimagesize($original);
	
	//Check image type to see which create function to use
	//Type 2 = jpg; Type 3 = png
	if($type == 2){
		$source = imagecreatefromjpeg($original);
	}elseif($type = 3){
		$source = imagecreatefrompng($original);
	}
	
	//Create the file for the thumb
	$thumb = imagecreatetruecolor($dst_w, $dst_h);
	$diff_w = $src_w - $dst_w;
	$diff_h = $src_h - $dst_h;

	if ($diff_w < $diff_h){
		$r1 = ($src_w / $dst_w);
		$r2 = ($src_h / $dst_h);

		if($r1 > $r2){
			$dst_h_o = $dst_h;
			$dst_h = ($src_h / $r2);

			$dst_y = ($dst_h_o - $dst_h)/2;
			$dst_x = 0;
		}else{
			$dst_h_o = $dst_h;
			$dst_h = ($src_h / $r1);

			$dst_y = ($dst_h_o - $dst_h)/2;
			$dst_x = 0;
		}
	}else{
		$r1 = ($src_h / $dst_h);
		$r2 = ($src_w / $dst_w);

		if($r1 > $r2){
			$dst_w_o = $dst_w;
			$dst_w = ($src_w / $r2);

			$dst_x = ($dst_w_o - $dst_w)/2;
			$dst_y = 0;
		}else{
			$dst_w_o = $dst_w;
			$dst_w = ($src_w / $r1);

			$dst_x = ($dst_w_o - $dst_w)/2;
			$dst_y = 0;
		}
	}
	
	
	//Copy and resample the source image to the destination image, cropping and resizing at the same time
	imagecopyresampled($thumb, $source, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	//echo "imagecopyresampled($thumb, $source, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);";
	
	//Check image type to see which function to use
	if($type == 2){
		imagejpeg($thumb, $output_path);
	}elseif($type = 3){
		imagepng($thumb, $output_path);
	}
	
}

?>