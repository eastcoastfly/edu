<?php
//
//
//
//
//
register_block_style(
	'eedee/block-gutenslider',
	array(
		'name'         => 'for-heroes',
		'label'        => __('For Heroes', 'nu-start'),
	)
);
register_block_style(
	'core/column',
	array(
		'name'         => 'sidebar-column',
		'label'        => __('Sidebar', 'nu-start'),
	)
);
register_block_style(
	'core/columns',
	array(
		'name'         => 'sidebar-layout',
		'label'        => __('Sidebar Layout', 'nu-start'),
	)
);
// ? Large
register_block_style(
	'core/paragraph',
	array(
		'name'         => 'large',
		'label'        => __('Large - 28px', 'nu-start'),
	)
);

// ? Medium
register_block_style(
	'core/paragraph',
	array(
		'name'         => 'medium',
		'label'        => __('Medium - 18px', 'nu-start'),
		'inline_style' => 'p.is-style-medium'
	)
);

// ? Small
register_block_style(
	'core/paragraph',
	array(
		'name'         => 'small',
		'label'        => __('Small - 16px', 'nu-start'),
		'inline_style' => 'p.is-style-small'
	)
);

// ? "Eyebrow"
register_block_style(
	'core/paragraph',
	array(
		'name'         => 'eyebrow',
		'label'        => __('Eyebrow - 14px', 'nu-start'),
	)
);

register_block_style(
	'core/cover',
	array(
		'name'         => 'as-hero',
		'label'        => __('As Hero', 'nu-start'),
		'style_handle' => 'as-hero'
	)
);

register_block_style(
	'core/column',
	array(
		'name'         => 'main-content-column',
		'label'        => __('Main Content Column', 'nu-start'),
		'style_handle' => 'main-content-column'
	)
);

register_block_style(
	'core/image',
	array(
		'name'         => 'floating-cite',
		'label'        => __('Floating Cite', 'nu-start'),
		'style_handle' => 'floating-cite'
	)
);

register_block_style(
	'core/media-text',
	array(
		'name'         => 'squared-card',
		'label'        => __('Squared Card', 'nu-start'),
		'style_handle' => 'squared-card'
	)
);

register_block_style(
	'eedee/block-gutenslider',
	array(
		'name'         => 'alternate',
		'label'        => __('Alternate', 'nu-start'),
	)
);
