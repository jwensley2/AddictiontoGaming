<?php

class Ventrilo_status
{
	
	var $status_prog	= './assets/ventrilo/ventrilo_status';		// Location of the status program
	
	function Ventrilo_status()
	{
		if(stripos(php_uname('s'), 'Windows') !== FALSE){
			$this->status_prog = realpath($this->status_prog.'.exe');
		}
	}
	
	/*
	* Gets basic server info (hostname, users and max_users) and returns them in an array
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
			$server_info['hostname'] = substr($this->get_value('NAME:', &$data), 1, -1);
			$server_info['players'] = $this->get_value('CLIENTCOUNT:', &$data);
			$server_info['max_players'] = $this->get_value('MAXCLIENTS:', &$data);
			
			return $server_info;
		}
		return false;
	}
	
	function get_full_server_status($ip, $port)
	{
		$cmd = $this->status_prog." -t$ip:$port -c2 -a1";
		$pipe = popen($cmd, 'r');
		
		$data = false;
		
		while(!feof($pipe)){
			$data .= fread($pipe, 1);
		}
		
		if(!$this->get_value('ERROR:', &$data)){
			$server_info['hostname'] = substr($this->get_value('NAME:', &$data), 1, -1);
			$server_info['players'] = $this->get_value('CLIENTCOUNT:', &$data);
			$server_info['max_players'] = $this->get_value('MAXCLIENTS:', &$data);

			while($this->get_value('CHANNEL:', &$data, FALSE)){
				$channel = $this->get_value('CHANNEL:', &$data);
				$server_info['channels'][] = $this->get_channel_info($channel);
			}
			$server_info['channels'] = $this->format_channel_array($server_info['channels']);
			
			while($this->get_value('CLIENT:', &$data, FALSE)){
				$client = $this->get_value('CLIENT:', &$data);
				$server_info['clients'][] = $this->get_client_info($client);
			}
			$server_info['player_list'] = $this->format_client_array($server_info['clients']);
			
			return $server_info;
		}
		return false;
	}
	
	/*
	* Searches for $key in $data and returns the data belonging to it
	* If $clean is not set to FALSE the $key and its value will be removed from $data
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
	
	private function get_channel_info($channel)
	{
		$fields = explode(',', $channel);
		
		foreach($fields as $field){
			$f = explode('=', $field);
			$props[$f[0]] = $f[1];
		}
		
		return $props;
	}
	
	private function get_client_info($client)
	{
		$fields = explode(',', $client);
		
		foreach($fields as $field){
			$f = explode('=', $field);
			$props[$f[0]] = $f[1];
		}
		
		return $props;
	}
	
	private function format_channel_array($channels)
	{
		foreach($channels AS $channel){
			$name = $channel['NAME'];
			$cid = $channel['CID'];
			$pid = $channel['PID'];
			
			if($pid == 0){
				$formatted_channels[$cid]['name'] = $name;
			}else{
				$parent =& $this->find_parent_channel($pid, $formatted_channels, 0);
				$parent['subchannels'][$cid]['name'] = $name;
			}
		}
		
		return $formatted_channels;
	}
	
	private function format_client_array($clients)
	{
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
	
	private function &find_parent_channel($pid, &$channels, $depth)
	{	
		foreach($channels AS $key => &$channel){
			if($key == $pid){
				return $channel;
			}elseif($channel['subchannels']){
				$parent =& $this->find_parent_channel($pid, $channel['subchannels'], ++$depth);
				if(is_array($parent)){ return $parent; }
			}
		}
		return FALSE;
	}
}

?>