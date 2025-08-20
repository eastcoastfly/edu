<?php

/**
 * 
 */
// 
// prepare the final output string - maybe sub-strings needed if complexity is high
$blockContentString = '';
// grab the posts fields as well, we may need them
$postFields = get_fields($post_id);
// grab the block fields
$blockFields = get_fields();

// get an array of the basic classes we need from common block attributes
$classes = return_acf_block_base_css_classes_array($block);


// 
// add this blocks name as a class
// 
$classes[] = 'this-block-name';

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
	$anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// 
// an example custom class attached to a custom field value
// 
if (!empty($blockFields['example-field'])) {
	$classes[] = 'enables-this-custom-class';
}

// 
// join the classes array into a string of classes separated by spaces ( no spaces before or after )
// 
$classString = esc_attr(join(' ', $classes));


// 
// 
// 
if ($blockFields['example-field'] == 'value') {
	// 
	// ... create or alter the $blockContentString
	// 
}



// 
?>

<div <?php echo $anchor; ?>class="<?php echo $classString; ?>">
	<?php
		$instance = new NU_DateTime_Helper($postFields);
		echo $instance::build_datetime_return_string();
	?>
</div>