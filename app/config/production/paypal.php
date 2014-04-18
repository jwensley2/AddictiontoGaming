<?php

return array(
	'mode' => 'live',

	// Account Credentials
	'acct1.UserName'  => $_ENV['paypal.username'],
	'acct1.Password'  => $_ENV['paypal.password'],
	'acct1.Signature' => $_ENV['paypal.signature'],
);