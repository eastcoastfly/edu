<?php

/**
 *
 *
 * 	Setup The Theme
 *
 *
 */
class SetupTheme
{

	// ?
	public static function _init()
	{
		//
		//
		if (function_exists('acf_add_options_page')) {

			//
			//
			acf_add_options_page(array(
				'page_title' 	=> 'Theme Settings',
				'menu_title'	=> 'Theme Settings',
				'menu_slug' 	=> 'nu_settings',
				'capability'	=> 'edit_private_posts',
				'position' 		=> "2.2",
			));


			//
			//
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Settings',
				'menu_title'	=> 'Settings',
				'parent_slug'	=> 'nu_settings',
			));
		}


		add_action('login_head', 'SetupTheme::customize_login_screen');
		add_filter('login_headerurl', function () {
			return get_bloginfo('url');
		});
		add_filter('login_errors', function () {
			return 'Invalid login.';
		});

		add_filter('walker_nav_menu_start_el', 'add_icons_to_submenu_parents', 10, 4);
		function add_icons_to_submenu_parents($output, $item, $depth, $args)
		{
			//Only add class to 'top level' items on the 'primary' menu.
			if ('header' == $args->theme_location || 'utility' == $args->theme_location) {
				if (in_array("menu-item-has-children", $item->classes)) {
					$output = $output . '<button aria-label="expand the ' . esc_html(strtolower($item->title)) . ' submenu" class="navlinks-showsubmenu"></button>';
				}
			}
			return $output;
		}

		//
		add_action('wp_enqueue_scripts', 'SetupTheme::enqueue_scripts');

		//
		add_action('admin_enqueue_scripts', 'SetupTheme::admin_enqueue_scripts');

		//
		add_action('after_setup_theme', 'SetupTheme::after_setup_theme');

		//
		add_action('enqueue_block_editor_assets', 'SetupTheme::block_editor_scripts');

		//
		add_action('init', 'SetupTheme::init');


		//
		add_action('widgets_init', 'SetupTheme::nu__register_sidebars');

		//
		add_action('admin_menu', 'SetupTheme::_do_admin_menu_handler');


		//
		SetupTheme::clean_head();
	}


	public static function customize_login_screen()
	{
		echo '<style type="text/css">';
		include(get_template_directory() . '/__precomp/build/css/login.css');
		echo '</style>';
	}
	public static function _do_admin_menu_handler()
	{


		// hide from non-admins
		if (!current_user_can('manage_options')) {
			return;
		}

		// ? add reusable blocks to the main menu to allow editor access
		add_menu_page(
			'Reusable Blocks',
			'Reusable Blocks',
			'manage_options',
			'edit.php?post_type=wp_block',
			'',
			'dashicons-editor-table',
			'3.1'
		);

		// ? add block editor menus (wp_navigation) but its kind of junk
		add_menu_page(
			'Block Editor Menus',
			'Block Editor Menus',
			'manage_options',
			'edit.php?post_type=wp_navigation',
			'',
			'dashicons-hammer',
			'3.2'
		);
	}





	// ?
	public static function enqueue_scripts()
	{
		SetupTheme::_do_enqueueStyles();
		SetupTheme::_do_enqueueScripts();
	}


	// ?
	public static function  block_editor_scripts()
	{

		// fonts only loaded in the block editor (for blocks)
		wp_enqueue_style('nu-block-editor-fonts', get_template_directory_uri() . '/__precomp/build/css/fonts.css');

		// stylesheet only loaded in the block editor (for blocks)
		// ? this lets us "ram in" a stylesheet; but we already have the hook in add_theme_support( 'editor-styles' );
		wp_enqueue_style('nu-blocks-styles', get_template_directory_uri() . '/__precomp/build/css/blocks-styles.css', [], filemtime(get_template_directory() . '/__precomp/build/css/blocks-styles.css'));

		// scripts only loaded in the block editor (for blocks)
		wp_enqueue_script('nu-block-editor', get_template_directory_uri() . '/__precomp/build/js/editor-min.js', array('wp-blocks'), filemtime(get_template_directory() . '/__precomp/build/js/editor-min.js'), true);
	}


	// ?
	public static function after_setup_theme()
	{

		// make theme available for translation.
		load_theme_textdomain('nu-start', get_template_directory() . '/languages');


		// add_filter('acf/settings/save_json', function () {
		// 	return get_template_directory() . '/acf-json';
		// });

		add_filter('acf/settings/load_json', function ($paths) {
			$paths = array(get_template_directory() . '/acf-json');

			if (is_child_theme()) {
				$paths[] = get_stylesheet_directory() . '/acf-json';
			}

			return $paths;
		});


		// add / remove theme supports
		SetupTheme::_manage_theme_supports();

		// register our nav menus
		register_nav_menus(array(
			'header' => esc_html__('Header', 'nu-start'), 'footer_1' => __('Footer', 'nu-start'), 'footer_2' => __('Footer (2nd column)', 'nu-start'), 'utility' => __('Utility Nav', 'nu-start'), 'sidebar' => __('Sidebar', 'nu-start')
		));
	}

	/**
	 * sets up our block-based widget areas aka. "sidebars"
	 *
	 * @return void
	 */
	public static function nu__register_sidebars()
	{

		register_sidebar(
			array(
				'id'            => 'footer-engagement',
				'name'          => __('Footer Area Engagement'),
				'description'   => __('Create an engagement area in the footer, like a form.'),
				'before_widget' => '<div id="%1$s" class="widget nu__footer-sidebar %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'footer-social',
				'name'          => __('Footer Area Social'),
				'description'   => __('Create social media links area.'),
				'before_widget' => '<div id="%1$s" class="widget nu__footer-sidebar %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'page-sidebar',
				'name'          => __('Page Sidebar'),
				'description'   => __('A widget area for the page sidebar'),
				'before_widget' => '<div id="%1$s" class="widget nu__page-sidebar %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
			)
		);
	}

	// ?
	public static function init()
	{
		register_taxonomy_for_object_type('post_tag', 'page');
		register_taxonomy_for_object_type('category', 'page');
	}


	// ?
	public static function _do_enqueueScripts()
	{

		// register main theme scripts
		wp_register_script(
			'main',
			get_template_directory_uri() . '/__precomp/build/js/main-min.js',
			array('jquery'),
			filemtime(get_template_directory() . '/__precomp/build/js/main-min.js'),
			true
		);

		// register theme main menu nav scripts
		wp_register_script(
			'nav',
			get_template_directory_uri() . '/__precomp/build/js/nav-min.js',
			array(),
			filemtime(get_template_directory() . '/__precomp/build/js/nav-min.js'),
			true
		);

		// register magnific scripts
		wp_register_script(
			'magnific',
			get_template_directory_uri() . '/__precomp/vendor/js/jquery.magnific-popup.min.js',
			array(),
			false,
			true
		);

		// register select2 core scripts
		wp_register_script(
			'selectize',
			get_template_directory_uri() . '/__precomp/vendor/js/selectize.min.js',
			array(),
			false,
			true
		);

		// register gsap scripts
		// wp_register_script(
		// 	'gsap-js',
		// 	get_template_directory_uri() . '/__precomp/vendor/js/gsap.min.js',
		// 	array(),
		// 	false,
		// 	true
		// );
		// // register gsap scripts
		// wp_register_script(
		// 	'gsap-st-js',
		// 	get_template_directory_uri() . '/__precomp/vendor/js/ScrollTrigger.min.js',
		// 	array(),
		// 	false,
		// 	true
		// );

		// wp_enqueue_script('gsap-js');
		// wp_enqueue_script('gsap-st-js');
		//
		wp_enqueue_script('selectize');
		wp_enqueue_script('magnific');
		wp_enqueue_script('nav');
		wp_enqueue_script('main');

		wp_enqueue_script('block-posts-grid', get_template_directory_uri() . '/__precomp/build/js/blocks/posts-grid-min.js', array('jquery'), '', true);
		wp_enqueue_script('block-navigation', get_template_directory_uri() . '/__precomp/build/js/blocks/nav-block-min.js', array('jquery'), '', true);



		//
		//
		// ! COMPLETELY NOT READY
		wp_localize_script(
			'block-posts-grid',
			'postsgrid_ajax_object',
			array(
				'phpversion' => PHP_VERSION,
				'ajaxurl'    => admin_url('admin-ajax.php'),
				'ajax_nonce' => wp_create_nonce('postsgrid_ajax_object')
			)
		);
	}

	// ?
	public static function _do_enqueueStyles()
	{


		// deregister default jQuery
		wp_deregister_script('jquery');
		// register jQuery v3.4.1
		wp_enqueue_script('jquery', get_template_directory_uri() . '/__precomp/vendor/js/jquery.min.js', array(), null, true);

		// register fonts
		wp_register_style('nu-site-fonts', get_template_directory_uri() . '/__precomp/build/css/fonts.css');
		//
		if (empty(NU__Starter::$themeSettings['global']['global_header_footer']['status'])) {
			wp_enqueue_style('nu-site-fonts');
		}

		// register magnific popup
		wp_register_style(
			'magnific',
			get_template_directory_uri() . '/__precomp/vendor/css/magnific-popup.css'
		);

		// ? register selectize boostrap 5 stylesheet
		wp_register_style(
			'selectize',
			get_template_directory_uri() . '/__precomp/vendor/css/selectize.bootstrap5.css'
		);

		// register main theme stylesheet
		wp_register_style(
			'main',
			get_template_directory_uri() . '/__precomp/build/css/main.css',
			array(),
			filemtime(get_template_directory() . '/__precomp/build/css/main.css')
		);

		// register patterns stylesheet
		wp_register_style(
			'pattern-styles',
			get_template_directory_uri() . '/__precomp/build/css/pattern-styles/pattern-styles.css',
			array(),
			filemtime(get_template_directory() . '/__precomp/build/css/pattern-styles/pattern-styles.css')
		);


		// enqueue the registered styles
		wp_enqueue_style('magnific');
		wp_enqueue_style('selectize');
		wp_enqueue_style('main');
		wp_enqueue_style('pattern-styles');
	}


	// ?
	public static function admin_enqueue_scripts()
	{



		//
		wp_register_style(
			'admin',
			get_template_directory_uri() . '/__precomp/build/css/admin.css',
			array(),
			filemtime(get_template_directory() . '/__precomp/build/css/admin.css')
		);
		//
		wp_enqueue_style('admin');
		//
		wp_enqueue_script('admin');
	}


	/**
	 * add/remove for actions and filters to clean up the wp_head action and the <head> on the front end
	 *
	 * @return void
	 */
	public static function clean_head()
	{

		// add / remove actions
		remove_action('wp_head', 'rsd_link'); 									// remove really simple discovery link
		remove_action('wp_head', 'wp_generator'); 								// remove wordpress version
		remove_action('wp_head', 'feed_links', 2); 								// remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
		remove_action('wp_head', 'feed_links_extra', 3); 						// removes all extra rss feed links
		remove_action('wp_head', 'index_rel_link'); 							// remove link to index page
		remove_action('wp_head', 'wlwmanifest_link'); 							// remove wlwmanifest.xml (needed to support windows live writer)
		remove_action('wp_head', 'start_post_rel_link', 10, 0); 				// remove random post link
		remove_action('wp_head', 'parent_post_rel_link', 10, 0); 				// remove parent post link
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); 			// remove the next and previous post links
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); 				// Remove shortlink
		remove_action('wp_head', 'wp_resource_hints', 2);
		remove_action('wp_print_styles', 'print_emoji_styles');


		// add / remove filters
		add_filter('emoji_svg_url', '__return_false');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
	}



	// ?
	/**
	 * 	manage wordpress theme supports i.e. add_theme_support('custom-logo')
	 *	see the /theme.json as well
	 * @return void
	 */
	public static function _manage_theme_supports()
	{

		// ? theme supports that are unrelated to gutenberg
		add_post_type_support('page', 'excerpt');						// let pages have excerpts
		add_theme_support('title-tag'); 								// lets WP handle <document> title
		add_theme_support('customize-selective-refresh-widgets'); 	// Add theme support for selective refresh for widgets.
		add_theme_support('body-open');								// enable wp_body_open filter
		add_theme_support('automatic-feed-links'); 					// add RSS feed links to head
		add_theme_support('custom-logo', [								// enable custom logo (not really required we use svg)
			'height'               => 100,
			'width'                => 300,
			'flex-width'           => true,
			'flex-height'          => true,
			'unlink-homepage-logo' => true,
		]);
		add_theme_support('post-formats', array(						// enable post-formats
			'link',
			'aside',
			'gallery',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		));
		add_theme_support('post-thumbnails'); 						// enable support for post thumbnails on posts and pages
		set_post_thumbnail_size('720','720');							// hi-res but small-ish thumbnail size
		add_theme_support('responsive-embeds');						// enable responsive embeds
		add_theme_support('html5', array( 								// enable html5 support everywhere
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		));

		// ? theme supports related to the block editor
		add_theme_support('disable-custom-font-sizes');				// disable wp core custom font sizes
		add_theme_support('disable-custom-colors');						// disable wp core custom colors
		add_theme_support('disable-custom-gradients');				// disable wp core custom gradients
		add_theme_support('align-wide');											// enable wide alignment for blocks
		add_theme_support('custom-spacing');									// opt-in to letting blocks set padding
		//
		add_theme_support('admin-bar', array('callback' => '__return_false')); // stop admin bar from pushing html element

		//
		remove_theme_support('core-block-patterns'); 					// remove the "patterns" library
		add_filter('should_load_remote_block_patterns', '__return_false');

		// remove_theme_support( 'block-templates' );
		/*
			* this only goes in the block editor!
			! NOTE
			? From WP Documentation:

			"To make sure your styles are applied only to the content of the editor,
				we automatically transform your editor styles by selectively rewriting or adjusting certain CSS selectors.
			This also allows the block editor to leverage your editor style in block variation previews.
				For example, if you write body { ... } in your editor style, this is rewritten to .editor-styles-wrapper { ... }"
			! This also means that you should not target any of the editor class names directly.
		 */
		add_theme_support('editor-gradient-presets', []); // remove the preset gradients in wp core
		add_theme_support('editor-styles');
		add_editor_style(get_template_directory_uri() . '/__precomp/build/css/editor-style.css');
		add_editor_style('__precomp/build/css/editor-style.css');
	}
}
SetupTheme::_init();
