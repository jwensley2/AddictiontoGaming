<?php

/**
 * Donations controller to handle donation related pages
 *
 * @package default
 * @author Joseph Wensley
 */
class Donations extends MY_Controller {
	
	function Donations()
	{
		parent::MY_Controller();
		
		//Load libraries, helpers and models
		$this->load->library(array('Donations_lib', 'Paypal_Lib', 'servers/source_rcon'));
		$this->load->model('serversmodel');
		$this->load->helper('string');
		
		//Set header data
		$this->asset_lib->add_asset('donations', 'css', 'script');
		//$this->header_data['stylesheets'][] = 'donations.css';
	}
	
	/**
	 * Display the donations page which contains a donation form and list of recent donations and the top donors
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	function index()
	{
		$this->header_data['title'] = 'Make a Donation';
		
		$content_data['donators'] = $this->donations_lib->get_donation_list();
		$content_data['top_donors'] = $this->donations_lib->list_top_donors(10);
		$content_data['total_donations'] = $this->donations_lib->get_total_donations(0);
		
		$this->load->view('templates/header', $this->header_data);
		$this->load->view('donations/donations', $content_data);
		$this->load->view('templates/footer');
	}
	
	/**
	 * Receives and handles PayPal IPN calls using the Paypal_lib
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	function ipn()
	{
		$to = 'jwensley2@gmail.com';
		
		if ($this->paypal_lib->validate_ipn()){
			$body  = 'An instant payment notification was successfully received from ';
			$body .= $this->paypal_lib->ipn_data['payer_email'] . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";

			foreach ($this->paypal_lib->ipn_data as $key=>$value)
				$body .= "\n$key: $value";
	
			// load email lib and email results
			$this->load->library('email');
			$this->email->to($to);
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject('CI paypal_lib IPN (Received Payment)');
			$this->email->message($body);	
			//$this->email->send();
			
			
			//Payer Information
			$email = $this->paypal_lib->ipn_data['payer_email'];
			$first_name = $this->paypal_lib->ipn_data['first_name'];
			$last_name = $this->paypal_lib->ipn_data['last_name'];
			$steam_id = trim($this->paypal_lib->ipn_data['option_selection1']);
			$ingame_name = trim($this->paypal_lib->ipn_data['option_selection2']);
			$payer_id = $this->paypal_lib->ipn_data['payer_id'];

			//Donation info
			$amount = $this->paypal_lib->ipn_data['mc_gross'];
			$fee = $this->paypal_lib->ipn_data['mc_fee'];
			$txn_id = $this->paypal_lib->ipn_data['txn_id'];
			
			$donor_id = $this->donations_lib->add_donor($payer_id, $email, $first_name, $last_name, $ingame_name, $steam_id);
			$this->donations_lib->add_donation($donor_id, $email, $txn_id, $amount, $fee);
			
			$steam_id_pattern = "/^STEAM_[0-9]:[0-9]:[0-9]+$/";
			if(preg_match($steam_id_pattern, $steam_id) && isset($ingame_name)){
				$this->load->model('sourcebansmodel');
				$this->sourcebansmodel->add_donor($ingame_name, $steam_id, $email);
			}
			
			// Rehash all TF2 servers
			$servers = $this->serversmodel->quick_list_servers('tf2');
			foreach($servers as $server){
				$this->source_rcon->connect($server->ip, $server->port, $server->rcon_password);
				$this->source->rcon->send_command('sm_rehash');
				$this->source->rcon->send_command('say "'.$ingame_name.' just donated $'.$amount.'!"');
			}
			
		}
	}
	
	/**
	 * Call this page to manually generate the donation progress image
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	function generate_image()
	{
		$this->donations_lib->generate_progress_bar();
	}
}

?>