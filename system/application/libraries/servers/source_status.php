<?php
DEFINE('PACKET_SIZE', '1248');

class Source_status
{
	private $timeout = 1;
	
	function ping_server($host, $port)
	{
		//Open a socket to the server and set the timeout
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str);
		socket_set_timeout($socket, $this->timeout);
		
		//Send the command to get the player list
		$command = "\xFF\xFF\xFF\xFF\x57";
		fwrite($socket, $command);
	
		$response = fread($socket, PACKET_SIZE);
		
		if(empty($response)){
			return false;
		}else{
			return true;
		}
		
	}
	
	function get_server_status($host, $port){
		//Open a socket to the server and set the timeout
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str);
		socket_set_timeout($socket, $this->timeout);
		
		//Send the command to get the player list
		$command = "\xFF\xFF\xFF\xFFTSource Engine Query\0";
		fwrite($socket, $command);
	
		$response = fread($socket, PACKET_SIZE);
		$response = substr($response, 6);

		if(!empty($response)){
			$server_info['hostname'] 	= $this->get_string($response);
			$server_info['map'] 		= $this->get_string($response);
			$this->get_string($response);
			$this->get_string($response);
			$this->get_short_unsigned($response);
			$server_info['players'] 	= $this->get_byte($response);
			$server_info['max_players'] = $this->get_byte($response);
			
			return $server_info;
		}
		
		return false;
	}
	
	//Get a list of players on the server with their kills and connection time
	function get_server_players($host, $port)
	{		
		//Open a socket to the server
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str, $this->timeout);
		socket_set_timeout($socket, $this->timeout);
		
		//Send the Challenge command
		$command = "\xFF\xFF\xFF\xFF\x57";
		fwrite($socket, $command);
		
		//Discard the junk from the response and read the challenge number
		fread($socket, 5);
		$challenge = fread($socket, 4);
		
		//Send the command to get the player list
		$command = "\xFF\xFF\xFF\xFF\x55".$challenge;
		fwrite($socket, $command);
	
		$response = fread($socket, 1248);
		$response = substr($response, 6);
		
		fclose($socket);
		
		$players = array();
		if(ord(substr($response, 0, 1)) == 0){
			while($response !== false){
				$id = $this->get_byte($response);
				
				$players[$id]['name'] = $this->get_string($response);
				$players[$id]['kills'] = $this->get_long($response);
				$players[$id]['time'] = $this->get_float($response);
			}
		}
		
		function sort_by_kills($a, $b)
		{
			if($a['kills'] == $b['kills']){ return 0;}
			if($a['kills'] > $b['kills']){
				return -1;
			}else{
				return 1;
			}
		}
		
		usort($players, 'sort_by_kills');
		
		return $players;
	}
	
	private function get_byte(&$string)
	{
		$data = substr($string, 0, 1);
		$string = substr($string, 1);
		$data = unpack('Cvalue', $data);

		return $data['value'];
	}

	private function get_short_unsigned(&$string)
	{
		$data = substr($string, 0, 2);
		$string = substr($string, 2);
		$data = unpack('nvalue', $data);

		return $data['value'];
	}

	private function get_short_signed(&$string)
	{
		$data = substr($string, 0, 2);
		$string = substr($string, 2);
		$data = unpack('svalue', $data);

		return $data['value'];
	}

	private function get_long(&$string)
	{
		$data = substr($string, 0, 4);
		$string = substr($string, 4);
		$data = unpack('Vvalue', $data);

		return $data['value'];
	}

	private function get_float(&$string)
	{
		$data = substr($string, 0, 4);
		$string = substr($string, 4);
		$array = unpack("fvalue", $data);

		return $array['value'];
	}

	private function get_string(&$string)
	{
		$data = "";
		$byte = substr($string, 0, 1);
		$string = substr($string, 1);

		while (ord($byte) != "0"){
			$data .= $byte;
			$byte = substr($string, 0, 1);
			$string = substr($string, 1);
		}

		return $data;
	}
}

?>