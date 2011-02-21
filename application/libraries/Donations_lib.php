<?php

class Donations_lib {
	
	protected $sprite_path = './assets/images/donation_progress_sprites.png';
	protected $donation_progress_path = './assets/images/donation_progress.png';
	
	function Donations_lib()
	{
		$CI =& get_instance();
		$CI->load->model('settingsmodel');
		
		$this->billing_day = $CI->settingsmodel->get_setting('BILLING_DAY');
	}
	
	function get_billing_start_date()
	{
		$billing_day =& $this->billing_day;
		if(date('j') >= $billing_day){
			return mktime(0,0,0,date('m'),$billing_day,date('Y'));
		}else{
			return mktime(0,0,0,date('m')-1,$billing_day,date('Y'));
		}
	}

	function get_billing_end_date()
	{
		$billing_day =& $this->billing_day;
		if(date('j') < $billing_day){
			return mktime(0,0,0,date('m'),$billing_day,date('Y'));
		}else{
			return mktime(0,0,0,date('m')+1,$billing_day,date('Y'));
		}
	}

	function get_total_donations($start_date = null, $end_date = null)
	{
		$CI =& get_instance();
		
		if(!isset($start_date)){ $start_date = $this->get_billing_start_date(); }
		if(!isset($end_date)){ $end_date =  $this->get_billing_end_date(); }
		
		$CI->db->select('SUM(amount) AS amount');
		$CI->db->where("donations.date BETWEEN FROM_UNIXTIME('$start_date') AND FROM_UNIXTIME('$end_date')");
		$query = $CI->db->get('donations');
		
		$amount = $query->row()->amount;
		
		if(!$amount){ $amount = 0; }

		return $amount;
	}
	
	function get_donation_list($start_date = null, $end_date = null)
	{
		$CI =& get_instance();
		
		if(!isset($start_date)){ $start_date = $this->get_billing_start_date(); }
		if(!isset($end_date)){ $end_date =  $this->get_billing_end_date(); }
		
		$CI->db->select('donators.*, donations.*');
		$CI->db->where('donators.id = donations.donor_id');
		$CI->db->where("donations.date BETWEEN FROM_UNIXTIME('$start_date') AND FROM_UNIXTIME('$end_date')", null, FALSE);
		$CI->db->order_by('donations.date');
		$query = $CI->db->get('donations, donators');
		
		return $query->result();
	}
	
	function get_donor_list()
	{
		$CI =& get_instance();
		
		$CI->db->select('*, UNIX_TIMESTAMP(expire_date) as expire_date, SUM(amount) AS total');
		$CI->db->group_by('donators.email');
		$CI->db->where('donators.id = donations.donor_id');
		$CI->db->order_by('expire_date', 'desc');
		$query = $CI->db->get('donations, donators');
		
		return $query->result();
	}
	
	function add_donor($payer_id, $email, $first_name, $last_name, $ingame_name, $steam_id)
	{
		$CI =& get_instance();
		
		$donor_id = $CI->db->get_where('donators', array('payer_id' => $payer_id))->row('id');
		if(!$donor_id){
			
			$donor_id_email = $CI->db->get_where('donators', array('email' => $email))->row('id');
			
			if($donor_id_email){
				$CI->db->set('payer_id', $payer_id);
			
				$CI->db->where('id', $donor_id_email);
				$CI->db->update('donators');
				
				$CI->db->where('donator_email', $email);
				$CI->db->set('donor_id', $donor_id_email);
				$CI->db->update('donations');
				
				return $donor_id_email;
			}else{
				$CI->db->set('payer_id', $payer_id);
				$CI->db->set('email', $email);
				$CI->db->set('first_name', $first_name);
				$CI->db->set('last_name', $last_name);
				$CI->db->set('ingame_name', $ingame_name);
				$CI->db->set('steam_id', $steam_id);
				
				$CI->db->insert('donators');
				
				return $CI->db->insert_id();
			}
		}
		
		return $donor_id;
	}
	
	/**
	 * Add a donation to the database and adjust the donators expire time
	 *
	 * @param string $email 
	 * @param string $txn_id 
	 * @param string $amount 
	 * @param string $fee 
	 * @return void
	 * @author Joseph Wensley
	 */
	function add_donation($donor_id, $email, $txn_id, $amount, $fee)
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
		$CI->db->set('donor_id', $donor_id);
		$CI->db->insert('donations');
		
		$CI->db->select('UNIX_TIMESTAMP(expire_date) AS expire_date');
		$query = $CI->db->get_where('donators', array('email' => $email));
		$row = $query->row();
		$expire_date = $row->expire_date;
		
		$months = floor($amount / 5);
		
		if($expire_date < time() OR !$expire_date){
			$expire_date = mktime(0, 0, 0, date('n', time()) + $months, date('j', time()), date('Y', time()));
		}else{
			echo "here";
			$expire_date = mktime(0, 0, 0, date('n', $expire_date) + $months, date('j', $expire_date), date('Y', $expire_date));
		}
		
		$CI->db->set('expire_date', 'FROM_UNIXTIME('.$expire_date.')', FALSE);
		$CI->db->where('email', $email);
		$CI->db->update('donators');
		
		//Update the donation progress bar
		$this->generate_progress_bar();
		
		return array(TRUE, "Donation added");
	}

	function list_top_donors($count = 5)
	{
		$CI =& get_instance();
		
		$CI->db->select('ingame_name, SUM(amount) AS total');
		$CI->db->group_by('donators.id');
		$CI->db->where('donators.id = donations.donor_id');
		$CI->db->order_by('total', 'desc');
		$CI->db->limit($count);
		$query = $CI->db->get('donations, donators');
		
		return $query->result();
	}

	/**
	 * Generate the donation progress bar and save it to a file
	 *
	 * @return void
	 * @author Joseph Wensley
	 */
	function generate_progress_bar()
	{	
		$CI =& get_instance();
		
		define('END_XPOS', 248); // End X position of the cart on the track
		define('RATIO', .928813559); // Ration to resize the sprites by
		//sprite =	array(x, y, w, h)
		$point1 =	array(0, 0, 282, 31);
		$point2 =	array(0, 31, 282, 31);
		$point3 =	array(0, 63, 282, 31);
		$cart	=	array(0, 94, 51, 43);
		
		// Get the total donations for the month and the monthly cost
		$total = $this->get_total_donations();
		$cost = $CI->settingsmodel->get_setting('MONTHLY_COST');
		
		// Calculate the percentage of the cost that has been donated
		$percent = round((100 / $cost) * $total);
		if($percent > 100){ $percent = 100; }
	
		// Set the track sprite to use based on percentage completed
		switch ($percent) {
			case ($percent >= 100):
				$track = $point3;
				break;
			case ($percent >= 50):
				$track = $point2;
				break;
			default:
				$track = $point1;
				break;
		};
		
		// Calculate the position of the cart on the track
		$cart_xpos = ($percent / 100) * (END_XPOS * RATIO);
		
		// Create empty image to copy sprites into and load sprites file
		$image = imagecreatetruecolor(294 * RATIO, 60 * RATIO);
		$sprites = imagecreatefrompng($this->sprite_path);

		// Make the background transparent
		$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
		imagefill($image, 0, 0, $trans_colour);
		
		// Copy the sprites into the final image
		imagecopyresampled($image, $sprites, 9, 25, $track[0], $track[1], $track[2] * RATIO, $track[3] * RATIO, $track[2], $track[3]);
		imagecopyresampled($image, $sprites, $cart_xpos, 5, $cart[0], $cart[1], $cart[2] * RATIO, $cart[3] * RATIO, $cart[2], $cart[3]);
		
		imagealphablending($image, false);
		imagesavealpha($image, true);
		imagepng($image, $this->donation_progress_path);
	}
}

?>