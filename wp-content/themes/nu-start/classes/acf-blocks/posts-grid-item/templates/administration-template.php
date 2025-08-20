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

$leadership_details = !empty($fields['leadership_details']) ? $fields['leadership_details'] : '';

$view_profile_link = !empty($gridOptions['show_view_profile']) ? '<p class="is-the-view-more-link">View more <i class="fa-regular fa-arrow-right"></i></p>' : '';

$is_the_href_value = !empty($fields['custom_permalink_redirect']) ? $fields['custom_permalink_redirect'] : '';
$is_the_person_name = !empty($leadership_details['name']) ? '<h2 class="full-name post-title"><span>' . $leadership_details['name'] . '</span></h2>' : '<h2 class="full-name post-title"><span>' . $is_the_post_title_content . '</span></h2>';
$is_the_position = !empty($leadership_details['position']) ? '<div class="primary-title">' . $leadership_details['position'] . '</div>' : '';


$data_haslink = !empty($view_profile_link) ? 'data-haslink="true"' : '';

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$guides['grid-item-person'] = '
  <li class="' . $grid_item_conditional_classes . '"'.$data_haslink.'>
    <a class="contains-clickable-area" href="%1$s" %2$s></a>
      %3$s
      <div class="grid-item-content">
        %4$s
        %5$s
        %6$s
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
  $view_profile_link
);
