<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Controller to run the home page and anything related to it
 *
 * @package default
 * @author Joseph Wensley
 */
class Home extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Load libraries, helpers and models
		$this->load->library(array());
		$this->load->helper(array());
		$this->load->model(array('serversmodel', 'newsmodel'));
		
		$this->asset_lib->add_asset('home', 'css', 'script');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display the home page
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	public function index()
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


/* End of file home.php */
/* Location: ./application/controllers/home.php */