<?php
include(get_template_directory() . '/functions/_experimental.php');

/**
 * gets file names and paths within a directory at one depth
 * uses scandir to return an associated array of filenames and paths
 *
 * @param [string] $dir
 * @return array 
 */
function get_dir_filenames_and_paths($dir)
{

	if (!is_dir($dir)) {
		return;
	}

	$finalArray = [];
	// remove '.' and '..' from the scandir
	$found = array_diff(scandir($dir), array('.', '..'));

	// capture only the name of the file
	foreach ($found as $item) {
		$finalArray[str_replace('.php', '', $item)] = $dir . $item;
	}

	// 
	return $finalArray;
}


/**
 * return an inline-styles string for an acf block
 *
 * @param [type] $block
 * @param [type] $fields
 * @return void
 */
function return_acf_block_text_and_bg_style_string($block, $fields)
{
	$background_color = $fields['background_color'];
	$text_color       = $fields['text_color'];

	// Build a valid style attribute for background and text colors.
	$styles = array('background-color: ' . $background_color, 'color: ' . $text_color);
	$style  = implode('; ', $styles);


	return $style;
}


/**
 * return a classes array for explosion in block template
 *
 * @param [type] $block
 * @return void
 */
function return_acf_block_base_css_classes_array($block)
{

	// base classes
	$classes = ['acf-block'];

	// add align classes

	// full-height (alignment)
	if (!empty($block['align'])) {
		$classes[] = 'align' . $block['align'];
	}
	// horizontal (text) alignment
	if (!empty($block['align_text'])) {
		$classes[] = 'has-text-align-' . $block['align_text'];
	}
	// vertical alignment
	if (!empty($block['align_content'])) {
		$classes[] = 'is-vertically-aligned-' . $block['align_content'];
	}
	// full-height attribute custom class
	if (!empty($block['full_height'])) {
		$classes[] = 'is-full-height';
	}
	// color classes
	if (!empty($block['backgroundColor'])) {
		$classes[] = 'has-background';
		$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
	}
	// color classes
	if (!empty($block['textColor'])) {
		$classes[] = 'has-text-color';
		$classes[] = 'has-' . $block['textColor'] . '-color';
	}

	// * always last, useful trick here to learn
	// custom classes from CMS
	if (!empty($block['className'])) {
		$classes = array_merge($classes, explode(' ', $block['className']));
	}

	return $classes;
}


if (!function_exists('nu__get_nav_menu')) {

	/**
	 * 	Return or echo a nav menu from a location or by id
	 *
	 * @param boolean $echo
	 * @param [type] $location
	 * @param [type] $menu
	 * @return void
	 */
	function nu__get_nav_menu($location = '', $echo = false, $menu = '')
	{

		// dynamically set args
		$args = array(
			// static $args:
			'container' => 'nav'                   // all nav menus use nav.navlinks pattern
			, 'container_class' => 'navlinks'        // all nav menus use nav.navlinks pattern
			, 'link_before' => '<span class="link-text">'              // wrap link text in <span> for accentUnderlines
			, 'link_after' => '</span>'              // wrap link text in <span> for accentUnderlines
			// dynamic $args:
			, 'echo' => $echo, 'theme_location' => $location, 'menu' => $menu
		);

		// return the menu call
		return wp_nav_menu($args);
	}
}


if (!function_exists('nu__getGoogleMapAddress')) {
	/**
	 * Undocumented function
	 *
	 * @param [type] $location
	 * @return void
	 */
	function nu__getGoogleMapAddress($location)
	{
		if ($location && !empty($location['address'])) {
			$return = '';
			$guides['address'] = '
				<a href="https://maps.google.com/maps/search/' . $location['address'] . '" title="opens location in google maps" target="_blank">%1$s%2$s%3$s%4$s%5$s%6$s</a>
			';

			$return .= sprintf(
				$guides['address'],
				!empty($location['street_number']) ? $location['street_number'] : '',
				!empty($location['street_name']) ? ' ' . trim($location['street_name']) : '',
				!empty($location['city']) ? '<br />' . $location['city'] : '',
				!empty($location['state']) ? ', ' . $location['state'] : '',
				!empty($location['post_code']) ? ' ' . $location['post_code'] : ''
				// ,!empty($location['country']) ? '' : '' // ? this tends to be disabled but ill leave it here
				,
				'' // ? this is just kind of placeholding a nothing for the country code (may be needed)
			);

			return $return;
		}
	}
}



if (!function_exists('nu__get_global_alerts')) {

	/**
	 * Undocumented function University Global Alerts
	 *
	 * @return void
	 */

	function nu__get_global_alerts()
	{

		// get global settings fields
		$global_theme_settings = get_field('global_settings', 'options');

		// maybe bail early...
		if (!isset($global_theme_settings)) {
			return;
		}

		$environment = $global_theme_settings['global_university_alerts']['environment'];
		$campus = strtolower($global_theme_settings['global_university_alerts']['affected_campus']);

		// 
		$alert_domain = (!empty($environment)) ? 'https://alerts.northeastern.edu/alert-panel/?campus=' : 'https://nustalerts.wpengine.com/alert-panel/?campus=';

		// 
		if ($campus) {
			$request = wp_safe_remote_get($alert_domain . $campus . '&cache=no');
			if (!is_wp_error($request)) {
				return $request['body'];
			}
		}
	}
}



if (!function_exists('nu__get_site_logo')) {

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function nu__get_site_logo()
	{
		$return = '';
		$guides = [];
		$guides['site-logo'] = '
			<a href="%1$s" title="Visit %2$s" class="logo%3$s">
				%4$s
			</a>
		';

		$return = sprintf(
			$guides['site-logo'],
			site_url(),
			get_bloginfo('name'),
			!empty(NU__Starter::$themeSettings['header']['site_logo']) ? ' logo--image' : ' logo--text',
			!empty(NU__Starter::$themeSettings['header']['site_logo']) ? NU__Starter::$themeSettings['header']['site_logo'] : get_bloginfo('name')
		);

		return $return;
	}
}





if (!function_exists('nu__get_pagination')) {

	/**
	 * Wrapper function for paginate_links for consistency
	 *
	 * @param string $custom_query
	 * @return void
	 */
	function nu__get_pagination($custom_query = '')
	{

		global $wp_query;

		if (!empty($custom_query)) {
			$wp_query = $custom_query;
		}

		$big = 999999; // need an unlikely integer
		$pagination = paginate_links(array(
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format' => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'total' => $wp_query->max_num_pages,
			'type' => 'list',
			'prev_text' => '<span class="prev"><</span>',
			'next_text' => '<span class="next">></span>',
			'before_page_number' => '<span class="pagenum">',
			'after_page_number' => '</span>',
			'mid_size' => 5
		));

		return $pagination;
	}
}
