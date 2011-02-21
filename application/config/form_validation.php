<?php

$config = array(
	'news' => array(
		array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'trim|required|max_length[255]|xss_clean',
		),
		array(
			'field' => 'content',
			'label' => 'Content',
			'rules' => 'trim|required|max_length[5000]|xss_clean',
		),
	),
	
	'potw' => array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required|max_length[100]|xss_clean',
		),
		array(
			'field' => 'real_name',
			'label' => 'Real Name',
			'rules' => 'trim|required|max_length[100]|xss_clean',
		),
		array(
			'field' => 'steam_id',
			'label' => 'Steam ID',
			'rules' => 'trim|max_length[30]|callback__steam_id_check|xss_clean',
		),
		array(
			'field' => 'start_date',
			'label' => 'Start Date',
			'rules' => 'trim|max_length[10]|valid_date|xss_clean',
		),
	),
	
	'server' => array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required|xss_clean',
		),
		array(
			'field' => 'ip',
			'label' => 'IP',
			'rules' => 'trim|required|valid_ip',
		),
		array(
			'field' => 'port',
			'label' => 'Port',
			'rules' => 'trim|required|is_natural|min_length[1]|max_length[5]',
		),
	),
);

?>