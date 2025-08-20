<?php

/**
 *    Posts Grid Item --- Person Template Type A
 *
 *    This template will render a single Person item into the Posts Grid.
 *    - this is a "clickable area" template
 */
//

$grid_item_conditional_class_array[] = empty($gridOptions['contact_info_in_teaser']) ? 'has-disabled-clickable-area' : '';
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$professional_details = !empty($fields['professional_details']) ? $fields['professional_details'] : '';

$view_profile_link = !empty($gridOptions['show_view_profile']) ? '<p>View more <i class="fa-regular fa-arrow-right"></i></p>' : '';

$is_the_href_value = !empty($fields['custom_permalink_redirect']) ? $fields['custom_permalink_redirect'] : '';
$is_the_person_name = !empty($professional_details['name']) ? '<p class="full-name post-title"><span>' . $professional_details['name'] . '</span></p>' : '<p class="full-name post-title"><span>' . $is_the_post_title_content . '</span></p>';
$is_the_position = !empty($professional_details['job_title']) ? '<div class="primary-title">' . $professional_details['job_title'] . '</div>' : '';
$is_the_location = !empty($professional_details['location']) ? '<div class="primary-title location">' . $professional_details['location'] . '</div>' : '';

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$guides['grid-item-person'] = '
  <li class="' . $grid_item_conditional_classes . '">
    <a class="contains-clickable-area" href="%1$s" %2$s></a>
      %3$s
      <div class="grid-item-content">
        %4$s
        %5$s
        %6$s
        %7$s
      </div>
  </li>
';
//
//
$return .= sprintf(
  $guides['grid-item-person'],
  $is_the_href_value,
  $is_the_title_attribute,
  $is_the_cover_image,
  $is_the_person_name,
  $is_the_position, // 5
  $is_the_location,
  $view_profile_link
);
