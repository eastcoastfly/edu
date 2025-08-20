<?php

/**
 *    Posts Grid Item --- Event Item Template Type A
 * 
 *    This template will render a single Event item into the Posts Grid.
 *    --- we are going to deprecate this so we are cutting any loose ends now
 *    --- multi-day does not work
 */

if (has_term('featured', 'nu_events-tags', $post)) {
  $grid_item_conditional_class_array[] = 'is-featured';
}
if (has_term('hide-date', 'nu_events-tags', $post)) {
  $grid_item_conditional_class_array[] = 'hide-date';
}

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

$event_item_metadata = !empty($fields['event_item_metadata']) ? $fields['event_item_metadata'] : '';

// 
$eventMetaData = !empty($event_item_metadata['one_day']) ? $event_item_metadata['one_day'] : '';
if (!empty($eventMetaData) && !empty($fields)) {
  $instance = new NU_DateTime_Helper($fields);
  $the_date_time = $instance::build_datetime_return_string();
}

$event_location = !empty($event_item_metadata['location']) ? '<p class="location">' . $event_item_metadata['location'] . '</p>' : '';
$checkTerms = get_the_terms($post, 'nu_events-locations');
$event_topic = !empty($checkTerms) && !is_wp_error($checkTerms) ? '<div class="event-type">' . $checkTerms[0]->name . '</div>' : '';


$guides['grid-item-event'] = '
  <li class="' . $grid_item_conditional_classes . '">
    <a class="contains-clickable-area" href="%1$s"%2$s%3$s></a>
      %4$s
      <div class="grid-item-content">
        %8$s
        %5$s
        %6$s
        %7$s
        %9$s
      </div>
  </li>
';
// 
// 
$return .= sprintf(
  $guides['grid-item-event'],
  $is_the_href_value,
  $is_the_title_attribute,
  $is_the_target_attribute,
  $is_the_cover_image,
  $is_the_post_title,
  $is_the_post_excerpt,
  $is_the_icon_element,
  $event_topic,
  !empty($the_date_time) ? $the_date_time : ''
);
