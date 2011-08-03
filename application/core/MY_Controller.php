<?php

class MY_Controller extends CI_Controller
{
	public $last_page;
	
	function __construct(){
		parent::__construct();
		
		$this->load->library('session');
		
		if( ! $this->last_page = $this->session->flashdata('last_page'))
		{
			$this->last_page = '/';
		}
		
		$this->session->set_flashdata('last_page', current_url());
		
		$this->output->enable_profiler($this->config->item('debug'));
	}
}

?>