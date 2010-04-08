<?php

class Donations_lib {
	
	function Donations_lib()
	{
		$CI =& get_instance();
		$CI->load->model('settingsmodel');
		
		$this->billing_day = $CI->settingsmodel->get_setting('BILLING_DAY');
	}
	
	function get_billing_start_date()
	{
		if(date('j') >= $this->billing_day){
			return date('Y-m-12 0:0:0');
		}else{
			return date('Y-m-12 0:0:0',mktime(0,0,0,date('m')-1,12,date('Y')));
		}
	}

	function get_billing_end_date()
	{
		if(date('j') < $this->billing_day){
			return date('Y-m-12 0:0:0');
		}else{
			return date('Y-m-12 0:0:0',mktime(0,0,0,date('m')+1,12,date('Y')));
		}
	}

	function get_total_donations($start_date = null, $end_date = null)
	{
		$CI =& get_instance();
		
		if(!$start_date){ $start_date = $this->get_billing_start_date(); }
		if(!$end_date){ $end_date =  $this->get_billing_end_date(); }
		
		$CI->db->select('SUM(amount) AS amount');
		$CI->db->where("donations.date BETWEEN '$start_date' AND '$end_date'");
		$query = $CI->db->get('donations');
		
		$amount = $query->row()->amount;
		
		if(!$amount){ $amount = 0; }

		return $amount;
	}
	
	function get_donor_list($start_date = null, $end_date = null)
	{
		$CI =& get_instance();
		
		if(!$start_date){ $start_date = $this->get_billing_start_date(); }
		if(!$end_date){ $end_date =  $this->get_billing_end_date(); }
		
		$CI->db->select('donators.*, donations.*');
		$CI->db->where('donators.email = donations.donator_email');
		$CI->db->where("donations.date BETWEEN '$start_date' AND '$end_date'");
		$CI->db->order_by('donations.date');
		$query = $CI->db->get('donations, donators');
		
		return $query->result();
	}
	
	function add_donor($email, $first_name, $last_name, $ingame_name, $steam_id)
	{
		$CI =& get_instance();
		
		$query = $CI->db->get_where('donators', array('email' => $email));
		if(!$query->result()){
			$CI->db->set('email', $email);
			$CI->db->set('first_name', $first_name);
			$CI->db->set('last_name', $last_name);
			$CI->db->set('ingame_name', $ingame_name);
			$CI->db->set('steam_id', $steam_id);
			
			if($CI->db->insert('donators')){
				return array(TRUE, "Donor was added to database");
			}else{
				return array(TRUE, "Donor was already in the database");
			}
		}
	}
	
	function add_donation($email, $txn_id, $amount, $fee)
	{
		$CI =& get_instance();
		
		$query = $CI->db->get_where('donations', array('txn_id' => $txn_id));
		if($query->result()){
			return array(FALSE, "A donation has already been added with the provided txn_id");
		}
		
		$CI->db->set('txn_id', $txn_id);
		$CI->db->set('amount', $amount);
		$CI->db->set('fee', $fee);
		$CI->db->set('donator_email', $email);
		$CI->db->insert('donations');
		
		$donationtimes = array(
			5 => 1,
			10 => 2,
			15 => 3,
			20 => 6,
			25 => 7,
			30 => 8,
			35 => 9,
			40 => 12,
			45 => 13,
			50 => 14,
		);
		
		$CI->db->select('UNIX_TIMESTAMP(expire_date) AS expire_date');
		$query = $CI->db->get_where('donators', array('email' => $email));
		$row = $query->row();
		$expire_date = $row->expire_date;
		
		foreach($donationtimes as $amnt => $months){
			if($amount >= $amnt){
				$expire_in_months = $months;
			}
		}
		
		if($expire_date < time() OR !$expire_date){
			$expire_date = mktime(0, 0, 0, date('n', time()) + $expire_in_months, date('j', time()), date('Y', time()));
		}else{
			$expire_date = mktime(0, 0, 0, date('n', $expire_date) + $expire_in_months, date('j', $expire_date), date('Y', $expire_date));
		}
		
		$CI->db->set('expire_date', 'FROM_UNIXTIME('.$expire_date.')', FALSE);
		$CI->db->where('email', $email);
		$CI->db->update('donators');
		
		return array(TRUE, "Donation added");
	}
	
	function list_top_donors($count = 5)
	{
		$CI =& get_instance();
		
		$CI->db->select('ingame_name, SUM(amount) AS total');
		$CI->db->group_by('donators.email');
		$CI->db->where('donations.donator_email = donators.email');
		$CI->db->order_by('total', 'desc');
		$CI->db->limit($count);
		$query = $CI->db->get('donations, donators');
		
		return $query->result();
	}
}

?>