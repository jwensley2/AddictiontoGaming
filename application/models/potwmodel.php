<?php defined('BASEPATH') or exit('No direct script access allowed');


class Potwmodel extends CI_Model {
	
	function __construct()
	{
		//Call the Model constructor
		parent::__construct();
		$this->load->database('default');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add a member to the players of the week database
	 *
	 * @return bool
	 * @author Joseph Wensley
	 */
	function add_member()
	{	
		
		$start_date = $this->input->post('start_date');
		
		if ($start_date)
		{
			list($month, $day, $year) = explode('/', $str);
			$unix_date = mktime(0, 0, 0, (int) $month, (int) $day, (int) $year);
		}
		else
		{
			$unix_date = mktime(0, 0, 0);
		}
		
		$query = $this->db->set('name', $this->input->post('name'))
			->set('real_name', $this->input->post('real_name'))
			->set('steam_id', $this->input->post('steam_id'))
			->set('forum_post_text', $this->input->post('forum_post_text'))
			->set('start_date', 'FROM_UNIXTIME('.$unix_date.')', FALSE)
			->insert('players_of_the_week');
		
		if ($query)
		{
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns the row from the database containing the current player of the week
	 *
	 * @return object
	 * @author Joseph Wensley
	 */
	function get_current_member()
	{
		$query = $this->db->get_where('players_of_the_week', array('current' => 1));
		return $query->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check to see if there is a new player of the week to display and set them to motw if there is.
	 *
	 * @return bool Returns TRUE if it changes the motw or FALSE if it doesn't
	 * @author Joseph Wensley
	 */
	function set_current_member()
	{
		$now = time();
		$current = $this->get_current_member();
		
		$new_member = $this->db->select('id')
			->where("`start_date` < FROM_UNIXTIME($now)", NULL, FALSE)
			->order_by('start_date', 'desc')
			->limit(1)
			->get('players_of_the_week')
			->row();
		
		if ($current->id != $new_member->id)
		{
			$this->db->where('current', 1)
				->update('players_of_the_week', array('current' => 0));
			
			$this->db->where('id', $new_member->id)
				->update('players_of_the_week', array('current' => 1));
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Retrieves a list of upcoming potw from the db
	 *
	 * @return object
	 * @author Joseph Wensley
	 */
	function get_upcoming_players()
	{
		$now = time();
		
		$query = $this->db->select('name, UNIX_TIMESTAMP(start_date) as start_date')
			->where("`start_date` > FROM_UNIXTIME($now)", NULL, FALSE)
			->get('players_of_the_week');
		
		return $query->result();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sets the post_url of a member in the database
	 *
	 * @param string $member_id 
	 * @param string $post_url 
	 * @return void
	 * @author Joseph Wensley
	 */
	function set_post_url($member_id, $post_url)
	{
		$this->db->where('id', $member_id)
			->update('players_of_the_week', array('forum_post_url' => $post_url));
	}
}


/* End of file potwmodel.php */
/* Location: ./application/models/potwmodel.php */