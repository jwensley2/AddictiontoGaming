<?php

class Potwmodel extends Model
{
	function Potwmodel()
	{
		//Call the Model constructor
		parent::Model();
		$this->load->database('default');
	}
	
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
		$unix_date = mktime(0, 0, 0, $month, $day, $year);
		
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('real_name', $this->input->post('real_name'));
		$this->db->set('steam_id', $this->input->post('steam_id'));
		$this->db->set('forum_post_text', $this->input->post('forum_post_text'));
		$this->db->set('start_date', 'FROM_UNIXTIME('.$unix_date.')', FALSE);
		
		if($this->db->insert('players_of_the_week')){
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
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
		
		if($current->id != $new_member->id){
			$this->db->where('current', 1);
			$this->db->update('players_of_the_week', array('current' => 0));
			
			$this->db->where('id', $new_member->id);
			$this->db->update('players_of_the_week', array('current' => 1));
			
			return TRUE;
		}
		return FALSE;
	}
	
	function set_post_url($member_id, $post_url)
	{
		$this->db->where('id', $member_id);
		$this->db->update('players_of_the_week', array('forum_post_url' => $post_url));
	}
}

?>