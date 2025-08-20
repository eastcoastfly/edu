<?php
/**
 * 
 * 
 */
// 

NU__ContentTypes::_register_custom_post_type(
	$literal = 'projects',
	$name = 'Projects',
	$singular = 'Project',
	$rewrite = '',
	$hierarchical = false, 
	$dashicon = 'dashicons-portfolio'
);
NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'projects-categories',
	$post_type = 'projects',
	$name = 'Projects Categories',
	$singular = 'Project Category',
	$rewrite = 'Project Categories'
);
NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'projects-tags',
	$post_type = 'projects',
	$name = 'Projects Tags',
	$singular = 'Project Tag',
	$hierarchical = false
);


?>