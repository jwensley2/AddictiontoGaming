<?php

class Twitter_lib
{
	protected $cache_path = './system/cache/twitter/';
	protected $cache_time = 5; // Cache time in minutes
	
	private $authenticated = false;
	private $username;
	private $password;
	
	function auth($username, $password = null)
	{
		$this->username = $username;
		$this->password = $password;
	}
	
	private function check_auth()
	{
		if($password){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'http://api.twitter.com/1/statuses/user_timeline/'.$this->username.'.json');
			curl_setopt($curl, CURLOPT_HTTPAUTH, $this->username.':'.$this->password);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			if(curl_exec($curl)){
				$this->authenticated = true;
			}
		}
	}
	
	function user_timeline($count = 10)
	{
		$cache_file = $this->cache_path.$this->username.'_timeline.cache';
		
		if($this->check_cache($cache_file)){
			$timeline = $this->read_cache($cache_file);
		}
		
		if(!$timeline || count($timeline) > $count){
			$url = 'http://api.twitter.com/1/statuses/user_timeline/'.$this->username.'.json?count='.$count;
			$timeline = $this->curl($url);
			$this->write_cache($cache_file, $timeline);
		}
		return $timeline;
	}
	
	function relative_time($time)
	{
		$now = time();
		$time = strtotime($time);
		
		$diff = $now - $time;
		switch ($diff) {
			case ($diff < 60):
				$relative = "Less than a minute ago";
				break;
			case ($diff < 3600):
				$relative = round($diff / 60) == 1 ? "1 minute ago" : round($diff / 60)." minutes ago";
				break;
			case ($diff == 3600):
				$relative = "1 hour ago";
				break;
			case ($diff < 86400):
				$relative = round($diff / 3600) == 1 ? "1 hour ago" : round($diff / 60)." hours ago";
				break;
			case ($diff < 604800):
				$relative = round($diff / 86400) == 1 ? "1 day ago" : round($diff / 86400)." days ago";
				break;
			default:
				$relative = date('g:i A M jS', $time);
				break;
		}
		return $relative;
	}
	
	private function check_cache($file)
	{
		if(file_exists($file)){
			$modified = filemtime($file);
			if($modified > (time() - ($this->cache_time * 60))){
				return true;
			}
		}
		return false;
	}
	
	private function read_cache($file)
	{
		$fp = fopen($file, 'r');
		$data = fread($fp, filesize($file));
		$data = unserialize($data);
		return $data;
	}
	
	private function write_cache($file, $data)
	{
		if(!is_dir($this->cache_path)){
			mkdir($this->cache_path);
		}
		if(file_exists($file)){
			$fp = fopen($file, 'w');
		}else{
			$fp = fopen($file, 'x');
		}
		
		$data = serialize($data);
		fwrite($fp, $data);
	}
	
	private function curl($url)
	{
		$this->check_auth();
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if($this->authenticated){
			curl_setopt($curl, CURLOPT_HTTPAUTH, $this->username.':'.$this->password);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$data = curl_exec($curl);
		$data = json_decode($data);
		return $data;
	}
}


?>