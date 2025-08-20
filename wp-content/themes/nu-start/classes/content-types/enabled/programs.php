<?php
/**
 * 
 * 
 */
// 

NU__ContentTypes::_register_custom_post_type(
	$literal = 'programs',
	$name = 'Programs',
	$singular = 'Program',
	$rewrite = '',
	$hierarchical = false, 
	$dashicon = 'dashicons-clipboard'
);


NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'programs-categories',
	$post_type = 'programs',
	$name = 'Programs Subjects',
	$singular = 'Program Subject',
	$rewrite = 'Programs Subjects'
);


?>