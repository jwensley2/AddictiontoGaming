<?php

class Serversmodel extends Model
{
	private $update_delay = 20; // Time between status updates in seconds
	private $full_update_delay = 60; // Time between full updates in seconds
	
	function Serversmodel()
	{
		//Call the Model constructor
		parent::Model();
		$this->load->database('default');
		$this->load->library(array('servers/source_status', 'servers/ventrilo_status'));
	}
	
	function list_servers($order = null){
		if(!$order){
			$order = 'game, players DESC';
		}
		
		$this->db->select('*, UNIX_TIMESTAMP(updated) AS updated, UNIX_TIMESTAMP(full_updated) AS full_updated');
		$this->db->order_by($order);
		$query = $this->db->get('servers');
		$servers = $query->result();
		
		foreach($servers as $server){
			$data = array();
			
			if(in_array($server->game, array('tf2', 'l4d', 'l4d2'))){
				$this->get_source_server_status($server);
			}elseif($server->game == 'vent'){
				$this->get_ventrilo_server_status($server);
			}else{
				if($server->full_updated < (time() - $this->full_update_delay)){
					// Set the data to update in the DB
					$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
					$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', false);
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
			
		}
		
		return $servers;
	}
	
	
	//Get the status of a source server and update the database
	private function get_source_server_status(&$server){
		if($server->full_updated < (time() - $this->full_update_delay)){
			$server_info = $this->source_status->get_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', false);
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
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', false);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
			
			$this->db->where('id', $server->id);
			$this->db->update('servers', $data);
		}elseif($server->updated < (time() - $this->update_delay)){
			$server_info = $this->source_status->get_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
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
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', false);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
		}
	}
	
	//Get the status of a ventrilo server and update the database
	private function get_ventrilo_server_status(&$server)
	{
		if($server->full_updated < (time() - $this->full_update_delay)){
			$server_info = $this->ventrilo_status->get_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.time().')', false);
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
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', false);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
			
			$this->db->where('id', $server->id);
			$this->db->update('servers', $data);
		}elseif($server->updated < (time() - $this->update_delay)){
			$server_info = $this->ventrilo_status->get_server_status($server->ip, $server->port);
			
			if($server_info){
				// Set the data to update in the DB
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
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
				$this->db->set('updated', 'FROM_UNIXTIME('.time().')', false);
				$this->db->set('full_updated', 'FROM_UNIXTIME('.(time() - ($this->update_delay / 2)).')', false);
				$server->status	= 0;
				$data['status']	= $server->status;
			}
		}
	}
}

?>