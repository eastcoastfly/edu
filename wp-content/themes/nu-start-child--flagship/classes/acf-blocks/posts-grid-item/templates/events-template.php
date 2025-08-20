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
// $eventMetaData = !empty($event_item_metadata['one_day']) ? $event_item_metadata['one_day'] : '';
// if (!empty($eventMetaData) && !empty($fields)) {
//   $instance = new NU_DateTime_Helper($fields);
//   $the_date_time = $instance::build_datetime_return_string();
// }

$event_location = !empty($event_item_metadata['location']) ? '<p class="nu__datetime-location"><span>' . $event_item_metadata['location'] . '</span></p>' : '';
// 
$checkTerms = get_the_terms($post, 'nu_events-types');
$event_topic = !empty($checkTerms) && !is_wp_error($checkTerms) ? '<div class="event-type">' . $checkTerms[0]->name . '</div>' : '';

$guides['single-day'] = '
	<div class="nu__datetime">
		%1$s
		%2$s
	</div>
';
// 
$date_format = "M d";
$time_format = 'g:i a';

$happensOn = !empty($event_item_metadata['one_day']['happens_on']) ? '<p class="nu__datetime-dates"><span class="nu__datetime-startsat">' . DateTime::createFromFormat('Ymd', $event_item_metadata['one_day']['happens_on'])->format($date_format) . '</span></p>' : '';
$happensOnString = !empty($event_item_metadata['one_day']['happens_on']) ? '<span>'.DateTime::createFromFormat('Ymd', $event_item_metadata['one_day']['happens_on'])->format($date_format) . '</span> | ' : '';
$startsAt = !empty($event_item_metadata['one_day']['starts_at']) ? '<span class="nu__datetime-startson">' . DateTime::createFromFormat('H:i:s', $event_item_metadata['one_day']['starts_at'])->format($time_format) . '</span>' : '';
$endsAt = !empty($event_item_metadata['one_day']['ends_at']) ? ' - <span>' . DateTime::createFromFormat('H:i:s', $event_item_metadata['one_day']['ends_at'])->format($time_format) . '</span>' : '';

$dateTimeString = sprintf(
	$guides['single-day'],
	!empty($startsAt) || !empty($endsAt) ? '<p class="nu__datetime-times">'. $happensOnString . $startsAt . $endsAt . '</p>' : '',
	$event_location
);




// 

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
	// !empty($the_date_time) ? $the_date_time : ''
	// '<div class="nu__datetime">TBD DateTime</div>'
	$dateTimeString
);
