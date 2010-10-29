<?php



class Twitter_lib
{
	protected $cache_path = './system/cache/twitter/';
	protected $cache_time = 1; // Cache time in minutes
	
	private $api_key			= 'sGdfORr90Srx91zjh7YW5Q';
	private $consumer_key		= 'sGdfORr90Srx91zjh7YW5Q';
	private $consumer_secret	= 'db96ZWW23n9HmXFCwZ6qV6xTHmHQiKnW16rmnr07A';
	
	private $oauth_token		= '46725316-ZyDCaapK1bAt6lbEBtgl73O7Nuthi5zxdMJszHGEg';
	private $oauth_token_secret	= 'V898HSUlljouus9qxrsfg3cou61WE1iDtJUyMuN54';
	
	private $authenticated = FALSE;
	private $username;
	private $password;
	
	function Twitter_lib()
	{
		require_once('./system/application/libraries/twitteroauth/twitteroauth.php');
	}
	
	function auth()
	{
		$this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->oauth_token, $this->oauth_token_secret);
		$content = $this->twitter->get('account/verify_credentials');
		
		if(isset($content->name)){
			$this->authenticated = TRUE;
		}
	}
	
	function user_timeline($count)
	{
		if($this->authenticated == FALSE){
			return FALSE;
		}
	
		$cache_filename = 'user_timeline.cache';
		
		$params = array(
			'count' => $count,
		);
		
		if($this->check_cache($cache_filename) == FALSE){
			$timeline = $this->twitter->get('statuses/user_timeline', $params);
			
			if(is_array($timeline)){
				$this->write_cache($cache_filename, $timeline);
			}else{
				$timeline = $this->read_cache($cache_filename);
			}
		}else{
			$timeline = $this->read_cache($cache_filename);
		}
		
		return $timeline;
	}
	
	function update($status)
	{
		if($this->authenticated == FALSE){
			return FALSE;
		}
		
		$params = array(
			'status' => $status,
		);
		
		return $this->twitter->post('statuses/update', $params);
	}
	
	/**
	 * Caching Functions
	 */
	
	/**
	 * Check to see if the cache is good
	 * Returns TRUE if the cache is good
	 *
	 * @param string $file 
	 * @return bool
	 * @author Joseph Wensley
	 */
	private function check_cache($filename)
	{
		$file = $this->cache_path.$filename;
		
		if(file_exists($file)){
			$modified = filemtime($file);
			if($modified > (time() - ($this->cache_time * 60))){
				return TRUE;
			}
		}
		return FALSE;
	}
	
	private function read_cache($filename)
	{
		$file = $this->cache_path.$filename;
		
		$fp = fopen($file, 'r');
		$data = fread($fp, filesize($file));
		$data = unserialize($data);
		fclose($fp);
		
		return $data;
	}
	
	private function write_cache($filename, $data)
	{
		$file = $this->cache_path.$filename;
		
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
		
		fclose($fp);
	}
	
	/**
	 * Twitter Utility Functions
	 */
	
	/**
	 * Change a timestamp to a relative time
	 *
	 * @param string $time 
	 * @return void
	 * @author Joseph Wensley
	 */	
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
				$relative = round($diff / 3600) == 1 ? "1 hour ago" : round($diff / 3600)." hours ago";
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
}


?>