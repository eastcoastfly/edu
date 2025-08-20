<?php
// 
// 
// 
// 
if (!function_exists('nu__get_search_results')) {
	function nu__get_search_results()
	{

		$guides['results'] = '
			<div class="acf-block posts-grid homepage-posts-grid">
				<div class="nu__grid cols-1">
					<ul>
						%1$s
					</ul>
					%2$s
				</div>
			</div>
		';

		// Individual search result items
		$result_items = '';
		global $post;
		global $wp_query;

		if (have_posts() && is_search() && !empty(get_search_query())) {
			while (have_posts()) {
				the_post();


				$grid_item_conditional_class_array = [
					'grid-item',
					$post->post_type,
					$is_the_teaser_layout,
					$is_the_cover_image_aspect_ratio,
					$is_the_cover_image_alignment,
				];
				$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

				// get the excerpt,
				$is_the_post_excerpt_content = '';
				if (has_excerpt($post->ID)) {
					//  or the excerpt override,
					$is_the_post_excerpt_content = !empty($fields['overrides']['description']) ? $fields['overrides']['description'] : get_the_excerpt();
				}
				// get the excerpt length, or default of 55
				$is_the_excerpt_length = !empty($item_styles['truncate_excerpt']) ? $item_styles['truncate_excerpt'] : 25;
				// build our excerpt element including the trim,
				//  or nothing
				$is_the_post_excerpt = (!empty($is_the_post_excerpt_content)) ? '<p class="post-excerpt">' . wp_trim_words($is_the_post_excerpt_content, $is_the_excerpt_length) . '</p>' : '';
				//  or use the FULL override description (preserve tags)
				if (!empty($fields['overrides']['description'])) {
					$is_the_post_excerpt = (!empty($fields['overrides']['description'])) ? '<div class="post-excerpt">' . $fields['overrides']['description'] . '</div>' : '';
				}

				// get the post title,
				//  or the override, wrapped in <p><span> to support an inline underline of the text
				$is_the_post_title_content = !empty($fields['overrides']['title']) ? $fields['overrides']['title'] : get_the_title();
				$is_the_post_title = '<p class="post-title"><span>' . $is_the_post_title_content . '</span></p>';
				$is_the_cover_image = !empty($item_styles['display_featured_image']) && has_post_thumbnail() ? '<figure>' . get_the_post_thumbnail() . '</figure>' : '<figure class="image-404"></figure>';
				$is_the_href_value = !empty($fields['custom_permalink_redirect']) ? esc_url($fields['custom_permalink_redirect']) : esc_url(get_the_permalink());
				$is_the_target_attribute = !empty($fields['custom_permalink_redirect']) ? ' target="_blank"' : '';


				// * Formulate a breadcrumb for the search result items
				$is_the_breadcrumb = '<p class="post-breadcrumb">' . parse_url(get_site_url(), PHP_URL_HOST) . ' <i class="fa-regular fa-chevron-right fa-xs"></i> ';

				// * Find the ancestors of the search result page
				$parents = get_post_ancestors($post->ID);

				// * Add each page ancestor to the breadcrumb
				if ($parents) {
					for ($i = (count($parents) - 1); $i >= 0; $i--) {
						get_the_title($parents[$i]);
						$is_the_breadcrumb .= get_the_title($parents[$i]) . ' <i class="fa-regular fa-chevron-right fa-xs"></i> ';
					}
				}

				$is_the_breadcrumb .= get_the_title($post->ID) . '</p>';

				$is_the_basic_excerpt = '<p class="post-excerpt">' . wp_strip_all_tags(wp_trim_words(get_the_excerpt($post->ID), 30)) . '</p>';

				// 
				$is_the_icon_class = (!empty($is_the_target_attribute)) ? ' fa-arrow-up-right-from-square' : ' fa-arrow-right';
				$is_the_icon_element = '<div class="is-hanging-icon"><i class="fa-light' . $is_the_icon_class . '"></i></div>';


				$is_the_post_categories = '';
				$categories = get_the_terms($post->ID, 'category');
				if (!empty($categories) && !is_wp_error(($categories))) {
					$is_the_post_categories = '<p class="featured-tags">';
					foreach ($categories as $category) {
						$is_the_post_categories .= '<span>' . $category->name . '</span>';
					}
					$is_the_post_categories .= '</p>';
				}

				$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);
				$guides['grid-item-default'] = '
					<li class="' . $grid_item_conditional_classes . '">
						<a class="contains-clickable-area" href="%1$s"' . $is_the_target_attribute . '%2$s></a>
							%3$s
							<div class="grid-item-content">
								%7$s
								%4$s
								%5$s
								%6$s
							</div>
					</li>
				';

				// 
				$result_items .= sprintf(
					$guides['grid-item-default'],
					$is_the_href_value,
					$is_the_title_attribute,
					$is_the_cover_image,
					$is_the_post_title,
					$is_the_breadcrumb,
					$is_the_basic_excerpt,
					$is_the_icon_element,
					// 
					$is_the_post_categories
				);
			}
		}
		$pagination = (!empty(get_search_query())) ? '<div class="pagination">' . nu__get_pagination() . '</div>' : '';


		$return = sprintf(
			$guides['results'],
			$result_items,
			$pagination
		);

		return $return;
	}
}
