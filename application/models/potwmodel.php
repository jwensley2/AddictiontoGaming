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
		list($month, $day, $year) = explode('/', $start_date);
		$unix_date = mktime(0, 0, 0, (int) $month, (int) $day, (int) $year);
		
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('real_name', $this->input->post('real_name'));
		$this->db->set('steam_id', $this->input->post('steam_id'));
		$this->db->set('forum_post_text', $this->input->post('forum_post_text'));
		$this->db->set('start_date', 'FROM_UNIXTIME('.$unix_date.')', FALSE);
		
		if ($this->db->insert('players_of_the_week'))
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
		
		$this->db->select('id');
		$this->db->where("`start_date` < FROM_UNIXTIME($now)", NULL, FALSE);
		$this->db->order_by('start_date', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('players_of_the_week');
		$new_member = $query->row();
		
		if ($current->id != $new_member->id)
		{
			$this->db->where('current', 1);
			$this->db->update('players_of_the_week', array('current' => 0));
			
			$this->db->where('id', $new_member->id);
			$this->db->update('players_of_the_week', array('current' => 1));
			
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
		
		$this->db->select('name, UNIX_TIMESTAMP(start_date) as start_date');
		$this->db->where("`start_date` > FROM_UNIXTIME($now)", NULL, FALSE);
		$query = $this->db->get('players_of_the_week');
		
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
		$this->db->where('id', $member_id);
		$this->db->update('players_of_the_week', array('forum_post_url' => $post_url));
	}
}


/* End of file potwmodel.php */
/* Location: ./application/models/potwmodel.php */