<?php defined('BASEPATH') or exit('No direct script access allowed');


class Cronmodel extends CI_Model {
	
	/**
	 * Set the player of the week to the newest one available in the db and create a new forum topic for it using the post body from the db entry
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	public function set_player_of_the_week()
	{
		$this->load->library('Phpbb_lib');
		$this->load->model('potwmodel');
		
		if ($this->potwmodel->set_current_member() == TRUE)
		{
			$member		= $this->potwmodel->get_current_member();
			$post_url	= $this->phpbb_lib->createNewTopic(40, $member->name, $member->forum_post_text, FALSE, TRUE, TRUE, TRUE);
			
			$this->potwmodel->set_post_url($member->id, $post_url);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Re-generate the donation progress image
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	public function update_donations_progress()
	{
		$this->load->library('donations_lib');
		$this->donations_lib->generate_progress_bar();
	}
}


/* End of file cronmodel.php */
/* Location: ./application/models/cronmodel.php */