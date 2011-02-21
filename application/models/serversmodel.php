<?php

class Serversmodel extends CI_Model
{
	private $update_delay = 15; // Time between status updates in seconds
	private $full_update_delay = 30; // Time between full updates in seconds
	
	function __construct()
	{
		//Call the Model constructor
		parent::__construct();
		$this->load->database('default');
		$this->load->helper('file');
		$this->load->library(array('servers/source_status', 'servers/ventrilo_status'));
	}
	
	/**
	 * Get a list of the servers without grabbing live data
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	function quick_list_servers($game = null)
	{
		$this->db->order_by('game, ip, port');
		
		if($game){
			$query = $this->db->get_where('servers', array('game' => $game));
		}else{
			$query = $this->db->get('servers');	
		}
		
		return $query->result();
	}
	
	function add_server()
	{
		$data['name']	= $this->input->post('name');
		$data['ip']		= $this->input->post('ip');
		$data['port']	= $this->input->post('port');
		$data['game']	= $this->input->post('game');
		
		$this->db->insert('servers', $data);
	}
	
	function edit_server($id)
	{
		$data['name']	= $this->input->post('name');
		$data['ip']		= $this->input->post('ip');
		$data['port']	= $this->input->post('port');
		$data['game']	= $this->input->post('game');
		
		$this->db->where('id', $id);
		$this->db->update('servers', $data);
	}
	
	/**
	 * Delete a server from the DB
	 *
	 * @param string $id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function delete_server($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('servers');
	}
	
	/**
	 * List servers and grab live data if the server info is out of date
	 *
	 * @param string $order 
	 * @return void
	 * @author Joseph Wensley
	 */
	function list_servers($order = null)
	{
		if(!$order){
			$order = 'game, players DESC';
		}
		
		$this->db->select('*, UNIX_TIMESTAMP(updated) AS updated, UNIX_TIMESTAMP(full_updated) AS full_updated');
		$this->db->order_by($order);
		$query = $this->db->get('servers');
		$servers = $query->result();
		
		
		foreach($servers as $server){
			$query = $this->db->get_where('players', array('server_id' => $server->id));
			$server->player_list = $query->result();
			
			$data = array();
			
			if(in_array($server->game, array('tf2', 'l4d', 'l4d2', 'css'))){
				$this->get_source_server_status($server);
			}elseif($server->game == 'vent'){
				$this->get_ventrilo_server_status($server);
			}else{
				if($server->full_updated < (time() - $this->full_update_delay)){
					// Set the data to update in the DB
					$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
					$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', FALSE);
					$data['status'] 		= 2;
					$data['players']		= 0;

					// Update the data from the db with the fresh data
					$server->status			= 2;
					$server->players		= 0;
					
					$this->db->where('id', $server->id);
					$this->db->update('servers', $data);
				}
				$popup = $this->load->view('servers/popups/other', $server, TRUE);
				write_file('./assets/server_popups/'.$server->id.'.html', $popup);
			}
			
		}
		
		return $servers;
	}
	
	/**
	 * Get the info for a specific server and update it with live data if needed
	 *
	 * @param string $server_id 
	 * @return void
	 * @author Joseph Wensley
	 */
	function get_server_info($server_id)
	{
		$this->db->select('*, UNIX_TIMESTAMP(updated) AS updated, UNIX_TIMESTAMP(full_updated) AS full_updated');
		$query = $this->db->get_where('servers', array('id' => $server_id));
		$server_info = $query->row();
		
		$query = $this->db->get_where('players', array('server_id' => $server_id));
		$server_info->player_list = $query->result();
		
		if(in_array($server_info->game, array('tf2', 'l4d', 'l4d2', 'css'))){
			$this->get_source_server_status($server_info);
		}elseif($server_info->game == 'vent'){
			$this->get_ventrilo_server_status($server_info);
		}else{
			if($server->full_updated < (time() - $this->full_update_delay)){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$data['status'] 		= 2;
				$data['players']		= 0;
				$data['max_players']	= 0;

				// Update the data from the db with the fresh data
				$server->status			= 2;
				$server->players		= 0;
				$server->max_players	= 0;
				
				$this->db->where('id', $server->id);
				$this->db->update('servers', $data);
			}
		}
		
		
		return $server_info;
	}
	
	/**
	 * Get the status of a Source server and update the DB
	 *
	 * @param string $server 
	 * @return void
	 * @author Joseph Wensley
	 */
	private function get_source_server_status(&$server){
		if($server->full_updated < (time() - $this->full_update_delay)){
			
			$server_info = $this->source_status->get_server_status($server->ip, $server->port); 
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$data['status'] 		= 1;
				$data['hostname']		= $server_info['hostname'];
				$data['players']		= $server_info['players'];
				$data['max_players']	= $server_info['max_players'];
				$data['mapname']		= $server_info['mapname'];
				
				// Update the data from the db with the fresh data
				$server->status			= 1;
				$server->hostname		= $server_info['hostname'];
				$server->players		= $server_info['players'];
				$server->max_players	= $server_info['max_players'];
				$server->mapname		= $server_info['mapname'];
				$server->player_list	= $this->source_status->get_server_players($server->ip, $server->port);
			}else{
				$this->db->delete('players', array('server_id' => $server->id));
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', FALSE);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
			
			$this->db->where('id', $server->id);
			$this->db->update('servers', $data);
			
			$this->db->delete('players', array('server_id' => $server->id));
			if($server->player_list){
				foreach($server->player_list AS $player){
					$player->server_id = $server->id;
					$this->db->insert('players', $player);	
				}
			}
			
		$popup = $this->load->view('servers/popups/source', $server, TRUE);
		write_file('./system/cache/popups/'.$server->id.'.html', $popup);
			
		}elseif($server->updated < (time() - $this->update_delay)){
			$server_info = $this->source_status->get_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$data['status'] 		= 1;
				$data['hostname']		= $server_info['hostname'];
				$data['players']		= $server_info['players'];
				$data['max_players']	= $server_info['max_players'];
				
				// Update the data from the db with the fresh data
				$server->status			= 1;
				$server->hostname		= $server_info['hostname'];
				$server->players		= $server_info['players'];
				$server->max_players	= $server_info['max_players'];
				$server->mapname		= $server_info['mapname'];
				
			}else{
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', FALSE);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
			
			$this->db->where('id', $server->id);
			$this->db->update('servers', $data);
			
			$popup = $this->load->view('servers/popups/source', $server, TRUE);
			write_file('./assets/server_popups/'.$server->id.'.html', $popup);
		}
	}
	
	/**
	 * Get the status of a Ventrilo server and update the Database
	 *
	 * @param string $server 
	 * @return void
	 * @author Joseph Wensley
	 */
	private function get_ventrilo_server_status(&$server)
	{
		$server->channels = unserialize($server->channels);
		
		if($server->full_updated < (time() - $this->full_update_delay)){
			$server_info = $this->ventrilo_status->get_full_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$data['status'] 		= 1;
				$data['hostname']		= $server_info['hostname'];
				$data['players']		= $server_info['players'];
				$data['max_players']	= $server_info['max_players'];
				$data['channels']		= serialize($server_info['channels']);
				
				// Update the data from the db with the fresh data
				$server->status			= 1;
				$server->hostname		= $server_info['hostname'];
				$server->players		= $server_info['players'];
				$server->max_players	= $server_info['max_players'];
				$server->channels		= $server_info['channels'];
				$server->player_list	= $server_info['player_list'];
				
			}else{
				$this->db->delete('players', array('server_id' => $server->id));
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', FALSE);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
			
			$this->db->where('id', $server->id);
			$this->db->update('servers', $data);
			
			if($server->player_list){
				$this->db->delete('players', array('server_id' => $server->id));
				foreach($server->player_list AS $player){
					$player->server_id = $server->id;
					$this->db->insert('players', $player);	
				}
			}
			
			$popup = $this->load->view('servers/popups/ventrilo', $server, TRUE);
			write_file('./assets/server_popups/'.$server->id.'.html', $popup);
			
		}elseif($server->updated < (time() - $this->update_delay)){
			$server_info = $this->ventrilo_status->get_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$data['status'] 		= 1;
				$data['hostname']		= $server_info['hostname'];
				$data['players']		= $server_info['players'];
				$data['max_players']	= $server_info['max_players'];
				
				// Update the data from the db with the fresh data
				$server->status			= 1;
				$server->hostname		= $server_info['hostname'];
				$server->players		= $server_info['players'];
				$server->max_players	= $server_info['max_players'];
				
			}else{
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', FALSE);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', FALSE);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
			
			$this->db->where('id', $server->id);
			$this->db->update('servers', $data);
			
			$popup = $this->load->view('servers/popups/ventrilo', $server, TRUE);
			write_file('./assets/server_popups/'.$server->id.'.html', $popup);
		}
	}
}

?>