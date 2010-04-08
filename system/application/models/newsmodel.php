<?php

class Newsmodel extends Model
{
	function Newsmodel()
	{
		//Call the Model constructor
		parent::Model();
		$this->load->database('default');
	}
	
	function get_latest_news()
	{
		$this->db->select('*, UNIX_TIMESTAMP(date) AS date, UNIX_TIMESTAMP(modified) AS modified');
		$this->db->limit('10');
		$this->db->orderby('date', 'desc');
		$query = $this->db->get('news');
		return $query->result();
	}
	
	function get_news_item($id)
	{
		$query = $this->db->get_where('news', array('id' => $id));
		return $query->row();
	}
	
	function edit_news_item($id)
	{			
		$data['title']			= $this->input->post('title');
		$data['content']		= $this->input->post('content');
		$data['edit_user_id']	= $this->phpbb->getUserInfo('user_id');
		$this->db->set('modified', 'FROM_UNIXTIME('.time().')', FALSE);
		$this->db->where('id', $id);
		$this->db->update('news', $data);
	}
	
	function submit_news_item()
	{			
		$data['title']			= $this->input->post('title');
		$data['content']		= $this->input->post('content');
		$data['user_id']	= $this->phpbb->getUserInfo('user_id');
		$this->db->set('date', 'FROM_UNIXTIME('.time().')', FALSE);
		$this->db->set('modified', 'FROM_UNIXTIME('.time().')', FALSE);
		$this->db->insert('news', $data);
	}
	
	function delete_news_item($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('news');
	}
}

?>