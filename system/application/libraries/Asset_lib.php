<?php

/**
* 
*/
class Asset_lib
{
	var $stylesheets	= array();
	var $scripts		= array();
	
	function Asset_lib()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->config('asset_lib');
		$this->CI->load->helper('array');
		
		$this->css_path			= $this->CI->config->item('assets_css_path');
		$this->js_path			= $this->CI->config->item('assets_js_path');
		$this->cache_folder		= $this->CI->config->item('assets_cache_folder');
		$this->controller		= $this->CI->config->item('assets_controller');
		$this->css_method		= $this->CI->config->item('assets_css_method');
		$this->js_method		= $this->CI->config->item('assets_js_method');
		$this->jsmin_path		= $this->CI->config->item('jsmin_path');
	}
	
	/**
	 * read_assets
	 *
	 * Read assets and output html tag
	 *
	 * @param string $type 
	 * @param string $groups 
	 * @return string
	 * @author Joseph Wensley
	 */
	function read_assets($type, $groups = 'base')
	{
		// Create refrences to lib properties depending on asset type
		if($type === 'css'){
			$main_asset_list =& $this->stylesheets;
			$asset_folder =& $this->css_path;
		}elseif($type === 'js'){
			$main_asset_list =& $this->scripts;
			$asset_folder =& $this->js_path;
		}else{
			return '';
		}
		
		$assets = array();
		if(is_array($groups)){
			// Merge the assets from the provided groups into 1 array
			foreach($groups as $group){
				if($main_asset_list[$group]){
					$assets = array_merge($assets, $main_asset_list[$group]);	
				}
			}
		}else{
			$assets = $main_asset_list[$groups];
		}
		
		// Set the name and path for each asset while checking to see if it actually exists
		foreach($assets as $key => $asset){
			$asset = preg_replace("/\.$type$/", '', $asset);
			$path = FCPATH."{$asset_folder}/{$asset}.{$type}";
			
			$parts = pathinfo($asset.'.'.$type);
			$name = $parts['basename'];
			
			if(file_exists($path)){
				$assets[$key] = array(
					'name' => $name,
					'path' => $path,
				);
			}else{
				// Remove the non-existent asset from the array
				unset($assets[$key]);
			}
		}
		
		// Remove duplicates
		$assets = multi_unique($assets);
		
		// Use the md5'd list of assets as the cache name
		$cache_name = md5(serialize($assets)).".$type";
		$cache_path = FCPATH."{$asset_folder}/{$this->cache_folder}/{$cache_name}";
		$cache_url = base_url()."{$asset_folder}/{$this->cache_folder}/{$cache_name}";
		
		$data = '';
		
		// If the cache doesn't exist rebuild it
		if(!$this->_check_cache($cache_path, $assets)){
			foreach($assets as $asset){
				if(!empty($data)){ $data .= "\n\n"; }
				$data .= "/********** {$asset['name']}**********/\n";
				$file_data = file_get_contents($asset['path']);
				$data .= $this->_minify_data($file_data, $type);
			}
			$this->_write_cache($cache_path, $data);
		}
		
		// Return the html tags
		if($type === 'css'){
			return sprintf('<link rel="stylesheet" href="%s" type="text/css" media="screen" charset="utf-8">', $cache_url);
		}elseif($type === 'js'){
			return sprintf('<script src="%s" type="text/javascript" charset="utf-8"></script>', $cache_url);
		}
		
		
	}
	
	function add_asset($name, $type = NULL, $group = 'base')
	{
		// Add an assets to either the stylesheets or scripts arrays
		if($type === 'css'){
			$this->stylesheets[$group][] = $name;
		}elseif($type === 'js'){
			$this->scripts[$group][] = $name;
		}
	}
	
	function output_tags($type = 'both', $groups){
		if($type === 'both'){
			$tags[] = $this->read_assets('css', $groups);
			$tags[] = $this->read_assets('js', $groups);
		}elseif($type === 'css'){
			$tags[] = $this->read_assets('css', $groups);
		}elseif ($type === 'js') {
			$tags[] = $this->read_assets('js', $groups);
		}else{
			return '<!-- Invalid Asset Type -->';
		}
		
		return implode('\n', $tags);
	}
	
	function _check_cache($cache, $assets)
	{
		if(!file_exists($cache)){
			return FALSE;
		}else{
			foreach($assets as $asset){
				if(filemtime($asset['path']) > filemtime($cache)){
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	function _write_cache($cache, $data)
	{
		$path_parts = pathinfo($cache);
		$cache_dir = $path_parts['dirname'];
		if(!is_dir($cache_dir)){
			mkdir($cache_dir, 0777, TRUE);
		}
		
		$gz = gzopen($cache.'gz', 'w9');
		gzwrite($gz, $data);
		gzclose($gz);
		
		$f = fopen($cache, 'w');
		fwrite($f, $data);
		fclose($f);
	}
	
	function _minify_data($data, $asset_type){
		if($asset_type === 'css'){
			$comment_pattern = "/\/\*\*(?:\r|\n|\r\n|.)*?\*\*\//i";
			$data = preg_replace($comment_pattern, '', $data);
			$data = preg_replace("/(?:\r|\n|\r\n)*/", '', $data);
			$data = preg_replace("/(\s)+/", ' ', $data);
		}elseif($asset_type === 'js'){
			if(include_once $this->jsmin_path){
				$data = JSMin::minify($data);
			}
		}
		return $data;
	}
}
?>