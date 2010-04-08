<?php

class Donations extends MY_Controller {
	
	function Donations()
	{
		parent::MY_Controller();
		
		//Load libraries, helpers and models
		$this->load->library(array('Donations_lib', 'Paypal_Lib'));
		$this->load->model('serversmodel');
		$this->load->helper('string');
		
		//Set header data
		$this->header_data['stylesheets'][] = 'donations.css';
	}
	
	function index()
	{
		$content_data['donators'] = $this->donations_lib->get_donor_list();
		$content_data['top_donors'] = $this->donations_lib->list_top_donors(5);
		
		$this->load->view('templates/header', $this->header_data);
		$this->load->view('donations/donations', $content_data);
		$this->load->view('templates/footer');
	}
	
	
	function ipn()
	{
		$to = 'joseph.wensley@gmail.com';
		
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

			//Donation info
			$amount = $this->paypal_lib->ipn_data['mc_gross'];
			$fee = $this->paypal_lib->ipn_data['mc_fee'];
			$txn_id = $this->paypal_lib->ipn_data['txn_id'];
			
			$this->donations_lib->add_donor($email, $first_name, $last_name, $ingame_name, $steam_id);
			$this->donations_lib->add_donation($email, $txn_id, $amount, $fee);
		}
	}
	
	function top()
	{
		var_dump($this->donations_lib->list_top_donors(5));
	}
}

?>