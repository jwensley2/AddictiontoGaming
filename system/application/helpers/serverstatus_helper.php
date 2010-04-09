<?php

function status_to_class($status){
	if($status == 1){
		return 'online';
	}elseif($status == 0){
		return 'offline';
	}else{
		return 'unknown';
	}
}


function status_to_word($status){
	if($status == 1){
		return 'Online';
	}elseif($status == 0){
		return 'Offline';
	}else{
		return 'Status Uknown';
	}
}
?>