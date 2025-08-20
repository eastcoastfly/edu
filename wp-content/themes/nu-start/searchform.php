<?php
/**
 * 
 * 			Search Form
 * 
 * 
 * 	TBD, some notes
 * 
 * 
 */
// 
if( !empty(NU__Starter::$themeSettings['search']['enable_site_search']) ) :

	$search_type = NU__Starter::$themeSettings['search']['type_of_search'];
	$form_action = ( $search_type == 'gcse' ) ? home_url( '/search/' ) : home_url( '/' );
	$search_input_name = ( $search_type == 'gcse' ) ? 'query' : 's';

?>
<div class="sitesearch-container">
	<button class="sitesearch-toggle">
		<i class="fa-light fa-magnifying-glass"></i>
		<i class="fa-light fa-xmark"></i>
		<span class="screen-reader-text"><?php echo _x( 'Open search form', 'label' ) ?></span>
	</button>
	<form role="search" method="get" class="search-form" action="<?= $form_action; ?>">
		<button class="search-submit-icon" aria-label="Submit Search" type="Submit"><i class="fa-light fa-magnifying-glass"></i></button>
		<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
		<label>
			<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
			<input type="search" class="search-field"
				placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
				value="<?php echo get_search_query() ?>" 
				name="<?php echo $search_input_name; ?>"
				title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
		</label>
		<button type="button" class="nu__sitesearch-close"><i class="fa-regular fa-xmark"></i></button>
	</form>
</div>
<?php endif; ?>