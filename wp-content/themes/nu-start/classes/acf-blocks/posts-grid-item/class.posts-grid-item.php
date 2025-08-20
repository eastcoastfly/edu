<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}


class PostsGrid_Item
{

	//
	private static $post;
	//
	private static $fields;
	//
	private static $gridOptions;


	/**
	 * initialize this posts grid item (used in the wordpress loop)
	 *
	 * @param [type] $post - the post object set up inside the loop
	 * @param [type] $gridOptions - the field group of the calling parent posts grid (style and other options set here)
	 * @return void
	 */
	public static function init($post, $gridOptions)
	{
		// get fields for the post or page calling this block
		$fields = get_fields($post->ID);
		// the post type
		$item_styles = !empty($gridOptions['item_style']) ? $gridOptions['item_style'] : '';
		/*
				EXCERPT
		*/
		// get the post title,
		//  or the override, wrapped in <p><span> to support an inline underline of the text
		$is_the_post_title_content = !empty($fields['overrides']['title']) ? $fields['overrides']['title'] : get_the_title();
		$is_the_post_title = '<div class="post-title"><span>' . $is_the_post_title_content . '</span></div>';
		// get the excerpt,
		$is_the_post_excerpt_content = '';
		if (has_excerpt($post->ID)) {
			//  or the excerpt override,
			$is_the_post_excerpt_content = !empty($fields['overrides']['description']) ? $fields['overrides']['description'] : get_the_excerpt();
		}
		// get the excerpt length, or default to 20 words
		$is_the_excerpt_length = !empty($item_styles['truncate_excerpt']) ? $item_styles['truncate_excerpt'] : 20;

		// build our excerpt element including the trim,
		//  or nothing
		$is_the_post_excerpt = (!empty($is_the_post_excerpt_content)) ? '<p class="post-excerpt">' . wp_trim_words($is_the_post_excerpt_content, $is_the_excerpt_length) . '</p>' : '';
		//  or use the FULL override description (preserve tags)
		if (!empty($fields['overrides']['description'])) {
			$is_the_post_excerpt = (!empty($fields['overrides']['description'])) ? '<div class="post-excerpt">' . $fields['overrides']['description'] . '</div>' : '';
		}
		/*
			COVER IMAGE
		*/
		// image alignment is L/R/Alternate;
		// (meant for the 1-column horizontal view)
		$is_the_cover_image_alignment = !empty($item_styles['image_alignment']) ? ' has-image-align-' . $item_styles['image_alignment'] : '';
		// get the cover image or a 404 placeholder
		// $is_the_cover_image = '<figure>' . get_the_post_thumbnail() . '</figure>';
				$is_the_cover_image = !empty($item_styles['display_featured_image']) && has_post_thumbnail() ? '<figure>' . get_the_post_thumbnail() . '</figure>' : '<figure class="image-404"></figure>';
		/*
			TEASER CONDITIONAL CLASSES
		*/
		// check if the teaser orientation,
		// horizontal:row or vertical:column
		$is_the_teaser_layout = !empty($item_styles['orientation']) ? ' has-layout-' . $item_styles['orientation'] : '';
		// get the aspect ratio
		// (default state is set to auto)
		$is_the_cover_image_aspect_ratio = !empty($item_styles['display_featured_image']) ? ' has-' . $item_styles['image_dimensions'] . '-cover-image' : '';
		/*
			TEASER ELEMENTS
		*/
		//
		//  get the capitalcase post type name (label)
		$is_the_post_type_label = !empty(get_post_type_object($post->post_type)->labels->singular_name) ? '<span class="is-post-type-label has-14-20-font-size">' . get_post_type_object($post->post_type)->labels->singular_name . '</span>' : '';

		// the href value of the permalink or override
		$is_the_href_value = !empty($fields['custom_permalink_redirect']) ? esc_url($fields['custom_permalink_redirect']) : esc_url(get_the_permalink());
		// if custom external link is set...
		$is_the_target_attribute = !empty($fields['custom_permalink_redirect']) ? ' target="_blank"' : '';
		// open in new tab title attr text
		$is_the_new_tab_title_attr_text = !empty($fields['custom_permalink_redirect']) ? ' [will open in a new tab/window]' : '';
		// the finished title attr for the anchor
		$is_the_title_attribute = ' title="Read More about ' . sanitize_text_field($is_the_post_title_content) . ' ' . sanitize_text_field($is_the_new_tab_title_attr_text) . '"';
		//
		$is_the_icon_class = (!empty($is_the_target_attribute)) ? ' fa-arrow-up-right-from-square' : ' fa-arrow-right';
		$is_the_icon_element = '<div class="is-hanging-icon"><i class="fa-light' . $is_the_icon_class . '"></i></div>';



		/*
			basic conditional class array
		*/
		$grid_item_conditional_class_array = [
			'grid-item',
			$post->post_type,
			$is_the_teaser_layout,
			$is_the_cover_image_aspect_ratio,
			$is_the_cover_image_alignment,
			(!empty($gridOptions['is-loaded-by-ajax'])) ? 'is-loaded-by-ajax' : ''
		];

		//
		$return = '';
		$guides = [];

		//
		$parentTeasers = get_dir_filenames_and_paths(get_template_directory() . "/classes/acf-blocks/posts-grid-item/templates/");
		$allTeasers = $parentTeasers;
		//
		if (is_child_theme() && is_dir(get_stylesheet_directory() . '/classes/acf-blocks/posts-grid-item/templates/')) {
			$childTeasers = get_dir_filenames_and_paths(get_stylesheet_directory() . '/classes/acf-blocks/posts-grid-item/templates/');
			$allTeasers = array_merge($parentTeasers, $childTeasers);
		}

		//
		// * NEW WAY TO TACKLE INCLUDING POSTS GRID TEASERS
		//
		foreach ($allTeasers as $teaser) {
			$template_raw = explode('templates/', $teaser);
			$template = str_replace('.php', '', $template_raw[1]);
			$teaserPath['nu_' . $template] = $allTeasers[$template];
		}

		// * Pull the simple post template file if it's just a post
		if ($post->post_type == 'post') {
			$teaserPath = !empty($allTeasers['post']) ? $allTeasers['post'] : '';
			include($teaserPath);
		}
		// * Else pull the custom post template file
		else {
			// * Check for matching template; otherwise use the "default" that has no unique metadata or fields
			$new_teaser_path = !empty($teaserPath[$post->post_type . '-template']) ? $teaserPath[$post->post_type . '-template'] : $allTeasers['default'];
			include($new_teaser_path);
		}

		//
		return $return;
	}
}

//
