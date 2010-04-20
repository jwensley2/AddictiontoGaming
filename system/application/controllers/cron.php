<?php

class Cron extends MY_Controller
{
	
	function Cron()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$this->set_player_of_the_week();
	}
	
	function set_player_of_the_week()
	{
		$this->load->library('Phpbb_lib');
		$this->load->model('potwmodel');
		
		if($this->potwmodel->set_current_member() == TRUE){
			$member = $this->potwmodel->get_current_member();
			$post_url = $this->phpbb_lib->createNewTopic(40, $member->name, $member->forum_post_text, FALSE, TRUE, TRUE, TRUE);	
			$this->potwmodel->set_post_url($member->id, $post_url);
		}
	}
	
}


?>