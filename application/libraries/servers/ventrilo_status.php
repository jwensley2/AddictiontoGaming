<?php

class Ventrilo_status
{
	
	var $status_prog	= './assets/ventrilo/ventrilo_status';	// Location of the status program without file extension
	
	function __construct()
	{
		// If using Windows add .exe to the program path and get the realpath
		if(stripos(php_uname('s'), 'Windows') !== FALSE){
			$this->status_prog = realpath($this->status_prog.'.exe');
		}
	}
	
	/**
	 * Get the hostname, # of users and max # of users
	 *
	 * @param string $ip The server IP
	 * @param string $port The server port
	 * @return bool/array
	 * @author Joseph Wensley
	 */
	function get_server_status($ip, $port)
	{
		$cmd = $this->status_prog." -t$ip:$port -c1 -a1";
		$pipe = popen($cmd, 'r');
		
		$data = false;
		
		while(!feof($pipe)){
			$data .= fread($pipe, 1);
		}
		
		if(!$this->get_value('ERROR:', &$data)){
			$server_info['hostname'] = $this->get_value('NAME:', &$data);
			$server_info['players'] = $this->get_value('CLIENTCOUNT:', &$data);
			$server_info['max_players'] = $this->get_value('MAXCLIENTS:', &$data);
			
			return $server_info;
		}
		
		return false;
	}
	
	/**
	 * Get the hostname, # of users and max # of users
	 * Also get the Channel and User lists
	 *
	 * @param string $ip The server IP
	 * @param string $port The server port
	 * @return bool/array
	 * @author Joseph Wensley
	 */
	function get_full_server_status($ip, $port)
	{
		$cmd = $this->status_prog." -t$ip:$port -c2 -a1";
		$pipe = popen($cmd, 'r');
		
		$data = false;
		
		while(!feof($pipe)){
			$data .= fread($pipe, 1);
		}
		
		if(!$this->get_value('ERROR:', &$data)){
			$server_info['hostname'] = $this->get_value('NAME:', &$data);
			$server_info['players'] = $this->get_value('CLIENTCOUNT:', &$data);
			$server_info['max_players'] = $this->get_value('MAXCLIENTS:', &$data);

			while($this->get_value('CHANNEL:', &$data, FALSE)){
				$channel = $this->get_value('CHANNEL:', &$data);
				$server_info['channels'][] = $this->get_channel_properties($channel);
			}
			$server_info['channels'] = $this->format_channel_array($server_info['channels']);
			
			while($this->get_value('CLIENT:', &$data, FALSE)){
				$client = $this->get_value('CLIENT:', &$data);
				$server_info['clients'][] = $this->get_client_properties($client);
			}
			$server_info['player_list'] = $this->format_client_array($server_info['clients']);
			
			return $server_info;
		}
		return false;
	}
	
	/**
	 * Find the $key inside the $data and return its value
	 *
	 * @param string $key The key to search for
	 * @param string $data The data to search
	 * @param string $clean If TRUE then clean the key and its value from the data
	 * @return string
	 * @author Joseph Wensley
	 */
	private function get_value($key, $data, $clean = TRUE)
	{
		$key_length = strlen($key) + 1;					//Get length of the key
		$key_pos = strpos($data, $key);					//Find the start of the key
		$break_pos = strpos($data, "\n", $key_pos);		//Find the next newline


		if($key_pos === FALSE){
			return FALSE;
		}
		
		$start = $key_pos + $key_length;
		$length = ($break_pos - $key_length) - $key_pos;
		
		//Get the value associated with the key
		$value = substr($data, $start, $length);
		
		//Delete the key and value to make further searching easier
		//If clean is FALSE leave the data intact
		if($clean !== FALSE){
			$replace_length = $key_length + $length + 1;
			$data = substr_replace($data, "", $key_pos, $replace_length);
		}
		
		return $value;
	}
	
	/**
	 * Takes a string of channel info and splits it into an array of channel properties
	 *
	 * @param string $channel The channel info
	 * @return array
	 * @author Joseph Wensley
	 */
	private function get_channel_properties($channel)
	{
		// Split the info into key=value pairs
		$pairs = explode(',', $channel);
		
		
		foreach($pairs as $pair){
			$p = explode('=', $pair);
			$properties[$p[0]] = $p[1];
		}
		
		return $properties;
	}
	
	/**
	 * Takes a string of client info and splits it into an array
	 *
	 * @param string $client The client info
	 * @return array
	 * @author Joseph Wensley
	 */
	private function get_client_properties($client)
	{
		// Split the info into key=value pairs
		$pairs = explode(',', $client);
		
		foreach($pairs as $pair){
			$p = explode('=', $pair);
			$properties[$p[0]] = $p[1];
		}
		
		return $properties;
	}
	
	
	/**
	 * Takes an array of channels and nests sub-channels into their parents
	 *
	 * @param array $channels 
	 * @return array
	 * @author Joseph Wensley
	 */
	private function format_channel_array($channels)
	{
		foreach($channels AS $channel){
			$name = $channel['NAME'];
			$cid = $channel['CID'];
			$pid = $channel['PID'];
			
			if($pid == 0){
				// If the pid is 0 then the channel has no parent
				$formatted_channels[$cid]['name'] = $name;
			}else{
				// Find the parent of the channel and add it onto the parents sub-channel list
				$parent =& $this->find_parent_channel($pid, $formatted_channels);
				$parent['subchannels'][$cid]['name'] = $name;
			}
		}
		
		return $formatted_channels;
	}
	
	/**
	 * Takes an array of clients and formats them into an object
	 *
	 * @param array $clients 
	 * @return void
	 * @author Joseph Wensley
	 */
	private function format_client_array($clients)
	{
		if(!is_array($clients)){ return null; }
		foreach($clients AS $client){
			$formatted_clients[] = (object) array(
				'name'		=> $client['NAME'],
				'channel'	=> $client['CID'],
				'admin'		=> $client['ADMIN'],
				'ping'		=> $client['PING'],
			);
		}
		return $formatted_clients;
	}
	
	/**
	 * Finds the parent of a channel with $pid
	 *
	 * @author Joseph Wensley
	 */
	private function &find_parent_channel($pid, array &$channels)
	{	
		foreach($channels AS $key => &$channel){
			if($key == $pid){
				return $channel;
			}elseif($channel['subchannels']){
				$parent =& $this->find_parent_channel($pid, $channel['subchannels']);
				if(is_array($parent)){ return $parent; }
			}
		}
		return FALSE;
	}
}

?>