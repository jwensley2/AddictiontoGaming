<?php defined('BASEPATH') or exit('No direct script access allowed');


class Cron extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		if ( ! $this->input->is_cli_request())
		{
			exit('This controller can only be called from the command line.');
		}
	}
	
	public function index()
	{
		$this->load->model('cronmodel');
		
		$this->cronmodel->set_player_of_the_week();
		$this->cronmodel->update_donations_progress();
	}
}


/* End of file cron.php */
/* Location: ./application/controllers/cron.php */