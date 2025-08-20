<?php
//
//
//
//
//
register_block_type( get_template_directory().'/blocks/metadata/event-info/block.json' );
register_block_type( get_template_directory().'/blocks/metadata/news-info/block.json' );
register_block_type( get_template_directory().'/blocks/metadata/person-info/block.json' );
register_block_type( get_template_directory().'/blocks/date-time-location/block.json' );
//
//
//
//

register_block_type( get_template_directory().'/blocks/featured-ngn-stories/block.json' );


$supports = [
	'mode' => false,		// This property allows the user to toggle between edit and preview modes via a button. Defaults to true.
	'anchor' => true,
	'align_content' => true,
	'align_text' => true,
	'align' => array( 'wide', 'full' ),
	'full_height' => true,
	'jsx' => true,
	'color' => [
		'background' => true,
		'gradients'  => false,
		'text'       => true,
	],
];

acf_register_block_type(array(
	'name' => 'cards',
	'title' => 'Cards',
	'description' => '',
	'category' => 'nu-blocks',
	'mode' => 'preview',
	'render_template' => get_template_directory().'/acf-blocks/cards/cards.php',
	'icon' => '',
	'supports' => $supports,
));

$supports = [
	'mode' => false,		// This property allows the user to toggle between edit and preview modes via a button. Defaults to true.
	'anchor' => true,
	'align' => array( 'wide', 'full' ),		// This property adds block controls which allow the user to change the block’s alignment. Defaults to true. Set to false to hide the alignment toolbar. Set to an array of specific alignment names to customize the toolbar.
	'jsx' => true,
	'color' => [
		'background' => true,
		'gradients'  => false,
		'text'       => true,
	],
];
//
acf_register_block_type(array(
	'name' => 'posts-grid',
	'title' => 'Posts Grid',
	'description' => '',
	'category' => 'nu-blocks',
	'mode' => 'preview',
	'render_template' => get_template_directory().'/acf-blocks/posts-grid/posts-grid.php',
	'icon' => '',
	'supports' => $supports,
	'styles' => [
		[
			'name' => 'default',
			'label' => __('Default', 'nu-start'),
			'isDefault' => true,
		],
		[
			'name' => 'minimal',
			'label' => __('Minimal', 'nu-start')
		],
	]
));




?>
