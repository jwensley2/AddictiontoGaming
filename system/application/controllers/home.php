<?php

class Home extends MY_Controller
{
	
	function Home()
	{
		parent::MY_Controller();
		
		//Load libraries, helpers and models
		$this->load->library(array());
		$this->load->helper(array());
		$this->load->model(array('serversmodel', 'newsmodel'));
		//Set header data
		$this->header_data['stylesheets'][] = 'home.css';
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{	
		//$this->settingsmodel->set_setting_array('NEWS_PERMISSIONS', array('Founder', 'Managers', 'Community Team'));
		//$this->settingsmodel->set_setting_array('MOTW_PERMISSIONS', array('Founder', 'Managers', 'Community Team'));
		//$this->settingsmodel->set_setting_array('ADMIN_PANEL_PERMISSIONS', array('Founder', 'Managers', 'Community Team'));
		//$this->settingsmodel->set_setting_array('DONOR_LIST_PERMISSIONS', array('Founder', 'Managers'));
		
		$data['news'] = $this->newsmodel->get_latest_news();
		$data['permissions']['news'] = permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'));
		
		$this->load->view('templates/header', $this->header_data);
		$this->load->view('home', $data);
		$this->load->view('templates/footer');

	}
}

?>