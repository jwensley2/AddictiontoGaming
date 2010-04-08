<?php

class MY_Controller extends Controller
{
	function MY_Controller(){
		parent::Controller();
		
		if(!$this->last_page = $this->session->flashdata('last_page')){
			$this->last_page = '/';
		}
		$this->session->set_flashdata('last_page', current_url());
		
		$this->output->enable_profiler($this->config->item('debug'));
	}
}

?>