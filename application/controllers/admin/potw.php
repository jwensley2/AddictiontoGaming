<?php defined('BASEPATH') or exit('No direct script access allowed');


class Potw extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		// Load libraries, helpers and models
		$this->load->library(array('form_validation'));
		$this->load->helper(array('permission'));
		$this->load->model(array('serversmodel', 'potwmodel'));
		
		// Set header data
		$this->header_data['title']			= 'Administration '.SEP.' Player of the Week';
		
		// Add Assets
		$this->asset_lib->add_asset('admin/potw', 'css', 'script');
		$this->asset_lib->add_asset('../ckeditor/ckeditor', 'js', 'header2', FALSE);
		$this->asset_lib->add_asset('../ckeditor/adapters/jquery', 'js', 'header2', FALSE);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display the member of the week submission form
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	public function submit()
	{	
		$motw_permissions = $this->settingsmodel->get_setting_array('POTW_PERMISSIONS');
		$data['upcoming_players'] = $this->potwmodel->get_upcoming_players();
		if (permission($motw_permissions))
		{
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/potw/submit.php', $data);
			$this->load->view('templates/footer');	
		}
		else
		{
			redirect($this->last_page);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Processes data from the Member of the Week form
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	public function submit_process()
	{
		$potw_permissions = $this->settingsmodel->get_setting_array('POTW_PERMISSIONS');
		if (permission($potw_permissions))
		{
			if ($this->form_validation->run('potw'))
			{
				//Set upload config
				$config['upload_path'] = './assets/images/potw_pictures';
				$config['allowed_types'] = 'jpg';
				$config['max_size'] = '3000';
				$config['max_width'] = '1680';
				$config['max_height'] = '1050';

				$this->load->library('upload', $config);
				
				if ($this->upload->do_upload('photo'))
				{
					$upload_data = $this->upload->data();
					$member_id = $this->potwmodel->add_member();
				
					if ($member_id)
					{
						$this->load->helper('thumbnail');
					
						$thumb_path	= $upload_data['file_path'].$member_id.'_thumb'.$upload_data['file_ext'];
						$full_path	= $upload_data['file_path'].$member_id.'_full'.$upload_data['file_ext'];
					
						ci_create_thumbnail($upload_data['full_path'], $thumb_path, 274, 274);
						rename($upload_data['full_path'], $full_path);
					
					
					}
					else
					{
						unlink($upload_data['full_path']);
					}
					
					$this->load->model('cronmodel');
					$this->cronmodel->set_player_of_the_week();
					
					redirect('/');
				}
				else
				{
					$this->upload->display_errors('<p>', '</p>');
				}
			}
			
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/potw/submit.php', $data);
			$this->load->view('templates/footer');	
		}
		else
		{
			redirect($this->last_page);
		}
	}
	
	// --------------------------------------------------------------------
	
	public function _steam_id_check($str)
	{
		$this->form_validation->set_message('_steam_id_check', 'The %s field must contain a valid Steam ID or nothing');

		$regex = "/^STEAM_0:(0|1):(\d){1,12}$/";
		if ($str == "" || preg_match($regex, $str))
		{
			return TRUE;
		}
		return FALSE;
	}
}


/* End of file potw.php */
/* Location: ./application/controllers/admin/potw.php */