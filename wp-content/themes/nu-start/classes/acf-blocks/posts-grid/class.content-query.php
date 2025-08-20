<?php
/* 
	Breakdown:

	- Called from the Block
	- Takes $args from Block / Post
	- Takes $args from $_GET / $_POST etc...
	- May take MANUALLY input $args from search template etc...
	
	Arguments for this constructor may include...
	- ACF Fields for the Block
	- Hardcoded default values needed to run the Query



	Steps:
	1. process the $args we need for this query
	2. build a functional wp_query
	3. run the query and hold the result


 */
// 

class ContentQuery
{



	function __construct()
	{
		add_action('wp_ajax_ajax_query_for_posts', ['ContentQuery', 'ajax_query_for_posts'], 10, 1);
		add_action('wp_ajax_nopriv_ajax_query_for_posts', ['ContentQuery', 'ajax_query_for_posts'], 10, 1);
	}

	/*  */
	public static function ajax_query_for_posts()
	{
		
		$blockFields = $_POST['blockFields'];
		$queryArgs = $_POST['queryArgs'];
	
		$return = '';
		$wp_query = new WP_Query($queryArgs);
		// The Loop
		if ($wp_query->have_posts()) {
			ob_start();
			while ($wp_query->have_posts()) {
	
				global $post;
				$wp_query->the_post();
				$blockFields['is-loaded-by-ajax'] = 'true';
	
				$return .= PostsGrid_Item::init($post, $blockFields);
			}
			ob_get_clean();
		} else {
			// no posts found
		}
		wp_reset_postdata();
	
		$result = [
			'max' => $wp_query->max_num_pages,
			'html' => $return,
		];
	
		echo json_encode($result);

		exit;
	}
}
$cQuery = new ContentQuery;
