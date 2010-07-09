<?php

class News extends MY_Controller
{
	
	function News()
	{
		parent::MY_Controller();
		
		//Load libraries, helpers and models
		$this->load->library(array('form_validation'));
		$this->load->helper(array('permission'));
		$this->load->model(array('serversmodel', 'newsmodel'));
		//Set header data
		$this->header_data['stylesheets'][]	= 'admin/news.css';
		$this->header_data['title']			= 'News Administration';
		$this->header_data['scripts'][]		= '../ckeditor/ckeditor.js'; 
		$this->header_data['scripts'][]		= '../ckeditor/adapters/jquery.js'; 
	}
	
	function edit($news_id = null)
	{
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if(permission($news_permissions) && $news_id){
			$data['news'] = $this->newsmodel->get_news_item($news_id);

			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/edit.php', $data);
			$this->load->view('templates/footer');	
		}else{
			redirect($this->last_page);
		}
	}
	
	function edit_process($news_id = null)
	{	
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if(permission($news_permissions) && $news_id){
			if($this->form_validation->run('news')){
				$this->newsmodel->edit_news_item($news_id);
				redirect('/');
			}
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/edit.php', $data);
			$this->load->view('templates/footer');
		}else{
			redirect($this->last_page);
		}
	}
	
	function delete($news_id = null)
	{
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if(permission($news_permissions) && $news_id){
			$this->newsmodel->delete_news_item($news_id);
			redirect('/');
		}else{
			redirect($this->last_page);
		}
	}
	
	function submit()
	{
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if(permission($news_permissions)){
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/submit.php', $data);
			$this->load->view('templates/footer');
		}else{
			redirect($this->last_page);
		}
	}
	
	function submit_process()
	{	
		$news_permissions = $this->settingsmodel->get_setting_array('NEWS_PERMISSIONS');
		if(permission($news_permissions)){
			if($this->form_validation->run('news')){
				$this->newsmodel->submit_news_item($news_id);
				redirect('/');
			}
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('/admin/news/submit.php', $data);
			$this->load->view('templates/footer');
		}else{
			redirect($this->last_page);
		}
	}
}

?>