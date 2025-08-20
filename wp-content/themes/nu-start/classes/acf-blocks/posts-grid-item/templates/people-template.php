<?php

/**
 *    Posts Grid Item --- Person Template Type A
 * 
 *    This template will render a single Person item into the Posts Grid.
 *    - this is a "clickable area" template
 */
// 

$grid_item_conditional_class_array[] = !empty($gridOptions['contact_info_in_teaser']) ? 'has-disabled-clickable-area' : '';
$person_metadata = !empty($fields['person_metadata']) ? $fields['person_metadata'] : '';
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);
$is_the_disable_link_class = !empty($gridOptions['contact_info_in_teaser']) ? ' has-disabled-clickable-area' : '';

$email = !empty($gridOptions['contact_info_in_teaser']) && !empty($person_metadata['email']) ? '<p class="email has-inline-icon"><a href="mailto:' . $person_metadata['email'] . '">' . $person_metadata['email'] . '</a></p>' : '';
$phone = !empty($gridOptions['contact_info_in_teaser']) && !empty($person_metadata['phone_number']) ? '<p class="phone-number has-inline-icon"><a href="tel:' . $person_metadata['phone_number'] . '">' . $person_metadata['phone_number'] . '</a></p>' : '';


$view_profile_link = !empty($gridOptions['show_view_profile']) ? '<a class="view-profile-link" href="' . $is_the_href_value . '" ' . $is_the_title_attribute . ' ' . $is_the_target_attribute . '>View Profile</a>' : '';

$is_the_person_fullname = !empty($person_metadata['full_name']) ? '<h2 class="full-name post-title"><span>' . $person_metadata['full_name'] . '</span></h2>' : '<h2 class="full-name post-title"><span>' . $is_the_post_title_content . '</span></h2>';
$is_the_primary_title = !empty($person_metadata['primary_title']) ? '<div class="primary-title">' . $person_metadata['primary_title'] . '</div>' : '';

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$guides['grid-item-person'] = '
  <li class="' . $grid_item_conditional_classes . '">
    <a class="contains-clickable-area" href="%1$s"' . $is_the_title_attribute . '%2$s></a>
      %3$s
      <div class="grid-item-content">
        %4$s
        %5$s
        %6$s
        %7$s
        %8$s
        %9$s
        %10$s
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
  $is_the_person_fullname,
  $is_the_primary_title,
  $is_the_post_excerpt,
  $is_the_icon_element,
  // 
  $email,
  $phone,
  $view_profile_link
);
