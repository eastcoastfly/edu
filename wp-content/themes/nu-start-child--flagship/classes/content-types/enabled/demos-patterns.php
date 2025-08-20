<?php
/**
 * 
 * 
 */
// 
NU__ContentTypes::_register_custom_post_type(
	$literal = 'pattern-demos',
	$name = 'Pattern Demos',
	$singular = 'Pattern Demo',
	$rewrite = 'pattern-demos',
	$hierarchical = false, 
	$dashicon = 'dashicons-smiley',
);


NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'pattern-demos-categories',
	$post_type = 'pattern-demos',
	$name = 'Pattern Demos Categories',
	$singular = 'Pattern Demos Category',
	$rewrite = 'Pattern Demos Categories'
);


NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'pattern-demos-tags',
	$post_type = 'pattern-demos',
	$name = 'Pattern Demos Tags',
	$singular = 'Pattern Demos Tag',
	$hierarchical = false
);


?>