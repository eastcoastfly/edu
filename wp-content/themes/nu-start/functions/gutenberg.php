<?php

/**
 * 
 */
// 
if (!function_exists('nu__register_pattern_categories')) {
	function nu__register_pattern_categories()
	{
		if (!function_exists('unregister_block_pattern') || !function_exists('register_block_pattern_category')) {
			return;
		}
		include(get_template_directory() . '/functions/block-editor/register-pattern-categories.php');
	}
}

if (!function_exists('nu__register_block_styles')) {
	function nu__register_block_styles()
	{
		if (!function_exists('register_block_style')) {
			return;
		}
		include(get_template_directory() . '/functions/block-editor/register-block-styles.php');
	}
}


if (!function_exists('nu__register_acf_blocks')) {
	function nu__register_acf_blocks()
	{
		if (!function_exists('acf_register_block_type')) {
			return;
		}
		include(get_template_directory() . '/functions/block-editor/register-blocks.php');
	}
}

if (!function_exists('register_plugin_block_categories')) {

	function register_plugin_block_categories($categories)
	{

		return array_merge(
			$categories,
			[
				[
					'slug'  => 'nu-blocks',
					'title' => __('NU Blocks', 'nu-start'),
				],
			]
		);
	}
}


add_action('block_categories', 'register_plugin_block_categories', 10, 2);
add_action('init', 'nu__register_pattern_categories');
add_action('init', 'nu__register_acf_blocks');
add_action('init', 'nu__register_block_styles');


include(get_template_directory() . '/classes/acf-blocks/posts-grid/class.content-query.php');


// 
