<?php
// verify the location exists
$locations = get_nav_menu_locations();
// get the menu
$menu = get_term($locations['fullscreen-takeover'], 'nav_menu');
// get the menu items
$menu_items = wp_get_nav_menu_items($menu->term_id);
// filter down to only the top level itsm
$top_level_items = array_filter($menu_items, function ($item) {
	return empty($item->menu_item_parent);
});
// check for featured-image field, or FPO image
$has_takeover_metadata = array_map(function ($item) {
	return !empty(get_field('takeover_menu_item_metadata', $item->ID)['featured_image']) ? get_field('takeover_menu_item_metadata', $item->ID)['featured_image']['url'] : site_url() . '/wp-content/uploads/experience-magazine-featured-story.jpg';
}, $top_level_items);



$default_image_src = site_url() . '/wp-content/uploads/experience-magazine-featured-story.jpg';
$featured_image_src = $default_image_src;
//
//
$navSettings = !empty(get_field('navigation_settings', 'options')) ? get_field('navigation_settings', 'options') : '';
$adspace_story = (!empty($navSettings['adspace']['status']) && !empty($navSettings['adspace']['description']))
	? '<aside class="adspace-story"><div class="adspace-story-description">' . $navSettings['adspace']['description'] . '</div><div class="adspace-bg"></div></aside>'
	: '';
$adspace_image_src = (!empty($navSettings['adspace']['status']) && !empty($navSettings['adspace']['featured_image']))
	? $navSettings['adspace']['featured_image']['url']
	: '';

if (!empty($adspace_image_src)) {
	$featured_image_src = $adspace_image_src;
} else {
	wp_localize_script('child-theme-scripts', 'takeoverNavImages', array_values($has_takeover_metadata));
}

//
//
$guides['fullscreen-takeover-menu'] = '
	<div class="takeover-menu-container">
		<div class="takeover-featured-story-container" style="background-image: url(' . $featured_image_src . ')"></div>
		<div class="takeover-nav-container">
			%1$s
			%2$s
		</div>
		<aside class="takeover-banner-nav-container">%3$s</aside>
	</div>
';

//
$takeover_nav_menu = has_nav_menu('fullscreen-takeover') ? nu__get_nav_menu('fullscreen-takeover') : ''; // seems to be fine, but u can pull the func here
//
$takeover_banner_menu = has_nav_menu('takeover-banner') ? nu__get_nav_menu('takeover-banner') : ''; // seems to be fine, but u can pull the func here

if (!empty($takeover_nav_menu)) {
	$takeoverButtonsEl = '
		<aside class="takeover-nav">
			<a id="skiptomaincontent" href="#main"><span>Skip to content</span></a>

			<div class="takeover-nav-logo">' . nu__get_site_logo() . '</div>

			<nav class="takeover-nav-buttons" aria-label="main">

				<div class="takeover-nav-search"><button class="takeover-nav-search-button" aria-label="Toggle site search" role="button" href="' . site_url() . '/search"><i class="fa-light fa-search"></i><i class="fa-light fa-xmark"></i><span>Search</span></button>' . get_search_form(['echo' => false]) . '</div>
				<button class="takeover-nav-toggle" role="button" aria-label="Explore Northeastern: Toggle main site navigation" href="' . site_url() . '"><i class="fa-light fa-bars"></i><i class="fa-light fa-xmark"></i><span>Explore Northeastern</span></button>


			</nav>

			<div class="takeover-menu-container">
				<div class="takeover-featured-story-container" style="background-image: url(' . site_url() . '/wp-content/uploads/experience-magazine-featured-story.jpg)">
				' . $adspace_story . '
				</div>
				<div class="takeover-nav-container">
					' . $takeover_nav_menu . '
				</div>
				<div class="takeover-banner-nav-container">' . $takeover_banner_menu . '</div>
			</div>
		</aside>
	';

	echo $takeoverButtonsEl;
}
