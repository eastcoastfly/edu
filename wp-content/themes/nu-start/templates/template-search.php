<?php 
/**
 * Template Name: Search Template
 */

if ( NU__Starter::$themeSettings['search']['search_scope'] == 'local' ) {
	$site_href = home_url();
	$site_title = get_bloginfo( $show, 'name' );
}

else if ( NU__Starter::$themeSettings['search']['search_scope'] == 'all' ) {
	$site_href = 'northeastern.edu';
	$site_title = 'Northeastern University';
}


get_header();

?>

<main id="main">

<div class="main-heading-search">
	<h1>Search</h1>
</div>


<script>

	let searchURL = window.location.href;

	// * Check to see if there is an actual query passed from search field
	const urlArray = searchURL.split("?query=");

	// * If no query was passed, we need to force one
	if (!urlArray[1]){
		// ! This line below doesn't work, because it returns a number like -27
		//if( window.location.href.indexOf('?query=') == -1 ){
		window.location.href = "<?=home_url()?>/search/?query=about";
	}
</script>

<script>var NUGS_specificsite = '<?php echo $site_href; ?>'; var NUGS_title ='<?php echo $site_title; ?>';</script>
<script src="https://search.northeastern.edu/nuglobalutils/requests/js/globalsearch.js"></script>

</main>

<?php
	get_footer();
?>