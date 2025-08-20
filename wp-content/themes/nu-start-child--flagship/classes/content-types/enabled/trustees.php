<?php
/**
 * 
 * 
 */
// 
NU__ContentTypes::_register_custom_post_type(
	$literal = 'trustees',
	$name = 'Trustees',
	$singular = 'Trustees',
	$rewrite = 'Trustees',
	$hierarchical = false, 
	$dashicon = 'dashicons-businessperson'
);


NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'trustees-types',
	$post_type = 'trustees',
	$name = 'Trustee Tyoes',
	$singular = 'Trustee Type',
	$hierarchical = false
);

?>