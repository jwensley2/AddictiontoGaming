<?php defined('BASEPATH') or exit('No direct script access allowed');


class Donations_lib {

	function __construct()
	{
		$CI =& get_instance();
		$CI->load->model('settingsmodel');

		$this->billing_day = $CI->settingsmodel->get_setting('BILLING_DAY');
	}

	// --------------------------------------------------------------------

	function get_billing_start_date()
	{
		$billing_day =& $this->billing_day;
		if (date('j') >= $billing_day)
		{
			return mktime(0,0,0,date('m'),$billing_day,date('Y'));
		}
		else
		{
			return mktime(0,0,0,date('m')-1,$billing_day,date('Y'));
		}
	}

	// --------------------------------------------------------------------

	function get_billing_end_date()
	{
		$billing_day =& $this->billing_day;
		if (date('j') < $billing_day)
		{
			return mktime(0,0,0,date('m'),$billing_day,date('Y'));
		}
		else
		{
			return mktime(0,0,0,date('m')+1,$billing_day,date('Y'));
		}
	}

	// --------------------------------------------------------------------

	function get_total_donations($start_date = null, $end_date = null)
	{
		$CI =& get_instance();

		if ( ! isset($start_date)){ $start_date = $this->get_billing_start_date(); }
		if ( ! isset($end_date)){ $end_date =  $this->get_billing_end_date(); }

		$CI->db->select('SUM(amount) AS amount');
		$CI->db->where("donations.date BETWEEN FROM_UNIXTIME('$start_date') AND FROM_UNIXTIME('$end_date')");
		$query = $CI->db->get('donations');

		$amount = $query->row()->amount;

		if ( ! $amount){ $amount = 0; }

		return $amount;
	}

	// --------------------------------------------------------------------

	function get_donation_list($start_date = null, $end_date = null)
	{
		$CI =& get_instance();

		if ( ! isset($start_date)){ $start_date = $this->get_billing_start_date(); }
		if ( ! isset($end_date)){ $end_date =  $this->get_billing_end_date(); }

		$CI->db->select('donators.*, donations.*');
		$CI->db->where('donators.id = donations.donor_id');
		$CI->db->where("donations.date BETWEEN FROM_UNIXTIME('$start_date') AND FROM_UNIXTIME('$end_date')", null, FALSE);
		$CI->db->order_by('donations.date');
		$query = $CI->db->get('donations, donators');

		return $query->result();
	}

	// --------------------------------------------------------------------

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

	// --------------------------------------------------------------------

	function add_donor($payer_id, $email, $first_name, $last_name, $ingame_name, $steam_id)
	{
		$CI =& get_instance();

		$donor_id = $CI->db->get_where('donators', array('payer_id' => $payer_id))->row('id');
		if ( ! $donor_id)
		{
			$donor_id_email = $CI->db->get_where('donators', array('email' => $email))->row('id');

			if ($donor_id_email)
			{
				$CI->db->set('payer_id', $payer_id);

				$CI->db->where('id', $donor_id_email);
				$CI->db->update('donators');

				$CI->db->where('donator_email', $email);
				$CI->db->set('donor_id', $donor_id_email);
				$CI->db->update('donations');

				return $donor_id_email;
			}
			else
			{
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

	// --------------------------------------------------------------------

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
		if ($query->result())
		{
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

		if ($expire_date < time() OR !$expire_date)
		{
			$expire_date = mktime(0, 0, 0, date('n', time()) + $months, date('j', time()), date('Y', time()));
		}
		else
		{
			echo "here";
			$expire_date = mktime(0, 0, 0, date('n', $expire_date) + $months, date('j', $expire_date), date('Y', $expire_date));
		}

		$CI->db->set('expire_date', 'FROM_UNIXTIME('.$expire_date.')', FALSE);
		$CI->db->where('email', $email);
		$CI->db->update('donators');

		return array(TRUE, "Donation added");
	}

	// --------------------------------------------------------------------

	function list_top_donors($count = 5)
	{
		$CI =& get_instance();

		$query = $CI->db->select('ingame_name, SUM(amount) AS total')
			->group_by('donators.id')
			->where('donators.id = donations.donor_id')
			->order_by('total', 'desc')
			->limit($count)
			->get('donations, donators');

		return $query->result();
	}
}


/* End of file Donations_lib.php */
/* Location: ./application/libraries/Donations_lib.php */