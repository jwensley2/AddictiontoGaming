<?php

class Servers extends My_Controller
{
	function Servers()
	{
		parent::My_Controller();
		
		$this->load->model('serversmodel');
		
		$this->header_data['stylesheets'][] = 'servers.css';
	}
	
	function index()
	{
		$data['servers'] = $this->serversmodel->list_servers();
		
		$this->load->view('templates/header', $this->header_data);
		$this->load->view('servers/servers', $data);
		$this->load->view('templates/footer');
	}
	
	/*function hover_box($server_id)
	{
		$this->output->enable_profiler(FALSE);
		
		$server_info = $this->serversmodel->get_server_info($server_id);
		
		if($server_info->game == 'vent'){
			$this->load->view('servers/popups/ventrilo', $server_info);
		}elseif(in_array($server_info->game, array('tf2', 'l4d', 'l4d2'))){
			$this->load->view('servers/popups/source', $server_info);
		}else{
			$this->load->view('servers/popups/other', $server_info);
		}
	}*/
}


?>