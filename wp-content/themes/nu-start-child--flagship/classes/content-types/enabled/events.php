<?php
/**
 * 
 * 
 */
// 
NU__ContentTypes::_register_custom_post_type(
	$literal = 'events',
	$name = 'Events',
	$singular = 'Event',
	$rewrite = 'events',
	$hierarchical = false, 
	$dashicon = 'dashicons-calendar'
);

NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'events-types',
	$post_type = 'events',
	$name = 'Events Types',
	$singular = 'Events Type',
	$hierarchical = false
);

NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'events-locations',
	$post_type = 'events',
	$name = 'Events Locations',
	$singular = 'Events Location',
	$hierarchical = false
);

?>