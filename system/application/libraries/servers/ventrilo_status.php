<?php

function dump($data)
{
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}

class Ventrilo_status
{
	
	var $status_prog	= './assets/ventrilo/ventrilo_status';		// Location of the status program
	
	function Ventrilo_status()
	{
		if(stripos(php_uname('s'), 'Windows') !== FALSE){
			$this->status_prog = realpath($this->status_prog.'.exe');
		}
	}
	
	function get_server_status($ip, $port)
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
			
			return $server_info;
		}
		return false;
	}
	
	
	function get_value($key, $data)
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
		$data = substr_replace($data, "", $key_pos, $break_pos + 1);
				
		return $value;
	}
}

?>