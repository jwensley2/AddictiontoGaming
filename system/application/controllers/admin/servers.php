<?php

class Servers extends My_Controller
{
	function Servers()
	{
		parent::My_Controller();
		
		$this->load->model('serversmodel');
		
		$this->header_data['title'] = 'Administration '.SEP.' Servers';
		$this->header_data['stylesheets'][] = 'admin/servers.css';
	}
	
	function index()
	{
		//$this->settingsmodel->set_setting_array('SERVER_LIST_PERMISSIONS', array('Founder'));
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions)){
			$data['servers'] = $this->serversmodel->quick_list_servers();

			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/servers/servers', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
	
	function edit($server_id = null)
	{
		$this->load->library('form_validation');
		
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions) && $server_id){
			$data['server'] = $this->serversmodel->get_server_info($server_id);

			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/servers/edit', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
	
	function edit_process($server_id = null)
	{
		$this->load->library('form_validation');
		
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions)){
			$data['servers'] = $this->serversmodel->quick_list_servers();

			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/servers/edit', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
	
	function delete($server_id = null)
	{
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions) && $server_id){
			$this->serversmodel->delete_server($server_id);
			redirect('/admin/servers');
		}else{
			redirect($this->last_page);
		}
	}
}


?>