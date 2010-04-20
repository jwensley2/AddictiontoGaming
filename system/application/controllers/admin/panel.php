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
		$this->header_data['title']			= 'News Administration';
		$this->header_data['scripts'][]		= '../ckeditor/ckeditor.js'; 
		$this->header_data['scripts'][]		= '../ckeditor/adapters/jquery.js'; 
	}
	
	function index()
	{	
		//$this->settingsmodel->set_setting_array('NEWS_PERMISSIONS', array('Founder', 'Manager', 'Community Team'));
		//$this->settingsmodel->set_setting_array('ADMIN_PANEL_PERMISSIONS', array('Founder', 'Manager', 'Community Team'));
		
		$admin_permissions = $this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS');
		if(permission($admin_permissions)){
			echo "Admin panel";
		}else{
			redirect($this->last_page);
		}
	}
}

?>