<?php
/**
 * 
 * 
 */
// 
NU__ContentTypes::_register_custom_post_type(
	$literal = 'administration',
	$name = 'Administration',
	$singular = 'Administration',
	$rewrite = 'administration',
	$hierarchical = false, 
	$dashicon = 'dashicons-networking'
);

NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'administration-departments',
	$post_type = 'administration',
	$name = 'Departments',
	$singular = 'Department',
	$hierarchical = false
);

NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'administration-tags',
	$post_type = 'administration',
	$name = 'Tags',
	$singular = 'Tag',
	$hierarchical = false
);



?>