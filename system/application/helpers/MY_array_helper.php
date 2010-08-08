<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function multi_unique($multi_array)
{
	foreach($multi_array as $array){
		$new_key = md5(serialize($array));
		$new_array[$new_key] = $array;
	}
	
	foreach($new_array as $array){
		$return[] = $array;
	}
	
	return $return;
}

?>