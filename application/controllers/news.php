<?php

class News extends My_Controller
{
	function News()
	{
		parent::My_Controller();
		$this->load->model(array('newsmodel', 'serversmodel'));
		$this->header_data['title'] = 'News and Announcements';
	}
	
	function archive($month = null, $year = null)
	{
		$this->header_data['title'] = 'News and Announcements Archive';
		$this->asset_lib->add_asset('news_archive', 'css', 'script');
		//$this->header_data['stylesheets'] = array('news_archive.css');
		
		if($month && $year){
			$data['news'] = $this->newsmodel->get_posts_by_month($month, $year);
			$data['permissions']['news'] = permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'));
			
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('news/archive_posts', $data);
			$this->load->view('templates/footer');
		}else{
			$data['dates'] = $this->newsmodel->get_archive_months();
			
			$this->load->view('templates/header', $this->header_data);
			$this->load->view('news/archive_dates', $data);
			$this->load->view('templates/footer');
		}
	}
}

?>