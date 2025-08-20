<?php
/**
 *
 *
 */
//
NU__ContentTypes::_register_custom_post_type(
	$literal = 'campuses',
	$name = 'Campuses',
	$singular = 'Campus',
	$rewrite = 'Campuses',
	$hierarchical = false,
	$dashicon = 'dashicons-location'
);

NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'campuses-tags',
	$post_type = 'campuses',
	$name = 'Campuses Tags',
	$singular = 'Campuses Tag',
	$hierarchical = false
);


?>
