<?php

/**
 * 
 * ?      Project Teaser
 * 
 */
// 
$checkTerms = get_the_terms($post, 'nu_profiles-types');
$profile_type = !empty($checkTerms) ? '<div class="featured-tags">' . $checkTerms[0]->name . '</div>' : '';

// * From class.posts-grid-item.php
$profile_item_metadata = !empty($fields['profile_metadata']) ? $fields['profile_metadata'] : '';

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

// 
$guides['grid-item-profile'] = '
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
// 
$return .= sprintf(
  $guides['grid-item-profile'],
  $is_the_href_value,
  $is_the_title_attribute,
  $is_the_cover_image,
  $is_the_post_title,
  $is_the_post_excerpt,
  $is_the_icon_element,
  // 
  $profile_type
);
