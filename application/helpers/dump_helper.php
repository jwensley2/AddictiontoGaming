<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function dump($data, $color = 'black')
	{
		
		print '<span style="color: '.$color.'">';
		print str_replace(array("\n"," "),array("<br>","&nbsp;&nbsp;&nbsp;"), var_export($data,true))."<br>";
		print '</span>';
	}

?>