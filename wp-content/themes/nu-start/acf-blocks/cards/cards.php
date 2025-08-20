<?php
/**
 * 
 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
 * 
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// 

$fields = get_fields();


$classes = [ 'acf-block', 'cards' ];
if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, explode( ' ', $block['className'] ) );
}
if ( ! empty( $block['align'] ) ) {
	$classes[] = 'align' . $block['align'];
}
if ( ! empty( $block['full_height'] ) ) {
	$classes[] = 'is-full-height';
}
if ( ! empty( $block['align_text'] ) ) {
	$classes[] = 'has-text-align-' . $block['align_text'];
}
if ( ! empty( $block['align_content'] ) ) {
	$classes[] = 'is-vertically-aligned-' . $block['align_content'];
}


if ( ! empty( $block['backgroundColor'] ) ) {
	$classes[] = 'has-background';
	$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
}
if ( ! empty( $block['textColor'] ) ) {
	$classes[] = 'has-text-color';
	$classes[] = 'has-' . $block['textColor'] . '-color';
}

if( !empty($fields['link']['title']) ){
	$classes[] = 'has-clickable-link-title';
}
$classString = esc_attr( join( ' ', $classes ) );

$is_clickable = !empty( $fields['link'] ) ? 'true' : 'false';
$clickable_area_anchor = !empty($fields['link']['url']) && $is_preview != true ? '<a class="is-card-clickable-area-anchor" href="'.$fields['link']['url'].'" target="'.$fields['link']['target'].'" aria-label="View '.$fields['link']['title'].'"></a>' : '';


// ? if we have a view more link, and a title for it, show that and append a new tab icon if needed
$view_more_target_icon = !empty($fields['link']['target']) ? ' [icon name="arrow-up-right-from-square" prefix="far"]' : '';
$view_more_link = !empty($clickable_area_anchor) && !empty($fields['link']['title']) ? '<p class="is-the-view-more-link"><span>'.$fields['link']['title'].'</span>'.$view_more_target_icon.'</p>' : '';


$innerBlocks = '<InnerBlocks />';
// 
// 

?>
<div class="<?php echo $classString; ?>" data-clickable-area="<?= $is_clickable; ?>">
	<?= $clickable_area_anchor; ?>
	<div>
		<?= $innerBlocks; ?>
		<?= $view_more_link; ?>
	</div>
</div>
