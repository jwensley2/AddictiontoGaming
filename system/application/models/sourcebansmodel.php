<?php

/**
 * Contains functions to add/remove/delete Donors to/from the Sourcebans database
 *
 * @author Joseph Wensley
 */
class Sourcebansmodel extends Model
{
	
	function Sourcebansmodel()
	{
		parent::Model();
		$this->sm_db = $this->load->database('sourcemod', TRUE);
	}
	
	/**
	 * Add a donor to the sourcebans admins table
	 *
	 * @param string $username 
	 * @param string $steam_id 
	 * @param string $email 
	 * @return void
	 * @author Joseph Wensley
	 */
	function add_donor($username, $steam_id, $email)
	{
		$email = trim($email);
		$username = trim($username);
		if(strlen($username > 64)){ $username = substr($username, 0, 64); }
	
		// Check if user is already in the database
		$query = $this->sm_db->get_where('sb_admins', array('authid' => $steam_id));
		
		// If the user doesn't exist add them
		if($query->num_rows() == 0){
			$password = $this->hash_password('donor');


			// Create an account for the donor
			$this->sm_db->set('user', $username);
			$this->sm_db->set('authid', $steam_id);
			$this->sm_db->set('email', $email);
			$this->sm_db->set('password', $password);
			$this->sm_db->set('srv_group', 'Donor');
			$this->sm_db->set('gid', -1);
			$this->sm_db->set('validate', 0);

			$this->sm_db->insert('sb_admins');
			
			$admin_id = $this->sm_db->insert_id();
			
			// Set access to the "All Servers" (id #2) group
			$this->sm_db->set('admin_id', $admin_id);
			$this->sm_db->set('group_id', 4);
			$this->sm_db->set('srv_group_id', 2);
			$this->sm_db->set('server_id', -1);
			
			$this->sm_db->insert('sb_admins_servers_groups');
			
			// SEND AN EMAIL SAYING THE USER WAS AUTOMATICALLY ADDED
			$this->load->helper('email');
			$to = 'addictiontogaming@gmail.com';
			$subject = 'Donor '.$username.' was added to Sourcebans';
			$message = "Donor was automatically added to Sourcebans
			Username: $username
			Steam ID:  $steam_id
			Email: $email";
			
			send_email($to, $subject, $message);
			
		}else{
			$row = $query->row();
			// If the user doesn't have a group add them to the Donor group
			if($row->srv_group == '' || $row->srv_group == 'PotW'){
				$this->sm_db->where('authid', $steam_id);
				$this->sm_db->update('sb_admins', array('srv_group' => 'Donor'));
			}
		}
	}
	
	/**
	 * Remove a donors access but leave them in the admin table
	 *
	 * @param string $steam_id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function remove_donor($steam_id)
	{
		// Get the user's information
		$query = $this->sm_db->get_where('sb_admins', array('authid' => $steam_id));
		$row = $query->row();
		
		// If the user is in the donor group set their group to nothing
		if($row->srv_group == 'Donor'){
			$this->sm_db->where('authid', $steam_id);
			$this->sm_db->update('sb_admins', array('srv_group' => ''));
		}
	}
	
	/**
	 * Delete a donor from the sourcebans admin table
	 *
	 * @param string $steam_id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function delete_donor($steam_id)
	{
		// Get the user's information
		$query = $this->sm_db->get_where('sb_admins', array('authid' => $steam_id));
		$row = $query->row();
		
		// If the user is in the donor group delete them
		if($row->srv_group == 'Donor' || $row->srv_group == ''){
			$this->sm_db->where('authid', $steam_id);
			$this->sm_db->delete('sb_admins');
		}
	}
	
	/**
	 * Generate password hash
	 *
	 * @param string $password 
	 * @return string
	 * @author Joseph Wensley
	 */
	private function hash_password($password)
	{
		$salt = 'SourceBans';
		return sha1(sha1($password.$salt));
	}
}

?>