<?php

/**
* 
*/
class Twitter extends MY_Controller
{
	
	function Twitter()
	{
		parent::My_Controller();
		
		$this->load->library('Twitter_lib');
	}
	
	function index()
	{
		echo 'Nothing here yet';
		echo "<br/><a href='{$this->last_page}'>Back</a>";
	}
	
	function update()
	{
		$status = $this->input->post('status');
		
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if(permission($news_permissions)){
			$this->twitter_lib->auth();
			$this->twitter_lib->update($status);
			redirect($this->last_page);
		}else{
			redirect($this->last_page);
		}
		
	}
}


?>