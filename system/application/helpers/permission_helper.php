<?php

function permission($allowed_groups = array())
{
	$CI = get_instance();
	
	if ($CI->phpbb_lib->isLoggedIn() === TRUE){
		
		//Get the groups that the user belongs to
		$user_groups = $CI->phpbb_lib->getUserGroupMembership();
		
		if($CI->phpbb_lib->isGroupMember('Founder')){
			return true;
		}else{
			foreach($allowed_groups as $allowed_group){
				$allowed_group = strtolower($allowed_group);
				if($CI->phpbb_lib->isGroupMember($allowed_group)){
					return true;
				}
			}
		}
	}
	
	//If there were no matches or the user wasn't logged in return false
	return false;
}

?>