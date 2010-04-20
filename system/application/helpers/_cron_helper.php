<?php

	function run_cron_jobs()
	{
		$fp = fsockopen("atg.dev", 80, $errno, $errstr, 30);
		if (!$fp) {
			
		}else{
			$out = "GET /cron HTTP/1.1\r\n"; //The codeigniter url you need to run as a cron job
			$out .= "Host: atg.dev\r\n";
			$out .= "Connection: Close\r\n\r\n";

			fwrite($fp, $out);
			fclose($fp);
	}
}

?>