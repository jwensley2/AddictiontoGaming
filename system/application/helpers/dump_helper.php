<?php

	function dump($data, $color = 'black')
	{
		
		print '<span style="color: '.$color.'">';
		print str_replace(array("\n"," "),array("<br>","&nbsp;"), var_export($data,true))."<br>";
		print '</span>';
	}

?>