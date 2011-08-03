<?php defined('BASEPATH') or exit('No direct script access allowed');


class Panel extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Load libraries, helpers and models
		$this->load->library(array('form_validation'));
		$this->load->helper(array('permission'));
		$this->load->model(array('serversmodel', 'newsmodel'));
		// Set header data
		$this->header_data['title'] = 'Administration Panel';
		
		// Add Assets
		$this->asset_lib->add_asset('admin/news', 'css', 'script');
	}
	
	// --------------------------------------------------------------------
	
	public function index()
	{		
		$admin_permissions = $this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS');
		if (permission($admin_permissions))
		{
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('admin/panel');
			$this->load->view('templates/footer');
		}
		else
		{
			redirect($this->last_page);
		}
	}
}


/* End of file panel.php */
/* Location: ./application/controllers/admin/panel.php */