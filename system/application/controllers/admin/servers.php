<?php

class Servers extends My_Controller
{
	function Servers()
	{
		parent::My_Controller();
		
		$this->load->model('serversmodel');
		$this->load->config('servers_config');
		
		$this->header_data['title'] = 'Administration '.SEP.' Servers';
		$this->asset_lib->add_asset('admin/servers', 'css', 'script');
		//$this->header_data['stylesheets'][] = 'admin/servers.css';
	}
	
	/**
	 * Display the list of servers from the database
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
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
	
	/**
	 * Display the edit server form
	 *
	 * @param string $server_id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function edit($server_id = null)
	{
		$this->load->library('form_validation');
		
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions) && $server_id){
			$data['server'] = $this->serversmodel->get_server_info($server_id);
			$data['gametypes'] = $this->config->item('servers_gametypes');
			
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/servers/edit', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
	
	/**
	 * Process the data from the edit server form
	 *
	 * @param int $server_id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function edit_process($server_id = null)
	{
		$this->load->library('form_validation');
		
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions) && $server_id){
			if($this->form_validation->run('server')){
				$this->serversmodel->edit_server($server_id);
				redirect('/admin/servers/');
			}else{
				$data['gametypes'] = $this->config->item('servers_gametypes');
				$data['server'] = $this->serversmodel->get_server_info($server_id);

				$this->load->view('templates/header', $this->header_data);
				$this->load->view('/admin/servers/edit', $data);
				$this->load->view('templates/footer');
			}
		}else{
			redirect($this->last_page);
		}
	}
	
	function add()
	{
		$this->load->library('form_validation');
		
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions)){
			$data['gametypes'] = $this->config->item('servers_gametypes');
			
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/servers/add', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
	
	function add_process()
	{
		$this->load->library('form_validation');
		
		$server_list_permissions = $this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS');
	
		if(permission($server_list_permissions)){
			if($this->form_validation->run('server')){
				$this->serversmodel->add_server();
				redirect('/admin/servers/');
			}else{
				$data['gametypes'] = $this->config->item('servers_gametypes');

				$this->load->view('templates/header', $this->header_data);
				$this->load->view('/admin/servers/add', $data);
				$this->load->view('templates/footer');
			}
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