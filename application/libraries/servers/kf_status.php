<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Copyright (C) 2011 by Joseph Wensley
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *	THE SOFTWARE.
 */

/**
 * Contains functions for retrieving the status of a Source Dedicated Server(SRCDS)
 *
 * @author Joseph Wensley
 */
class KF_status {

	// Socket timeouts
	private $timeout				= 2;
	private $ping_timeout			= 1;
	private $enable_cache			= TRUE;
	private $cache_bad_responses	= TRUE;
	private $cache_time				= 30;
	
	
	// http://wiki.unrealadmin.org/UT3_query_protocol
	const PACKET_SIZE		= 1248;
	const SERVER_INFO		= "\x5C\x69\x6E\x66\x6F\x5C";
	const SERVER_PLAYERS	= "\x5C\x70\x6C\x61\x79\x65\x72\x73\x5C";
	
	function __construct()
	{
		log_message('debug', 'Unreal Status library loaded');
		
		// Get a reference to the CodeIgniter super object
		$this->CI =& get_instance();
		
		// Load the caching driver
		if ($this->enable_cache === TRUE)
		{
			$this->CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		}
	}
	
	// --------------------------------------------------------------------
	
	public function initialize($config = array())
	{
		foreach ($config as $key => $value)
		{
			if (isset($this->$key))
			{
				$this->$key = $value;
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Ping the server
	 *
	 * @param string $host The hostname/ip of the server
	 * @param string $port The port of the server
	 * @return bool
	 * @author Joseph Wensley
	 */
	public function ping($host, $port = '27015')
	{
		if (($cache = $this->read_cache($host, $port, __METHOD__)) !== FALSE)
		{
			if ($cache === 'FALSE') { return FALSE; } 
			return $cache;
		}
		
		// Open a socket to the server and set the timeout
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str);
		stream_set_timeout($socket, $this->ping_timeout);
		
		$start_time = microtime(TRUE);
		
		// Send the command to get the player list
		fwrite($socket, self::SERVER_INFO);
	
		$response = fread($socket, self::PACKET_SIZE); // Read a packet

		$end_time = microtime(TRUE);

		if (empty($response))
		{
			$this->write_cache($host, $port, __METHOD__, 'FALSE', 1);
			return FALSE; // No response
		}
		else
		{
			
			$ping = number_format(($end_time - $start_time) * 1000, 2); // Calculate the ping to the server in milliseconds
			$this->write_cache($host, $port, __METHOD__, $ping, 1);
			
			return $ping;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get the server info
	 *
	 * @param string $host The hostname/ip of the server
	 * @param string $port The port of the server
	 * @return mixed
	 * @author Joseph Wensley
	 */
	public function get_status($host, $port = '7707')
	{
		if (($cache = $this->read_cache($host, $port, __METHOD__)) !== FALSE)
		{
			if ($cache === 'FALSE') { return FALSE; } 
			return $cache;
		}
		
		$server = new StdClass();
	
		// Open a socket to the server and set the timeout
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str);
		stream_set_timeout($socket, $this->timeout);
		
		// Send the command to get the player list
		fwrite($socket, self::SERVER_INFO);
		
		$response = fread($socket, self::PACKET_SIZE);
		$response = trim($response, '\\');
		
		fclose($socket);
		
		if ( ! empty($response))
		{
			$info = explode('\\', $response);
			
			$c = count($info);
			for ($i = 0; $i <= $c; $i += 2)
			{
				if ($info[$i] === 'final')
				{
					break;
				}
				
				$server->{$info[$i]} = $info[$i+1];
			}
			
			/*
			$server->hostname 		= $info[];
			$server->mapname 		= $this->get_string($response);
			$server->game_dir		= $this->get_string($response);
			$server->game			= $this->get_string($response);
			$server->app_id			= $this->get_short_unsigned($response);
			$server->players 		= $this->get_byte($response);
			$server->max_players 	= $this->get_byte($response);
			$server->bots 			= $this->get_byte($response);
			$server->dedicated 		= $this->get_char($response);
			$server->os				= $this->get_char($response);
			$server->password		= $this->get_byte($response);
			$server->secure			= $this->get_byte($response);
			$server->version		= $this->get_string($response);
			*/
			
			$this->write_cache($host, $port, __METHOD__, $server);
			return $server;
		}
		
		$this->write_cache($host, $port, __METHOD__, 'FALSE');
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get a list of the players on the server
	 *
	 * @param string $host The hostname/ip of the server
	 * @param string $port The port of the server
	 * @param string $sort How we should sort the players
	 * @return mixed
	 * @author Joseph Wensley
	 */
	public function get_players($host, $port = '27015', $sort_type = NULL, $sort = NULL)
	{	
		
		if (($cache = $this->read_cache($host, $port, __METHOD__)) !== FALSE)
		{
			if ($cache === 'FALSE') { return FALSE; } 
			return $cache;
		}
		
		// Open a socket to the server
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str, $this->timeout);
		stream_set_timeout($socket, $this->timeout);
		
		// Send the command to get the player list
		fwrite($socket, self::SERVER_PLAYERS);
	
		$response = fread($socket, self::PACKET_SIZE);
		$response = trim($response, '\\');
		
		fclose($socket);
		
		if ( ! empty($response))
		{
			$players = new StdClass();
			
			$info = explode('\\', $response);

			if ($info[0] !== 'query_id')
			{
				$_players = array_slice($info, 0, -3);
				
				$c = count($_players) - 1;
				
				for ($i = 0; $i <= $c; $i += 8)
				{	
					$id = (int) substr($_players[$i], strpos($_players[$i], '_') + 1);
					
					$players->$id->name		= trim($_players[$i+1]);
					$players->$id->kills	= trim($_players[$i+3]);
					$players->$id->ping		= trim($_players[$i+5]);
					$players->$id->team		= trim($_players[$i+7]);
				}
				
				if ($sort_type)
				{
					$players = $this->sort_players($players, $sort_type, $sort);
				}
			}
			
			$this->write_cache($host, $port, __METHOD__, $players);
			return $players;
		}
		
		$this->write_cache($host, $port, __METHOD__, 'FALSE');
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Write server responses to the cache if enabled
	 *
	 * @param string $host 
	 * @param string $port 
	 * @param string $method 
	 * @param string $data 
	 * @param int $ttl 
	 * @return void
	 * @author Joseph Wensley
	 */
	private function write_cache($host, $port, $method, $data, $ttl = NULL)
	{
		if ($data !== 'FALSE' OR ($data === 'FALSE' AND $this->enable_cache !== FALSE))
		{
			if ($this->enable_cache === TRUE AND $this->cache_time > 0)
			{
				if ( ! $ttl) { $ttl = $this->cache_time; }
				$key = $host.$port.$method;

				$this->CI->cache->save($key, $data, $ttl);
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Read server responses from the cache if enabled
	 *
	 * @param string $host 
	 * @param string $port 
	 * @param string $method 
	 * @return void
	 * @author Joseph Wensley
	 */
	private function read_cache($host, $port, $method)
	{
		if ($this->enable_cache === TRUE AND $this->cache_time > 0)
		{
			$key = $host.$port.$method;
			
			return $this->CI->cache->get($key);
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sort Players
	 *
	 * Sorts players by kills or name in either descing or ascending order
	 * 
	 * @param string $players 
	 * @param string $sort_type 
	 * @param string $sort 
	 * @return object
	 * @author Joseph Wensley
	 */
	public function sort_players($players, $sort_type = 'kills', $sort = 'desc')
	{
		if ( ! $players){ return FALSE; }
		
		$players = (array)$players;
		
		switch ($sort_type)
		{
			case 'kills':
				switch ($sort) {
					case 'asc':
						usort($players, array(__CLASS__, 'sort_players_by_kills_asc'));
						break;
					default:
						usort($players, array(__CLASS__, 'sort_players_by_kills_desc'));
						break;
				}
				break;
			case 'name':
				switch ($sort) {
					case 'asc':
						usort($players, array(__CLASS__, 'sort_players_by_name_asc'));
						break;
					default:
						usort($players, array(__CLASS__, 'sort_players_by_name_desc'));
						break;
				}
				break;
				
			case 'time':
				switch ($sort) {
					case 'asc':
						usort($players, array(__CLASS__, 'sort_players_by_time_asc'));
						break;
					default:
						usort($players, array(__CLASS__, 'sort_players_by_time_desc'));
						break;
				}
				break;
		}
		
		return (object)$players;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sorting methods for use with usort()
	 */
	private function sort_players_by_kills_asc($a, $b)
	{
		return $a->kills - $b->kills;
	}

	private function sort_players_by_kills_desc($a, $b)
	{
		return $b->kills - $a->kills;
	}
	
	private function sort_players_by_name_asc($a, $b)
	{
		return strcasecmp($a->name, $b->name);
	}
	
	private function sort_players_by_name_desc($a, $b)
	{
		return strcasecmp($b->name, $a->name);
	}
	
	private function sort_players_by_time_asc($a, $b)
	{
		return $a->time - $b->time;
	}
	
	private function sort_players_by_time_desc($a, $b)
	{
		return $b->time - $a->time;
	}
}

/* End of file Srcds_status.php */
/* Location: ./sparks/scrds_status/Srcds_status.php */