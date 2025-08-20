<?php

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
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

//
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
$return .= sprintf(
	$guides['grid-item-default'],
	$is_the_href_value,
	$is_the_title_attribute,
	$is_the_cover_image,
	$is_the_post_title,
	$is_the_post_excerpt,
	$is_the_icon_element,
	//
	$is_the_post_categories
);
