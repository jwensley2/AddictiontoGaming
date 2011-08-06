<?php defined('BASEPATH') or exit('No direct script access allowed');


class MY_Form_validation extends CI_Form_validation {
	
	/**
	 * Checks if $str is a valid date and return TRUE or FALSE
	 * Also sets the message to display if validation fails
	 *
	 * @param string $str 
	 * @param string $field 
	 * @return bool
	 * @author Joseph Wensley
	 */
	public function valid_date($str, $field)
	{
		$CI =& get_instance();

		$CI->form_validation->set_message('valid_date', 'The %s field must contain a valid date');
		
		// Create a regex that will match any possible date in mm/dd/yyyy format
		$regex = "/^(0[1-9]|1[012])\/(0[1-9]|[12]\d|3[01])\/(19|20|21)\d\d$/";
		
		//Check if the date matches the regex
		if ( ! preg_match($regex, $str)){ return FALSE; }
		
		// Get the month, day and year from the date string
		list($month, $day, $year) = explode('/', $str);
		
		if (checkdate((int) $month, (int) $day, (int) $year))
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Checks if $str is a valid URL and returns TRUE or FALSE
	 * Also sets the message to display if validation fails
	 * 
	 * @param string $str 
	 * @return bool
	 * @author Joseph Wensley
	 */
	public function valid_url($str)
	{
		$CI =& get_instance();
		
		$CI->form_validation->set_message('valid_url', 'The %s field must contain a valid URL');
		
		$regex = "/([\d\w-.]+?\.(a[cdefgilmnoqrstuwz]|b[abdefghijmnorstvwyz]|c[acdfghiklmnoruvxyz]|d[ejkmnoz]|e[ceghrst]|f[ijkmnor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eouw]|s[abcdeghijklmnortuvyz]|t[cdfghjkmnoprtvwz]|u[augkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw]|aero|arpa|biz|com|coop|edu|info|int|gov|mil|museum|name|net|org|pro)(\b|\W(?<!&|=)(?!\.\s|\.{3}).*?))(\s|$)/";
		
		if (preg_match($regex, $str))
		{
			return TRUE;
		}
		
		return FALSE;
	}
}


/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */