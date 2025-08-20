<?php

/**
 *
 */
//

// * the pattern is the pattern
$return = [];
$guides = [];



$guides['fullscreen-takeover-menu'] = '
	<div class="takeover-menu-container">
		<div class="takeover-featured-story-container"></div>
		<div class="takeover-nav-container">
			%1$s
			%2$s
		</div>
	</div>
';
$guides['sidebar'] = '
	<div class="takeover-menu-container">
		<div>
			%1$s
			%2$s
			%3$s
		</div>
	</div>
';
// * guide string for the entire footer
$guides['footer'] = '
	<footer class="site-footer%6$s">
		%7$s
		<div class="container">
			<section class="footer-siteinfo">%1$s%3$s%4$s</section>
			<section class="footer-content">
				%8$s
				%2$s
				%5$s
			</section>
		</div>
	</footer>
';

// ? this is because google custom search provides its own main element
if (!is_page_template('templates/template-search.php')) {
	echo '</main>';
}


//
//
//
//
// $additional_menu_locations = '';
// $additional_menu_locations = apply_filters('nustart__before_page_footer', $additional_menu_locations);
// if (!empty($additional_menu_locations)) {
// 	echo $additional_menu_locations;
// }

// //
// $sidebar_nav_menu = has_nav_menu('sidebar') ? nu__get_nav_menu('sidebar') : '';
// if (!empty($sidebar_nav_menu)) {

// 	$sidebar_widget_area = '';
// 	if (is_active_sidebar('page-sidebar')) {
// 		ob_start();
// 		dynamic_sidebar('page-sidebar');
// 		$sidebar_widget_area = ob_get_clean();
// 	}


// 	$sidebar_toggle = '<div class="page-sidebar-toggle"><i class="fa-light fa-chevron-right"></i></div>';

// 	$sidebar = sprintf(
// 		$guides['sidebar'],
// 		$sidebar_toggle,
// 		$sidebar_nav_menu,
// 		$sidebar_widget_area
// 	);

// 	echo $sidebar;
// }
//
//
//
//



$footer_sidebar = '';
if (is_active_sidebar('footer-engagement')) {
	ob_start();
	dynamic_sidebar('footer-engagement');
	$footer_sidebar = ob_get_clean();
}

$social_icon_sidebar = '';
if (is_active_sidebar('footer-social')) {
	ob_start();
	dynamic_sidebar('footer-social');
	$social_icon_sidebar = ob_get_clean();
}


$light_dark_mode = !empty(NU__Starter::$themeSettings['footer']['light_mode']) ? ' is-style-light-background' : ' is-style-dark-background';


$prefooter_banner = !empty(NU__Starter::$themeSettings['footer']['site_footer']['prefooter_banner_image']) ? '<img src="' . NU__Starter::$themeSettings['footer']['site_footer']['prefooter_banner_image']['url'] . '" class="prefooter-banner" alt="the prefooter banner image" />' : '';

$return['footer'] = sprintf(
	$guides['footer'],
	nu__get_site_logo(),
	has_nav_menu('footer_1') ? nu__get_nav_menu('footer_1') : '',
	// deprecated - cut the old social google map stuff
	'',
	!empty($social_icon_sidebar) ? $social_icon_sidebar : '',
	$footer_sidebar,
	$light_dark_mode,
	$prefooter_banner,
	has_nav_menu('footer_2') ? nu__get_nav_menu('footer_2') : ''
);


echo !empty(NU__Starter::$themeSettings['footer']['site_footer']['status']) ? $return['footer'] : '<footer class="site-footer disabled"></footer>';



echo nu__get_global_alerts();

// // * Show the cookie warning only if it's a PROD build status
// if (NU__Starter::$themeSettings['dev']['build_status'] == 1) {
// 	NU__Starter::nu__showCookieWarning();
// }

NU__Starter::nu__globalFooterElement();

wp_footer();

echo '
</body>
</html>
';

//
