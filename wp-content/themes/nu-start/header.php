<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="Northeastern University, https://www.northeastern.edu" />
	<meta name="copyright" content="<?= date('Y'); ?>">
	<meta name="language" content="english" />
	<meta name="zipcode" content="<?php echo NU__Starter::nu__customGeoTagMetaZip(); ?>" />
	<meta name="city" content="<?php echo NU__Starter::nu__customGeoTagMetaCity(); ?>" />
	<meta name="state" content="<?php echo NU__Starter::nu__customGeoTagMetaState(); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="//www.google-analytics.com" rel="dns-prefetch">
	<!--  -->
	<!-- Our project just needs Font Awesome Light + Brands -->
	<!-- <script src="https://kit.fontawesome.com/4051479adf.js" crossorigin="anonymous"></script> -->

	<?php
	// todo: existing favicon stuff is super messy and old, so its wrapped up in a function
	echo NU__Starter::_get_all_favicons();


	// ? set any body classes manually
	$bodyClasses = [];
	$bodyClasses[] = NU__Starter::$themeSettings['appearance']['color_palette'] == 'dark' ? 'is-dark-header' : '';
	$bodyClasses[] = !empty(NU__Starter::$themeSettings['header']['status']) ? 'has-local-header' : '';
	$bodyClasses[] = !empty(NU__Starter::$themeSettings['global']['global_header_footer']['status']) ? 'has-nu-global-header-footer' : '';
	$bodyClasses[] = empty(NU__Starter::$themeSettings['dev']['build_status']) ? 'prod--disabled' : '';
	$bodyClasses[] = has_nav_menu('utility') ? 'has-utility-nav' : '';
	$bodyClasses[] = empty(NU__Starter::$themeSettings['dev']['build_status']) ? 'is-debug-mode' : '';
	$bodyClasses[] = NU__Starter::$themeSettings['global']['global_university_alerts']['affected_campus'] ? 'has-global-alerts' : '';
	$bodyClasses[] = has_nav_menu('sidebar') ? 'is-using-page-sidebar' : '';
	$bodyClasses[] = has_nav_menu('fullscreen-takeover') ? 'is-using-fullscreen-takeover' : '';
	$bodyClasses[] = !empty(NU__Starter::$themeSettings['search']['enable_site_search']) ? 'sitesearch-enabled' : '';
	$bodyClasses[] = !empty( get_field('site_logo_text_color') ) ? 'is-using-black-logo-text' : '';

	if ( isset( $post ) ) {
		$bodyClasses[] = $post->post_name;
	}


	// ? init wp head
	wp_head();


	// ? handle the required global header / footer scripts
	NU__Starter::nu__globalHeaderFooterScripts();


	// ? will write in the global tag manager scripts if the site is set to production
	// NU__Starter::nu__globalTagManagerScript();



	// ? will write in content of the custom analytics options textbox
	// todo: this is hacky at least validate the string
	// NU__Starter::nu__customTagManagerScripts();
	?>
</head>

<body <?php body_class($bodyClasses); ?>>
	<?php

	// ? enables hooking in content right after body opens (think for scripts etc)
	wp_body_open();


	// ? deprecated
	// * Show the cookie warning only if it's a PROD build status
	// if (NU__Starter::$themeSettings['dev']['build_status'] == 1) {
	// 	NU__Starter::nu__showCookieWarning();
	// }

	// if we want to use the university GATM
	NU__Starter::nu__globalTagManagerBodyScript();


	//

	// * the pattern is the pattern
	$return = '';
	$guides = [];

	// * Using the new Font Awesome icons for the mobile navicons
	$nu_mobileNavIcon = '<div class="navicons"><i class="fa-regular fa-bars"></i><i class="fa-regular fa-xmark"></i></div>';


	// * header nav guide string
	$guides['nav-header'] = '
		<header class="header">
			%6$s
			<a id="skiptomaincontent" href="#main"><span>Skip to content</span></a>
			%4$s
			<div class="container wide%5$s">
				%1$s
				' . $nu_mobileNavIcon . '
				<div class="navlinks--container">
					%2$s
					%3$s
				</div>
			</div>
		</header>
	';


	if (!empty(NU__Starter::$themeSettings['header']['status'])) {


		$submenu_reveal_type = !empty(NU__Starter::$themeSettings['header']['nav_menu_settings']['submenus_reveal']) ? ' submenus-open-using-' . NU__Starter::$themeSettings['header']['nav_menu_settings']['submenus_reveal'] : '';


		// * build the header
		$return .= sprintf(
			$guides['nav-header'],
			nu__get_site_logo(),
			has_nav_menu('header') ? nu__get_nav_menu('header') : '',
			get_search_form(['echo' => false]),
			has_nav_menu('utility') ? '<div class="utilitynav">' . nu__get_nav_menu('utility') . '</div>' : '',
			$submenu_reveal_type,
			NU__Starter::nu__globalHeaderElement(),
		);
	}

	// * Trent's code for showing screen width when we're in DEV mode
	if (!(NU__Starter::$themeSettings['dev']['build_status'])) {
		$return .= '<p id="dev-debug-panel" style=" position:fixed; background:rgba(0,0,0,0.7); color:#fff; top:200px; left:0; font-weight:bold; font-size:20px; z-index:99999999;"></p>';
	}

	echo $return;


	$additional_menu_locations = '';
	$additional_menu_locations = apply_filters('nustart__before_page_footer', $additional_menu_locations);
	if (!empty($additional_menu_locations)) {
		echo $additional_menu_locations;
	}

	//
	$sidebar_nav_menu = has_nav_menu('sidebar') ? nu__get_nav_menu('sidebar') : '';
	if (!empty($sidebar_nav_menu)) {

		$sidebar_widget_area = '';
		if (is_active_sidebar('page-sidebar')) {
			ob_start();
			dynamic_sidebar('page-sidebar');
			$sidebar_widget_area = ob_get_clean();
		}


		$sidebar_toggle = '<div class="page-sidebar-toggle"><i class="fa-light fa-chevron-right"></i></div>';

		$sidebar = sprintf(
			$guides['sidebar'],
			$sidebar_toggle,
			$sidebar_nav_menu,
			$sidebar_widget_area
		);

		echo $sidebar;
	}

	if (!is_page_template('templates/template-search.php')) {
		echo '<main id="main">';
	}



	?>
