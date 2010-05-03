<?php

class Panel extends MY_Controller
{
	
	function Panel()
	{
		parent::MY_Controller();
		
		//Load libraries, helpers and models
		$this->load->library(array('form_validation'));
		$this->load->helper(array('permission'));
		$this->load->model(array('serversmodel', 'newsmodel'));
		//Set header data
		$this->header_data['stylesheets'][]	= 'admin/news.css';
		$this->header_data['title']			= 'Administration Panel';
	}
	
	function index()
	{	
		//$this->settingsmodel->set_setting_array('NEWS_PERMISSIONS', array('Founder', 'Manager', 'Community Team'));
		//$this->settingsmodel->set_setting_array('ADMIN_PANEL_PERMISSIONS', array('Founder', 'Manager', 'Community Team'));
		
		$admin_permissions = $this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS');
		if(permission($admin_permissions)){
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('admin/panel');
			$this->load->view('templates/footer');
		}else{
			redirect($this->last_page);
		}
	}
}

?>