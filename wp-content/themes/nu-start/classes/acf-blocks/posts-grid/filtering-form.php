<?php

/**
 * 
 */
// 

/**
 * Undocumented class
 */
class FilteringForm extends PostsGrid
{

	private static $all_filtered_terms;



	/**
	 * This function will set the variable self::$the_filtering_form_return_string
	 *
	 * @return void
	 */
	public static function _handle_get_query()
	{

		if (is_admin() || empty($_GET)) {
			return;
		}

		$all_filtered_terms = [];

		foreach ($_GET as $taxonomy_filter => $terms) {

			$taxonomy = 'nu_' . $taxonomy_filter;
			
			foreach ($terms as $term) {
				$all_filtered_terms[] = !empty(get_term_by('slug', $term, $taxonomy)) ? get_term_by('slug', $term, $taxonomy)->term_id : '';
			}
		}


		// ? OK HERE WE HAVE FLATTENED ALL THE TERMS OOPS
		self::$all_filtered_terms = array_unique($all_filtered_terms);
	}


	public static function _build_form_return_string()
	{

		// ? the pattern is the pattern...
		$return = '';
		$guides = [];

		// 
		$form_navicon = '
			<div class="filtering-navicon">
				<span>Filter Results:</span>
				<i class="fa-regular fa-bars-filter"></i>
				<i class="fa-regular fa-xmark"></i>
			</div>
		';
		$form_submission = '
			<div class="submission">
				<button type="submit" value="Filter" class="button is-style-default">Filter</button><a href="' . get_permalink(self::$post_id) . '" class="is-style-outline button">Clear</a>
			</div>
		';

		// 
		$guides['form'] = '
			<div class="filteringform js__filteringform">
				' . $form_navicon . '
				<form name="postsgrid_filter-' . self::$block['id'] . '">
					<div class="filters">
						%1$s
					</div>
					' . $form_submission . '
				</form>
			</div>
		';

		// 
		$taxonomy_filters_return_string = '';

		// pluck away any empty taxonomies
		if (!empty(self::$allowed_terms)) {
			self::_handle_has_allowed_terms();
		}

		$taxonomy_filters_return_string = self::_return_the_taxonomy_filters();

		// 
		$return = sprintf(
			$guides['form'],
			$taxonomy_filters_return_string
		);

		// ? hoist the final return string for the filteringform (could be filtered here!)
		self::$the_filtering_form_return_string = $return;


		// 
		// 
		// 
	}







	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private static function _handle_has_allowed_terms()
	{
		// ? include an array of all the posts returned by the WP Query
		$all_posts = array_column(self::$the_wp_query->posts, 'ID');
		// ? next we get a list of all terms used by any of the returned posts
		$all_possible_terms_to_filter = wp_get_object_terms($all_posts, self::$the_associated_taxonomies);
		// ? using that, we isolate the possible taxonomies
		$all_possible_taxonomies_to_filter = array_unique(array_column($all_possible_terms_to_filter, 'taxonomy'));
		self::$the_associated_taxonomies = $all_possible_taxonomies_to_filter;
	}




	private static function _return_option_element_string($term)
	{

		// the pattern is the pattern...
		$return = '';
		$guides = [];
		// 
		$guides['option'] = '<option value="%2$s"%3$s>%1$s</option>';

		$return .= sprintf(
			$guides['option'],
			$term->name,
			$term->slug,
			in_array($term->term_id, (array) self::$all_filtered_terms) ? ' selected="selected"' : ''
		);

		return $return;
	}



	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private static function _return_the_taxonomy_filters()
	{

		// disabled in block editor
		if (is_admin()) {
			return;
		}

		// required taxonomies list
		if (empty(self::$the_associated_taxonomies)) {
			return;
		}

		// 
		$guides['taxonomy-filter'] = '
			<div class="filters-filter is-terms-select" data-taxonomy="%4$s">
				<label for="%4$s">%2$s</label>
				<select name="%4$s[]" data-placeholder="Choose %2$s:" multiple="multiple">
					%3$s
				</select>
			</div>
		';
		$guides['taxonomy-filter'] = '
			<div class="filters-filter is-terms-select" data-taxonomy="%4$s">
				<label for="%4$s">%2$s</label>
				<select name="%4$s[]" multiple="multiple">
					%3$s
				</select>
			</div>
		';
		$return = '';

		// loop through each taxonomy in this post type
		foreach (self::$the_associated_taxonomies as $taxonomy_name) {


			$taxonomy = get_taxonomy($taxonomy_name);

			// get terms associated with taxonomy that have posts
			$terms = get_terms([
				'taxonomy' => $taxonomy_name,
				'hide_empty' => true,
			]);


			$select_element_string = '';
			// if there are possible term matches
			if (!empty($terms) && !is_wp_error($terms)) {

				// $select_element_string .= '<option value=""></option>';

				foreach ($terms as $term) {
					$select_element_string .= self::_return_option_element_string($term);
				}
			}

			// if there are no option elements we can stop here to avoid rending an empty <select>
			if( empty($select_element_string) ){
				continue;
			}

			$trimName = get_post_type_object(self::$post_fields['autoselect_posts']['post_type'])->labels->name;
			$trimmed_label = str_replace($trimName . ' ', '', $taxonomy->labels->name) . ':';


			// ? next, we concat all the filters into a return string like with the options
			$return .= sprintf(
				$guides['taxonomy-filter'],
				sanitize_title($taxonomy->label),
				$trimmed_label,
				$select_element_string,
				str_replace('nu_','',$taxonomy->name)
			);


			
			
		}



		return $return;
	}
}
