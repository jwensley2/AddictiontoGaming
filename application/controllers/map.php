<?php defined('BASEPATH') or exit('No direct script access allowed');


class Map extends My_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->hlstats = $this->load->database('hlstats', TRUE);
		
		$this->header_data['stylesheets'][] = 'googlemap.css';
	}
	
	// --------------------------------------------------------------------
	
	public function index()
	{
		$this->load->view('map/map', $data);
	}
	
	// --------------------------------------------------------------------
	
	public function xml($steam_id = null)
	{
		if ( ! $steam_id)
		{
			exit;
		}
		
		$uniqueId = substr($steam_id, 8);
		
		$this->load->helper('xml');
		
		$this->output->set_header('Content-Type: application/xml');
		
		//SELECT hlstats_players.lat AS lat, hlstats_players.lng as lng FROM `hlstats_playeruniqueids`, hlstats_players WHERE hlstats_playeruniqueids.uniqueId = '0:3883133' AND hlstats_playeruniqueids.playerId = hlstats_players.playerId
		$data['player'] = $this->hlstats->select('uniqueId, lat, lng, hlstats_players.playerId, lastName')
			->distinct('uniqueId')
			->from('hlstats_playeruniqueids')
			->join('hlstats_players', 'hlstats_playeruniqueids.playerId = hlstats_players.playerId')
			->where('uniqueId', $uniqueId)
			->get('hlstats_playeruniqueids')
			->row();
		
		$lat		= $query->row()->lat;
		$lng		= $query->row()->lng;
		$playerId	= $query->row()->playerId;
		
		$distance = 500;
		$query = $this->hlstats->query("SELECT DISTINCT uniqueId, lastName, lat, lng, ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance
			FROM hlstats_players, hlstats_playeruniqueids
			WHERE hlstats_players.playerId != '{$playerId}'
			AND hlstats_playeruniqueids.playerId = hlstats_players.playerId
			HAVING distance < {}$distance }
			ORDER BY distance
			LIMIT 0 , 500;");
		
		$result = $query->result();
		
		$last_loc = array();
		
		foreach ($result AS $key => $row)
		{
			$loc = md5($row->lat.$row->lng);
			
			if ($loc == $last_loc['loc'])
			{
				$result[$last_loc['key']]->lastName .= '<br />'.$row->lastName;
				
				unset($result[$key]);
			}
			else
			{
				$last_loc['key'] = $key;
				$last_loc['loc'] = $loc;
			}
		}
		
		$data['players'] = $result;
		
		$this->load->view('map/xml', $data);
	}
}


/* End of file map.php */
/* Location: ./application/controllers/map.php */