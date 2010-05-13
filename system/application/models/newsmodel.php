<?php

class Newsmodel extends Model
{
	function Newsmodel()
	{
		//Call the Model constructor
		parent::Model();
		$this->load->database('default');
	}
	
	/**
	 * Get the newest posts
	 *
	 * @param string $limit 
	 * @return object
	 * @author Joseph Wensley
	 */
	function get_latest_news($limit = 5)
	{
		$this->db->select('*, UNIX_TIMESTAMP(date) AS date, UNIX_TIMESTAMP(modified) AS modified');
		$this->db->limit($limit);
		$this->db->orderby('date', 'desc');
		$query = $this->db->get('news');
		return $query->result();
	}
	
	/**
	 * Get a list of all the months that contain posts
	 *
	 * @return object
	 * @author Joseph Wensley
	 */
	function get_archive_months()
	{
		$this->db->select('UNIX_TIMESTAMP(date) AS date');
		$this->db->group_by('EXTRACT(YEAR_MONTH FROM date)');
		$this->db->orderby('date', 'desc');
		$query = $this->db->get('news');
		
		return $query->result();
	}
	
	/**
	 * Get all posts where the date is in $month of $year
	 *
	 * @param string $month 
	 * @param string $year 
	 * @return object
	 * @author Joseph Wensley
	 */
	function get_posts_by_month($month, $year)
	{
		$this->db->select('*, UNIX_TIMESTAMP(date) AS date, UNIX_TIMESTAMP(modified) AS modified');
		$this->db->where('YEAR(date)', $year);
		$this->db->where('MONTH(date)', $month);
		$query = $this->db->get('news');
		
		return $query->result();
	}
	
	/**
	 * Get the news item with the id of $id
	 *
	 * @param string $id 
	 * @return object
	 * @author Joseph Wensley
	 */
	function get_news_item($id)
	{
		$query = $this->db->get_where('news', array('id' => $id));
		return $query->row();
	}
	
	function edit_news_item($id)
	{			
		$data['title']			= $this->input->post('title');
		$data['content']		= $this->input->post('content');
		$data['edit_user_id']	= $this->phpbb_lib->getUserInfo('user_id');
		$this->db->set('modified', 'FROM_UNIXTIME('.time().')', FALSE);
		$this->db->where('id', $id);
		$this->db->update('news', $data);
	}
	
	/**
	 * Add a news item to the database
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	function submit_news_item()
	{			
		$data['title']		= $this->input->post('title');
		$data['content']	= $this->input->post('content');
		$data['user_id']	= $this->phpbb_lib->getUserInfo('user_id');
		$this->db->set('date', 'FROM_UNIXTIME('.time().')', FALSE);
		$this->db->set('modified', 'FROM_UNIXTIME('.time().')', FALSE);
		$this->db->insert('news', $data);
	}
	
	/**
	 * Delete the news item that has id = $id
	 *
	 * @param string $id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function delete_news_item($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('news');
	}
}

?>