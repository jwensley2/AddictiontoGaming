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
		
		$data['news'] = $this->newsmodel->get_latest_news();
		$data['permissions']['news'] = permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'));
		
		$this->load->view('templates/header', $this->header_data);
		$this->load->view('home', $data);
		$this->load->view('templates/footer');

	}
	
	function vent()
	{
		$this->load->library('servers/ventrilo_status.php');
		
		dump($this->ventrilo_status->get_full_server_status('vent30.gameservers.com', '4631'));
	}
	
	function bw()
	{
		dump($this->source_status->get_server_players('69.39.236.40', '27015'));
	}
}

?>