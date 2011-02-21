<?php

class Donations extends My_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('Donations_lib'));
		$this->load->model('serversmodel');
		
		$this->header_data['title'] = 'Administration '.SEP.' Donors';
		
		// Add assets
		$this->asset_lib->add_asset('admin/donations', 'css', 'script');
		//$this->header_data['stylesheets'][] = 'admin/donations.css';
	}
	
	function index(){
		$this->donors();
	}
	
	function donors()
	{
		$donor_list_permissions = $this->settingsmodel->get_setting_array('DONOR_LIST_PERMISSIONS');
		if(permission($donor_list_permissions)){
			$data['donors'] = $this->donations_lib->get_donor_list();

			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/donors/donors', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
}


?>