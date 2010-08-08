<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function relative_time($time)
{
	$now = time();
	$time = strtotime($time);
	
	$diff = $now - $time;
	switch ($diff) {
		case ($diff < 60):
			$relative = "Less than a minute ago";
			break;
		case ($diff < 3600):
			$relative = round($diff / 60) == 1 ? "1 minute ago" : round($diff / 60)." minutes ago";
			break;
		case ($diff == 3600):
			$relative = "1 hour ago";
			break;
		case ($diff < 86400):
			$relative = round($diff / 3600) == 1 ? "1 hour ago" : round($diff / 3600)." hours ago";
			break;
		case ($diff < 604800):
			$relative = round($diff / 86400) == 1 ? "1 day ago" : round($diff / 86400)." days ago";
			break;
		default:
			$relative = date('g:i A M jS', $time);
			break;
	}
	return $relative;
}

?>