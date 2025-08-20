<?php

if (!function_exists('do_before_postsgrid_new_wpquery')) {
	function do_before_postsgrid_new_wpquery($args)
	{
		return $args;
	}
}


if (!function_exists('do_before_the_postsgrid_loop')) {
	function do_before_the_postsgrid_loop($posts)
	{
		return $posts;
	}
}


if (!function_exists('do_before_build_acf_block_output')) {
	function do_before_build_acf_block_output($return)
	{
		return $return;
	}
}



// 
if (!function_exists('nustart__do_before_page_footer')) {
	function nustart__do_before_page_footer($return)
	{

		return $return;
	}
}



add_filter('nustart__before_page_footer', 'nustart__do_before_page_footer', 11, 1);
add_filter('before_postsgrid_new_wpquery', 'do_before_postsgrid_new_wpquery', 10, 1);
add_filter('before_postsgrid_loop', 'do_before_the_postsgrid_loop', 10, 1);
add_filter('before_build_acf_block_output', 'do_before_build_acf_block_output', 10, 2);
