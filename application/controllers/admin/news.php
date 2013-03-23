<?php defined('BASEPATH') or exit('No direct script access allowed');


class News extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		//Load libraries, helpers and models
		$this->load->library(array('form_validation'));
		$this->load->helper(array('permission'));
		$this->load->model(array('serversmodel', 'newsmodel'));
		//Set header data
		$this->header_data['title']			= 'News Administration';
				
		// Add assets
		$this->asset_lib->add_asset('admin/news', 'css', 'script');
		$this->asset_lib->add_asset('../ckeditor/ckeditor', 'js', 'header2', FALSE);
		$this->asset_lib->add_asset('../ckeditor/adapters/jquery', 'js', 'header2', FALSE);
	}
	
	// --------------------------------------------------------------------
	
	public function edit($news_id = NULL)
	{
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if (permission($news_permissions) AND $news_id)
		{
			$data['news'] = $this->newsmodel->get_news_item($news_id);

			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/edit.php', $data);
			$this->load->view('templates/footer');	
		}
		else
		{
			redirect($this->last_page);
		}
	}
	
	// --------------------------------------------------------------------
	
	public function edit_process($news_id = NULL)
	{	
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if (permission($news_permissions) AND $news_id)
		{
			if ($this->form_validation->run('news'))
			{
				$this->newsmodel->edit_news_item($news_id);
				redirect('/');
			}
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/edit.php', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			redirect($this->last_page);
		}
	}
	
	// --------------------------------------------------------------------
	
	public function delete($news_id = NULL)
	{
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if (permission($news_permissions) AND $news_id)
		{
			$this->newsmodel->delete_news_item($news_id);
			redirect('/');
		}
		else
		{
			redirect($this->last_page);
		}
	}
	
	// --------------------------------------------------------------------
	
	public function submit()
	{
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if (permission($news_permissions))
		{
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/submit.php', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			redirect($this->last_page);
		}
	}
	
	// --------------------------------------------------------------------
	
	public function submit_process()
	{	
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if (permission($news_permissions))
		{
			if ($this->form_validation->run('news'))
			{
				$this->newsmodel->submit_news_item($news_id);
				redirect('/');
			}
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/submit.php', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			redirect($this->last_page);
		}
	}
}


/* End of file news.php */
/* Location: ./application/controllers/admin/news.php */