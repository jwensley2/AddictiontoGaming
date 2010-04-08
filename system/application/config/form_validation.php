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
);

?>