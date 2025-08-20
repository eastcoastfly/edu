<?php

/**
 *
 */
//

/**
 * *	include the FilteringForm class extension
 */
if (!is_admin()) {
	include_once(get_template_directory() . '/classes/acf-blocks/posts-grid/filtering-form.php');
}



/**
 *
 * PostsGrid class destructures the *massive* complexity of this feature
 * ? note - the furthest vision of this feature is to slowly ride alongside then jump onto the wp core version of this (query/post-list/post-template blocks)
 */
class PostsGrid
{

	/**
	 * TODO: start refactoring this parent class to utilize extends
	 * ? referencing "shared" variables as public static var seems to be the best way at this time
	 */

	// ? variables that we always need
	public static $post_fields, $block, $post_object, $is_preview, $post_id;

	// ? variables we may or may not use
	public static $allowed_terms, $disallowed_terms, $the_post_type, $the_associated_taxonomies;

	// ? DRY destructured data
	public static $the_wp_query, $grid_items_str;

	// ? partial return strings
	public static $the_filtering_form_return_string;

	// internal methods will hoist data to these properties to avoid repetitive calls
	public $wp_query, $wp_query_args, $httpAPI, $queried_posts;

	// store various return strings or null values to handle these optional components
	public $pagination_str, $filtering_str;


	/**
	 * PostsGrid Class Constructor
	 * takes the exact same variables / args as an ACF block
	 *
	 * @param [type] $block
	 * @param [type] $content
	 * @param [type] $is_preview
	 * @param [type] $post_id
	 */
	function __construct($block, $content, $is_preview, $post_id)
	{


		// ? hoist all of the ACF Block variables
		self::$block = $block;
		self::$post_id = $post_id;
		self::$is_preview = $is_preview;

		// ? hoist the $fields for this post (contains this posts-grid block)
		self::$post_fields = get_fields();

		// determine auto/manual selection
		$is_autoselect = !empty(self::$post_fields['options']['autoselect']) ? true : false;
		self::$the_post_type = ($is_autoselect == true) ? self::$post_fields['autoselect_posts']['post_type'] : null;

		// todo: refactor these methods
		if (!empty($is_autoselect)) {
			$this->_build_auto_query();
		} else if (!$is_autoselect && !empty(self::$post_fields['select_posts'])) {
			$this->_build_manual_query();
		}

		// do the WP Query
		$this->wp_query = new WP_Query($this->wp_query_args);
		self::$the_wp_query = $this->wp_query;


		// maybe build pagination
		if (!empty(self::$post_fields['options']['pagination'])) {

			$foundCount = count($this->wp_query->posts);
			$perPage = $this->wp_query->found_posts;
			//
			//
			if ($perPage > $foundCount) {

				if (self::$post_fields['options']['pagination_type'] == 'loadmore') {
					$pagination = '
						<div class="btn__wrapper">
							<a href="#!" class="btn btn__primary" id="load-more">Load more</a>
						</div>
					';
				} else {
					$pagination = nu__get_pagination($this->wp_query);
				}
				$this->pagination_str = '<div class="pagination">' . $pagination . '</div>';
			}
		}


		if (!empty(self::$post_fields['options']['show_filter']) && !is_admin()) {
			FilteringForm::_handle_get_query();
			FilteringForm::_build_form_return_string(self::$post_fields);
		}


		// build all grid items
		$this->_build_griditems_return_string();


		// build entire block
		$this->_build_acf_block_output();
	}

	/**
	 *
	 *
	 *
	 */
	private function _build_acf_block_output()
	{

		// ? 		prepare the required block data for handling
		$blockData = [
			'post-type' => self::$the_post_type,
			'column-count' => self::$post_fields['options']['columns'],
			'grid-items' => self::$grid_items_str,
			'pagination' => $this->pagination_str,
			'filtering-form' => self::$the_filtering_form_return_string,
			'guide-string' => '
				%4$s
				<div class="nu__grid cols-%1$s" data-type="'.self::$the_post_type.'">
					<ul>
						%2$s
					</ul>
					%3$s
				</div>
			'
		];

		// ? 		build the final rendered block output
		$return = sprintf(
			$blockData['guide-string'],
			$blockData['column-count'],
			$blockData['grid-items'],
			$blockData['pagination'],
			$blockData['filtering-form'],
		);

		// 	?		hook for manipulation in the child theme
		// 	? 	parent theme simply returns this back unchanged
		$return = apply_filters('before_build_acf_block_output', $return, $blockData);

		//
		echo $return;
	}




	/**
	 * Runs the loop and sets a string of <li> items to a class variable
	 * - return oops item if nothing found (should never fail)
	 *
	 * @return void
	 */
	private function _build_griditems_return_string()
	{

		// ? reference the $wp_query stored in the class variable as it is often modified:
		// ? note to use self:: instead of $this because it may be called outside the constructor!
		$wp_query = self::$the_wp_query;

		// the pattern is the pattern...
		$guides = [];
		$return = '';


		// ? wp guidelines for arbitrarily large number fallback, or specific count number
		$count = 9999;
		$limit = !empty(self::$post_fields['autoselect_posts']['stop_after']) ? self::$post_fields['autoselect_posts']['stop_after'] : 9999;
		if (!empty($limit)) {
			$count = 0;
		}

		if (!$wp_query->have_posts()) {
			$return .= '<li class="grid-item broken"><p>There is currently nothing to show for this section.</p></li>';
		}
		// ? otherwise we do the loop here - note we are using a custom counter and limit to account for pagination
		else {

			// before looping the posts...
			$is_autoselect = !empty(self::$post_fields['options']['autoselect']) ? true : false;
			$selected_post_type = !empty(self::$post_fields['autoselect_posts']['post_type']) ? self::$post_fields['autoselect_posts']['post_type'] : '';

			if (!empty($is_autoselect) && $selected_post_type == 'nu_events') {
				$wp_query->posts = apply_filters('before_postsgrid_loop', $wp_query->posts);
			}


			while ($wp_query->have_posts() && $count < $limit) {

				// ? progress counter and move query to next post
				$count++;
				$wp_query->the_post();
				// ? honestly unsure if we need global scope!
				global $post;

				// TODO: comments help - keep commenting, but also refactor more noob
				// ? init the other class that returns an item string
				if (!empty($post->ID)) {
					$return .= PostsGrid_Item::init($post, self::$post_fields);
				}
			}
			// ? this is like undo for global $post, i think.
			wp_reset_postdata();
		}
		// ? instead of actually returning the compiled string, we will set it to a class level variable
		self::$grid_items_str = $return;
	}



	/**
	 * 		This handles manually selected items in a specific order
	 *
	 * @return void
	 */
	private function _build_manual_query()
	{

		//
		$this->wp_query_args = [
			'post_type'			=>		'any',
			'post_status' 		=> 		'publish',
			'posts_per_page' 	=> 		!empty(self::$post_fields['options']['pagination']) ? self::$post_fields['options']['per_page'] : 12,
			'paged'				=>		get_query_var('paged') ? absint(get_query_var('paged')) : 1,
			'post__in'			=>		self::$post_fields['select_posts'],
			'order'				=>		'ASC',
			'orderby'			=>		'post__in',
		];
		//

		$this->wp_query = new WP_Query($this->wp_query_args);
	}



	/**
	 * prepare a wp_query that auto-selects posts with optional additional arguments for taxonomies etc
	 *
	 * @return void
	 */
	private function _build_auto_query()
	{

		$selected_post_type = self::$post_fields['autoselect_posts']['post_type'];

		// ? starting here, we dynamically build the WP_Query we want
		$limit = !empty(self::$post_fields['autoselect_posts']['stop_after']) ? self::$post_fields['autoselect_posts']['stop_after'] : 9999;

		// destructure some data to make this more readable
		$posts_per_page = !empty(self::$post_fields['options']['pagination']) ? self::$post_fields['options']['per_page'] : $limit;
		$current_page_number = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

		// ? this is the required meaningful wp_query arguments
		$this->wp_query_args = [
			'post_type' 		=> 		!empty($selected_post_type) ? $selected_post_type : '',
			'post_status' 		=> 		'publish',
			'order'				=>		'ASC',
			'orderby'			=>		'title',
			'paged'				=>		$current_page_number,
			'posts_per_page' 	=> 		$posts_per_page,
		];

		// ? starting here, we dynamically build the taxonomy query we want, and append it to the main query

		// hoist allowed terms list
		self::$allowed_terms = self::$post_fields['autoselect_posts']['allowed_terms'];
		// hoist disallowed terms list
		self::$disallowed_terms = self::$post_fields['autoselect_posts']['disallowed_terms'];
		// hoist all the taxonomies registered to the selected post type
		self::$the_associated_taxonomies = get_object_taxonomies($selected_post_type, 'names');


		if (!empty(self::$allowed_terms)  || !empty(self::$disallowed_terms)) {

			$this->wp_query_args['tax_query'] = [
				'relation' 		=> 		'AND',
			];

			if (!empty(self::$allowed_terms)) {

				$allowed_operator = self::$post_fields['autoselect_posts']['allowed_operator'] == 'any' ? 'OR' : 'AND';

				$this->wp_query_args['tax_query']['allowed'] = [
					'relation' => $allowed_operator,
				];

				foreach (self::$allowed_terms as $term_obj) {
					//  bail early if the term doesn't belong to the post type
					if (!in_array($term_obj->taxonomy, self::$the_associated_taxonomies)) {
						continue;
					}
					// ? append the tax query (it overrides kind of like CSS)
					$this->wp_query_args['tax_query']['allowed'][] = [
						'taxonomy' 	=> $term_obj->taxonomy,
						'terms' 	=> $term_obj->term_id,
						'include_children' => false,
						'operator'	=> 'IN'
					];
				}
			}

			if (!empty(self::$disallowed_terms)) {
				$disallowed_operator = self::$post_fields['autoselect_posts']['disallowed_operator'] == 'any' ? 'OR' : 'AND';

				$this->wp_query_args['tax_query']['disallowed'] = [
					'relation' => $disallowed_operator,
				];
				foreach (self::$disallowed_terms as $term_obj) {
					//  bail early if the term doesn't belong to the post type
					if (!in_array($term_obj->taxonomy, self::$the_associated_taxonomies)) {
						continue;
					}

					// ? append the tax query (it overrides kind of like CSS)
					$this->wp_query_args['tax_query']['disallowed'][] = [
						'taxonomy' 	=> $term_obj->taxonomy,
						'terms' 	=> $term_obj->term_id,
						'include_children' => false,
						'operator'	=> 'NOT IN'
					];
				}
			}
		}


		if (!empty($_GET)) {
			$this->_build_the_tax_query_args();
		}

		$this->wp_query_args['meta_query'] = [];
		$this->_build_the_meta_query_args();




		wp_localize_script(
			'block-posts-grid',
			'block_default_query_args',
			$this->wp_query_args
		);
		wp_localize_script(
			'block-posts-grid',
			'postsgrid_block_settings',
			self::$block
		);
		wp_localize_script(
			'block-posts-grid',
			'postsgrid_block_fields',
			self::$post_fields
		);


		// append the auto-query to the initial wp query
		$this->wp_query_args = apply_filters('before_postsgrid_new_wpquery', $this->wp_query_args);
		$this->wp_query = new WP_Query($this->wp_query_args);
	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private function _build_the_tax_query_args()
	{


		if (empty(self::$the_associated_taxonomies)) {
			return;
		}

		$linkedTaxes = self::$the_associated_taxonomies;


		// append a new tax_query array for this term
		$this->wp_query_args['tax_query']['filtered_by'] = [
			'relation' => 'AND',
		];

		foreach ($linkedTaxes as $tax) {
			$name = str_replace('nu_', '', $tax);
			$matches = !empty($_GET[$name]) ? $_GET[$name] : '';

			if (is_array($matches)  && !empty($matches)) {

				$matching_ids = [];

				foreach ($matches as $matching_slug) {

					$matching_ids[] = get_term_by('slug', $matching_slug, $tax)->term_id;
				}


				$this->wp_query_args['tax_query']['filtered_by'][] = [
					'taxonomy'						=> 		$tax,
					'terms'								=> 		$matching_ids,
					'include_children'		=> 		false,
				];
			}
		}


		return;



		//
		//
		//
		foreach (self::$the_associated_taxonomies as $taxonomy_name) {

			// remove 'nu_' to match url
			$niceName = str_replace('nu_', '', $taxonomy_name);

			// check for matching terms
			$matching_terms = !empty($_GET[$niceName]) ? $_GET[$niceName] : '';

			// if there are matches (single/multi)
			if ($matching_terms) {




				// match and/or each term
				foreach ($matching_terms as $term) {
					// get term object
					$term_object = get_term_by('slug', $term, $taxonomy_name);
					// append the new tax_query
					$this->wp_query_args['tax_query']['filtered_by'][] = [
						'taxonomy'				=> 		$taxonomy_name,
						'terms'					=> 		$term_object->term_id,
						'include_children'		=> 		false,
					];
				}
			}
		}
	}

	/**
	 * 	Builds the [meta_query] for our WP_Query when posts are auto selected
	 *
	 * 	@return void
	 */
	private function _build_the_meta_query_args()
	{

		// which post type is selected
		$selectedPT = self::$post_fields['autoselect_posts']['post_type'];

		//
		// ? NEWS
		//
		if ($selectedPT == 'nu_news') {
			$this->wp_query_args['order'] = 'DESC';
			$this->wp_query_args['orderby'] = 'meta_value_num';
			$this->wp_query_args['meta_key'] = 'publication_info_date';
		}

		//
		// ? PEOPLE
		//
		if ($selectedPT == 'nu_people') {
			$this->wp_query_args['meta_query'] = [
				'last_name_clause'  => [
					'key'     => 'person_metadata_last_name',
					'compare' => 'EXISTS'
				],
				'first_name_clause' => [
					'key'     => 'person_metadata_first_name',
					'compare' => 'EXISTS'
				],
			];

			//
			$this->wp_query_args['orderby'] = [
				'last_name_clause'  => 'ASC',
				'first_name_clause' => 'ASC',
			];
		}

		//
		// ? EVENTS
		//
		if ($selectedPT == 'nu_events') {

			// check block settings for chronological value
			// (this may be past, upcoming, or all)
			$chronological = self::$post_fields['autoselect_posts']['chronological'];

			// if not all, toggle for past/upcoming ordering
			if ($chronological != "all") {

				// upcoming events ascend, while past events descend
				$this->wp_query_args['order'] = ($chronological == "upcoming") ? 'ASC' : 'DESC';
				// order by number (date format Ymd)
				$this->wp_query_args['orderby'] = 'meta_value_num';

				// order by the "happens on" value (multiple days is not rigged up)
				// also set compare, value, and type
				$this->wp_query_args['meta_query'] = array(
					array(
						'key' 			=> 'event_item_metadata_one_day_happens_on',
						'compare' => $chronological == "upcoming" ? '>=' : '<',
						'value' => date("Ymd"),
						'type' => 'DATE'
					),
				);
			}

			//
			// ? end of events
			//
		}


		//
		// * ADMINISTRATION
		//
		if ($selectedPT == 'nu_administration') {

			$this->wp_query_args['meta_query'] = [
				'first_name'  => [
					'key'     => 'leadership_details_first_name',
					'compare' => 'EXISTS'
				],
				'last_name'  => [
					'key'     => 'leadership_details_last_name',
					'compare' => 'EXISTS'
				],

			];

			//
			$this->wp_query_args['orderby'] = [
				'last_name'  => 'ASC',
				'first_name'  => 'ASC'
			];
		}



		//
		// * TRUSTEES
		//
		if ($selectedPT == 'nu_trustees') {

			$this->wp_query_args['meta_query'] = [
				'first_name'  => [
					'key'     => 'professional_details_first_name',
					'compare' => 'EXISTS'
				],
				'last_name'  => [
					'key'     => 'professional_details_last_name',
					'compare' => 'EXISTS'
				],

			];

			//
			$this->wp_query_args['orderby'] = [
				'last_name'  => 'ASC',
				'first_name'  => 'ASC'
			];
		}
		//
		return;
	}
}
