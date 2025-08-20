<?php

/**
 * nu-start-child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nu-start-child
 */
//


add_action('after_setup_theme', 'extended_setup_theme');
function extended_setup_theme()
{

	register_nav_menu('fullscreen-takeover', 'Takeover');
	register_nav_menu('takeover-banner', 'Takeover Banner');
}


//
if (!function_exists('nustart__do_before_page_footer')) {
	function nustart__do_before_page_footer($return)
	{

		include(__DIR__ . '/function-partials/takeover-nav-menu.php');


		return $return;
	}
}



function remove_post_types()
{
	unregister_post_type('nu_events');
	unregister_post_type('nu_profiles');
	unregister_post_type('nu_programs');
	unregister_post_type('nu_projects');
	unregister_post_type('nu_people');
	unregister_post_type('nu_institutes');
}
add_action('init', 'remove_post_types', 20);


// Front end ONLY
add_action('wp_enqueue_scripts', 'nu__enqueue_scripts', 10, 1);


// Attach to BLOCK
// add_action( 'enqueue_block_assets', 'nu__enqueue_block_assets' );


// Back end ONLY
add_action( 'enqueue_block_editor_assets', 'nu__enqueue_block_editor_scripts' );


add_action('init', 'add_child_theme_block_styles');
function add_child_theme_block_styles()
{


	register_block_style(
		'nu-blocks/accordion',
		array(
			'name'         => 'large-center',
			'label'        => __('Large and Centered', 'nustart'),
		)
	);

	register_block_style(
		'eedee/block-gutenslider',
		array(
			'name'         => 'draggable',
			'label'        => __('Draggable Scrollbar', 'nustart'),
		)
	);

	register_block_style(
		'acf/posts-grid',
		array(
			'name'         => 'as-draggable-slider',
			'label'        => __('Draggable Scrollbar', 'nustart'),
		)
	);
	register_block_style(
		'acf/featured-ngn-stories',
		array(
			'name'         => 'as-draggable-slider',
			'label'        => __('Draggable Scrollbar', 'nustart'),
		)
	);

	// ? probably hoist worthy, i.e., bootstrap display headings
	register_block_style(
		'core/heading',
		array(
			'name'         => 'display',
			'label'        => __('Display', 'nustart'),
		)
	);


	// ? probably hoist worthy, i.e., bootstrap display headings
	register_block_style(
		'core/cover',
		array(
			'name'         => 'linear-gradient',
			'label'        => __('Linear Gradient (TBD)', 'nustart'),
		)
	);

	// ? probably hoist worthy, i.e., bootstrap display headings
	register_block_style(
		'acf/posts-grid',
		array(
			'name'         => 'accordion',
			'label'        => __('Accordion', 'nustart'),
		)
	);

	// ? probably hoist worthy, i.e., bootstrap display headings
	register_block_style(
		'acf/posts-grid',
		array(
			'name'         => 'sticky-first-post',
			'label'        => __('Sticky First Post', 'nustart'),
		)
	);

	// ? Large
	unregister_block_style('core/paragraph', 'large');

	//
	unregister_block_pattern('nu-start/nu_people-template-1');
}


/**
 * Enqueue frontend and editor JavaScript and CSS
 */
function nu__enqueue_scripts()
{

	wp_register_style('nu-flagship-fonts', get_stylesheet_directory_uri() . '/includes/build/css/fonts.css');


	$devsettings = get_field('developer_settings', 'option');
	if (empty($devsettings['disable_custom_fonts'])) {
		wp_enqueue_style('nu-flagship-fonts');
	}


	// deregister default jQuery
	// wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/__precomp/vendor/js/jquery.min.js', array(), null, true);

	//
	// * Add Jen's custom icon kit from FontAwesome
	wp_enqueue_script('custom-fontawesome-kit', 'https://kit.fontawesome.com/47ab1375dd.js', array(), null, false);

	//
	wp_enqueue_style('swiper-latest', get_stylesheet_directory_uri() . '/assets/swiper-js/8.4.7/swiper-bundle.min.css');
	wp_enqueue_style('swiper-scrollbar-latest', get_stylesheet_directory_uri() . '/assets/swiper-js/8.4.7/scrollbar.min.css');
	wp_enqueue_script('swiper-latest', get_stylesheet_directory_uri() . '/assets/swiper-js/8.4.7/swiper-bundle.min.js');

	// Enqueue block editor styles
	wp_enqueue_style(
		'child-theme-styles',
		get_stylesheet_directory_uri() . '/includes/build/css/child-theme-styles.css',
		['main'],
		filemtime(get_stylesheet_directory() . '/includes/build/css/child-theme-styles.css')
	);

	// wp_enqueue_style( 'swiper-css' );



	wp_enqueue_style(
		'nu--cookies-dialog',
		get_stylesheet_directory_uri() . '/includes/build/nu-cookies/bottom-dialog.css',
		['main'],
		filemtime(get_stylesheet_directory() . '/includes/build/nu-cookies/bottom-dialog.css')
	);
	wp_enqueue_style(
		'nu--cookies-disclaimer',
		get_stylesheet_directory_uri() . '/includes/build/nu-cookies/dialog-cookie-disclaimer.css',
		['main'],
		filemtime(get_stylesheet_directory() . '/includes/build/nu-cookies/dialog-cookie-disclaimer.css')
	);

	// register theme main menu nav scripts
	wp_register_script(
		'child-theme-scripts',
		get_stylesheet_directory_uri() . '/includes/build/js/child-theme-scripts-min.js',
		array('main'),
		filemtime(get_stylesheet_directory() . '/includes/build/js/child-theme-scripts-min.js'),
		true
	);
	wp_enqueue_script('child-theme-scripts');

	wp_register_script(
		'nu--cookies-analytics',
		get_stylesheet_directory_uri() . '/includes/build/nu-cookies/nueac-analytics-min.js',
		array('main'),
		filemtime(get_stylesheet_directory() . '/includes/build/nu-cookies/nueac-analytics-min.js'),
		true
	);
	wp_register_script(
		'nu--cookies-disclaimer',
		get_stylesheet_directory_uri() . '/includes/build/nu-cookies/cookie-disclaimer-min.js',
		array('main'),
		filemtime(get_stylesheet_directory() . '/includes/build/nu-cookies/cookie-disclaimer-min.js'),
		true
	);
	wp_enqueue_script('nu--cookies-disclaimer');
	wp_enqueue_script('nu--cookies-analytics');


	// Our NUStart GSAP App
	wp_register_script(
		'nustart--gsap-app',
		get_stylesheet_directory_uri() . '/includes/build/js/nustart-gsap-app-min.js',
		array('main'),
		filemtime(get_stylesheet_directory() . '/includes/build/js/nustart-gsap-app-min.js'),
		true
	);
	wp_enqueue_script('nustart--gsap-app');

}


function nu__enqueue_block_assets()
{
}
function nu__enqueue_block_editor_scripts()
{
	wp_enqueue_style(
		'child-theme-editor-styles',
		get_stylesheet_directory_uri() . '/includes/build/css/child-theme-editor-styles.css',
		[],
		filemtime(get_stylesheet_directory() . '/includes/build/css/child-theme-editor-styles.css')
	);
}


//Shortcode used in prefooter for year and credit
add_shortcode('year', 'currentYear');
function currentYear($atts)
{
	return '<p class="has-12-16-font-size">Copyright ' . date('Y') . ' Northeastern University</p>';
}


//Everything below here Trent added
// Threaded Comments
function enable_threaded_comments()
{
  if (!is_admin()) {
    if (is_singular() and comments_open() and (get_option('thread_comments') == 1)) {
      wp_enqueue_script('comment-reply');
    }
  }
}

// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support()
{
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status()
{
  return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments)
{
  $comments = array();
  return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu()
{
  remove_menu_page('edit-comments.php');
  remove_submenu_page('options-general.php', 'options-discussion.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect()
{
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url());
    exit;
  }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard()
{
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar()
{
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}
add_action('init', 'df_disable_comments_admin_bar');

// Remove comments from top admin bar
function my_admin_bar_render()
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'my_admin_bar_render');

function wpfme_has_sidebar($classes)
{
  if (is_active_sidebar('sidebar')) {
    // add 'class-name' to the $classes array
    $classes[] = 'has_sidebar';
  }
  // return the $classes array
  return $classes;
}
add_filter('body_class', 'wpfme_has_sidebar');

// Custom Comments Callback
function nudevcomments($comment, $args, $depth)
{
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);

  if ('div' == $args['style']) {
    $tag = 'div';
    $add_below = 'comment';
  } else {
    $tag = 'li';
    $add_below = 'div-comment';
  }
}

//
// Custom user (news-manager) role for News team. Role was created using user role editor plugin.
// This filter limits that role to only see the home page and hiding all other pages in the cms.
// I'm also using Adminimize plugin to hide the rest.
add_filter('parse_query', 'exclude_pages_from_admin');
function exclude_pages_from_admin($query)
{
	$current_user = wp_get_current_user();
	if (!empty($current_user->roles)) {
		$user_role = $current_user->roles[0];
		$allowed_role = 'news-manager';
		global $pagenow, $post_type;
		if ($user_role === $allowed_role && $pagenow == 'edit.php' && $post_type == 'page') {
			$query->query_vars['post__in'] = array('12');
		}
	}
}


//Deregister parent js and css
function dequeue_parent_script() {
  wp_dequeue_script( 'magnific' );
}
add_action( 'wp_print_scripts', 'dequeue_parent_script', 100 );


function dequeue_parent_styles() {
	wp_dequeue_style( 'magnific');
}
add_action( 'wp_enqueue_scripts','dequeue_parent_styles', 100 );
