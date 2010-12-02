<?php
	$ip = $_SERVER['REMOTE_ADDR'];

	if($ip != '127.0.0.1'){
		echo "Insufficient Access";
	}else{
		$fp = fsockopen("atg.dev", 80, $errno, $errstr, 30);
		if (!$fp) {
			//echo "$errstr ($errno)<br />\n";
		} else {
			$out = "GET /cron HTTP/1.1\r\n"; //The codeigniter url you need to run as a cron job
			$out .= "Host: atg.dev\r\n";
			$out .= "Connection: Close\r\n\r\n";

			fwrite($fp, $out);
			/*
			while (!feof($fp)) {
				echo fgets($fp, 128);
			}
			*/
			fclose($fp);
	}
}
?>