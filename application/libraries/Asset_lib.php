<?php defined('BASEPATH') or exit('No direct script access allowed');


class Asset_lib {
	
	public $stylesheets	= array();
	public $scripts		= array();
	public $debug 		= FALSE;
	
	public function __construct()
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
	
	// --------------------------------------------------------------------
	
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
	public function read_assets($type, $groups = 'base')
	{
		$return = '';
		
		// Create refrences to lib properties depending on asset type
		if ($type === 'css')
		{
			$main_asset_list =& $this->stylesheets;
			$asset_folder =& $this->css_path;
		}
		elseif ($type === 'js')
		{
			$main_asset_list =& $this->scripts;
			$asset_folder =& $this->js_path;
		}
		else
		{
			return '';
		}
		
		$assets = array();
		if (is_array($groups))
		{
			// Merge the assets from the provided groups into 1 array
			foreach ($groups AS $group)
			{
				if ($main_asset_list[$group])
				{
					$assets = array_merge($assets, $main_asset_list[$group]);
				}
			}
		}
		else
		{
			$assets = $main_asset_list[$groups];
		}
		
		if (count($assets) == 0){ return; }
		
		// Set the name and path for each asset while checking to see if it actually exists
		foreach ($assets AS $key => $asset_info)
		{
			$asset = $asset_info['asset'];
			$minify = $asset_info['minify'];
			
			$asset = preg_replace("/\.$type$/", '', $asset);
			$path = FCPATH."{$asset_folder}/{$asset}.{$type}";
			
			$parts = pathinfo($asset.'.'.$type);
			$name = $parts['basename'];
			
			if (file_exists($path))
			{
				$assets[$key] = array(
					'name' => $name,
					'path' => $path,
				);
			}
			else
			{
				// Remove the non-existent asset from the array
				unset($assets[$key]);
			}
			
			if ($asset_info['cache'] == FALSE)
			{
				if ($type === 'css')
				{
					$url = base_url()."{$this->css_path}/{$asset}.{$type}";
					$return .= sprintf('<link rel="stylesheet" href="%s" type="text/css" media="screen" charset="utf-8">', $url);
				}
				elseif ($type === 'js')
				{
					$url = base_url()."{$this->js_path}/{$asset}.{$type}";
					$return .= sprintf('<script src="%s" type="text/javascript" charset="utf-8"></script>', $url);
				}
				unset($assets[$key]);
			}
		}
		
		if (count($assets) == 0)
		{
			return $return;
		}
		
		// Remove duplicates
		$assets = multi_unique($assets);
		
		// Use the md5'd list of assets as the cache name
		$cache_name = md5(serialize($assets)).".$type";
		$cache_path = FCPATH."{$asset_folder}/{$this->cache_folder}/{$cache_name}";
		$cache_url = base_url()."{$asset_folder}/{$this->cache_folder}/{$cache_name}";
		
		$data = '';
		
		// If the cache doesn't exist rebuild it
		if ( ! $this->check_cache($cache_path, $assets))
		{
			foreach ($assets as $asset)
			{
				if ( ! empty($data)){ $data .= "\n\n"; }
				$data .= "/********** {$asset['name']}**********/\n";
				$file_data = file_get_contents($asset['path']);
				$data .= $this->minify_data($file_data, $type, $minify);
			}
			$this->write_cache($cache_path, $data);
		}
		
		// Return the html tags
		if ($type === 'css')
		{
			return sprintf('<link rel="stylesheet" href="%s" type="text/css" media="screen" charset="utf-8">', $cache_url).$return;
		}
		elseif ($type === 'js')
		{
			return sprintf('<script src="%s" type="text/javascript" charset="utf-8"></script>', $cache_url).$return;
		}
		
		
	}
	
	// --------------------------------------------------------------------
	
	public function add_asset($name, $type = NULL, $group = 'base', $cache = TRUE, $minify = TRUE)
	{
		// Add an assets to either the stylesheets or scripts arrays
		if ($type === 'css')
		{
			$i = count($this->stylesheets[$group]) + 1;
			
			$this->stylesheets[$group][$i]['asset']		= $name;
			$this->stylesheets[$group][$i]['minify']	= $minify;
			$this->stylesheets[$group][$i]['cache']		= $cache;
		}
		elseif ($type === 'js')
		{
			$i = count($this->scripts[$group]) + 1;
			
			$this->scripts[$group][$i]['asset']		= $name;
			$this->scripts[$group][$i]['minify']	= $minify;
			$this->scripts[$group][$i]['cache']		= $cache;
		}
	}
	
	// --------------------------------------------------------------------
	
	public function output_tags($type = 'both', $groups)
	{
		if ($type === 'both')
		{
			$tags[] = $this->read_assets('css', $groups);
			$tags[] = $this->read_assets('js', $groups);
		}
		elseif ($type === 'css')
		{
			$tags[] = $this->read_assets('css', $groups);
		}
		elseif ($type === 'js')
		{
			$tags[] = $this->read_assets('js', $groups);
		}
		else
		{
			return '<!-- Invalid Asset Type -->';
		}
		
		return implode('\n', $tags);
	}
	
	// --------------------------------------------------------------------
	
	private function check_cache($cache, $assets)
	{
		if ( ! file_exists($cache))
		{
			return FALSE;
		}
		else
		{
			foreach ($assets as $asset)
			{
				if (filemtime($asset['path']) > filemtime($cache))
				{
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	
	private function write_cache($cache, $data)
	{
		$path_parts = pathinfo($cache);
		$cache_dir = $path_parts['dirname'];
		if ( ! is_dir($cache_dir))
		{
			mkdir($cache_dir, 0777, TRUE);
		}
		
		$f = fopen($cache, 'w');
		fwrite($f, $data);
		fclose($f);
	}
	
	// --------------------------------------------------------------------
	
	private function minify_data($data, $asset_type, $minify){
		if ( ! $this->debug && $minify == TRUE)
		{
			if ($asset_type === 'css')
			{
				$comment_pattern = "/\/\*\*(?:\r|\n|\r\n|.)*?\*\*\//i";
				$data = preg_replace($comment_pattern, '', $data);
				$data = preg_replace("/(?:\r|\n|\r\n)*/", '', $data);
				$data = preg_replace("/(\s)+/", ' ', $data);
			}
			elseif ($asset_type === 'js')
			{
				if (include_once $this->jsmin_path)
				{
					$data = JSMin::minify($data);
				}
			}
		}
		
		return $data;
	}
}


/* End of file Asset_lib.php */
/* Location: ./application/libraries/Asset_lib.php */