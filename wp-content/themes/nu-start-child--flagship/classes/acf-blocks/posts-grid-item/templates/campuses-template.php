<?php

/**
 *    Posts Grid Item --- Campuses
 *
 *    This template will render a single Campus item into the Posts Grid.
 *    - this is a "clickable area"
 */
//

$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$state = !empty($fields['state']) ? '<p class="is-style-eyebrow campus-state">' . $fields['state'] . '</p>' : '';

//
//
$is_the_post_description = !empty($fields['overrides']['full_description']) && !empty($item_styles['show_full_description']) ? '<div class="post-excerpt">' .$fields['overrides']['full_description']. '</div>' : $is_the_post_excerpt;
//
//


// * Taken from original switch in class.posts-grid-item.php
//
$is_the_post_categories = '';
$categories = get_the_terms($post->ID, 'category');
if (!empty($categories) && !is_wp_error(($categories))) {
	$is_the_post_categories = '<p class="featured-tags">';
	foreach ($categories as $category) {
		$is_the_post_categories .= '<span>' . $category->name . '</span>';
	}
	$is_the_post_categories .= '</p>';
}

//
$guides['grid-item-default'] = '
	<li class="' . $grid_item_conditional_classes . '">
		<a class="contains-clickable-area" href="%1$s"%2$s%3$s></a>
			%4$s
			<div class="grid-item-content">
				%8$s
				<div class="campus-name-and-state">
					%5$s
					%6$s
				</div>
				<div class="campus-blurb-and-link">
				%7$s
				<p class="campus-link"><a href="">Explore ' . get_the_title() . ' [icon name="arrow-right" prefix="fas"]</a></p>
				</div>
			</div>
	</li>
';

//
$return .= sprintf(
	$guides['grid-item-default'],
	$is_the_href_value,
	$is_the_title_attribute,
	$is_the_target_attribute,
	$is_the_cover_image,
	$is_the_post_title,
	$state,
	$is_the_post_description,
	$is_the_icon_element,
	//
	$is_the_post_categories
);
