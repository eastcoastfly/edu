<?php

/**
 *
 * ?      Post Teaser
 *
 */
//


// ? categories are shown
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
$is_the_post_author = '<p class="post-author">By: ' . get_the_author_meta('display_name', $post->post_author) . '</p>';
$is_the_publish_date = '<span class="post-date">On: ' . get_the_date('M d', $post->ID) . '</span>';

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$guides['grid-item-post'] = '
  <li class="' . $grid_item_conditional_classes . '">
		<a class="contains-clickable-area" href="%1$s" %2$s%9$s></a>
      %3$s
      <div class="grid-item-content">
        %4$s
        %5$s
        %6$s
        %7$s
        %8$s
      </div>
  </li>
';

$return .= sprintf(
  $guides['grid-item-post'],
  $is_the_href_value,
  $is_the_title_attribute,
  $is_the_cover_image,
  $is_the_post_title,
  $is_the_post_excerpt,
  $is_the_icon_element,
  //
  $is_the_post_author,
  $is_the_publish_date,
	$is_the_target_attribute
);
