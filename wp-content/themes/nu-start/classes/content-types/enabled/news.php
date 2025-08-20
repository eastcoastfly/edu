<?php
/**
 *
 *
 */
//
NU__ContentTypes::_register_custom_post_type(
	$literal = 'news',
	$name = 'News',
	$singular = 'News Item',
	$rewrite = 'news',
	$hierarchical = false,
	$dashicon = 'dashicons-format-status'
);
NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'news-categories',
	$post_type = 'news',
	$name = 'News Categories',
	$singular = 'News Category',
	$rewrite = 'News Categories'
);
NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'news-tags',
	$post_type = 'news',
	$name = 'News Tags',
	$singular = 'News Tag',
	$hierarchical = false
);

?>