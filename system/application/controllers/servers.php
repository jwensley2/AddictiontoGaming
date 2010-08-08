<?php

class Servers extends My_Controller
{
	function Servers()
	{
		parent::My_Controller();
		
		$this->load->model('serversmodel');
		
		$this->asset_lib->add_asset('servers', 'css', 'script');
		//$this->header_data['stylesheets'][] = 'servers.css';
	}
	
	function index()
	{
		$data['servers'] = $this->serversmodel->list_servers();
		
		$this->load->view('templates/header', $this->header_data);
		$this->load->view('servers/servers', $data);
		$this->load->view('templates/footer');
	}
}


?>