<?php defined('BASEPATH') or exit('No direct script access allowed');


class Settingsmodel extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->database('default');
	}
	
	// --------------------------------------------------------------------
	
	function get_setting($setting)
	{
		$query = $this->db->get_where('settings', array('setting' => $setting));
		
		return $query->row()->value;
	}
	
	// --------------------------------------------------------------------
	
	function get_setting_array($setting)
	{
		$query = $this->db->get_where('settings', array('setting' => $setting));
		
		return unserialize($query->row()->value);
	}
	
	// --------------------------------------------------------------------
	
	function set_setting($setting, $value)
	{
		$data['value'] = $value;
		$this->db->where('setting', $setting);
		$this->db->update('settings', $data);
	}
	
	// --------------------------------------------------------------------
	
	function set_setting_array($setting, $value)
	{
		$data['value'] = serialize($value);
		$this->db->where('setting', $setting);
		$this->db->update('settings', $data);
	}
}


/* End of file settingsmodel.php */
/* Location: ./application/model/settingsmodel.php */