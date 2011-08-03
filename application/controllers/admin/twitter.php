<?php defined('BASEPATH') or exit('No direct script access allowed');


class Twitter extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Twitter_lib');
	}
	
	// --------------------------------------------------------------------
	
	public function index()
	{
		echo 'Nothing here yet';
		echo "<br/><a href='{$this->last_page}'>Back</a>";
	}
	
	// --------------------------------------------------------------------
	
	public function update()
	{
		$status = $this->input->post('status');
		
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if (permission($news_permissions))
		{
			$this->twitter_lib->auth();
			$this->twitter_lib->update($status);
			
			redirect($this->last_page);
		}
		else
		{
			redirect($this->last_page);
		}
	}
}


/* End of file twitter.php */
/* Location: ./application/controllers/admin/twitter.php */