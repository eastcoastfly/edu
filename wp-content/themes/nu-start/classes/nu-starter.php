<?php
/**
 *
 *
 *
 */
//


class NU__Starter
{



	static $themeSettings = array(
		'seo' => [],
		'appear' => [],
		'social' => [],
		'dev' => [],
		'footer' => [],
		//'general' => [],
		'global' => [],
		'header' => [],
		'search' => [],
	);


	public static function nu__showCookieWarning(){

		if( !is_admin() ){

			$return = '';
			$guides = [];
			$guides['cookiewarning'] = '
				<div id="nu__cookiewarning">
				  <div>
						%1$s
						<button class="button cookies-accept">Accept and Continue</button>
					</div>
				</div>
			';

			$return .= sprintf(
				$guides['cookiewarning'],
				'<p class="has-smaller-font-size">We use cookies to improve your experience on our sites. By continuing to use our sites, you agree to our <a href="/privacy-information/" title="Privacy information" aria-label="Privacy information">Privacy Statement</a>.</p>'
			);

			echo $return;

		}
	}


	public static function __init(){
		NU__Starter::$themeSettings = [];
		NU__Starter::$themeSettings['seo'] = get_field('analytics_&_seo_settings', 'option') ?: [];
		NU__Starter::$themeSettings['appearance'] = get_field('appearance_settings', 'option') ?: [];
		NU__Starter::$themeSettings['dev'] = get_field('developer_settings', 'option') ?: [];
		NU__Starter::$themeSettings['footer'] = get_field('footer_settings', 'option') ?: [];
		NU__Starter::$themeSettings['global'] = get_field('global_settings', 'option') ?: [];
		NU__Starter::$themeSettings['header'] = get_field('header_settings', 'option') ?: [];
		NU__Starter::$themeSettings['search'] = get_field('search_settings', 'option') ?: [];

		add_filter('acf/fields/google_map/api', 'NU__Starter::nu__update_acf_map_api_key');

	}

	//GEOTAG
	//meta zipcode
	public static function nu__customGeoTagMetaZip(){

		if( empty(NU__Starter::$themeSettings['seo']['geotag']['zip_code']) ){
			return;
		}
		echo NU__Starter::$themeSettings['seo']['geotag']['zip_code'];
	}

	//meta city
	public static function nu__customGeoTagMetaCity(){

		if( empty(NU__Starter::$themeSettings['seo']['geotag']['city']) ){
			return;
		}
		echo NU__Starter::$themeSettings['seo']['geotag']['city'];
	}

	//meta state
	public static function nu__customGeoTagMetaState(){

		if( empty(NU__Starter::$themeSettings['seo']['geotag']['state']) ){
			return;
		}
		echo NU__Starter::$themeSettings['seo']['geotag']['state'];
	}


	public static function _get_all_favicons(){

		return '
			<link rel="apple-touch-icon" sizes="57x57"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-57x57.png?v=2" />
			<link rel="apple-touch-icon" sizes="60x60"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-60x60.png?v=2" />
			<link rel="apple-touch-icon" sizes="72x72"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-72x72.png?v=2" />
			<link rel="apple-touch-icon" sizes="76x76"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-76x76.png?v=2" />
			<link rel="apple-touch-icon" sizes="114x114"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-114x114.png?v=2" />
			<link rel="apple-touch-icon" sizes="120x120"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-120x120.png?v=2" />
			<link rel="apple-touch-icon" sizes="144x144"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-144x144.png?v=2" />
			<link rel="apple-touch-icon" sizes="152x152"  href="https://brand.northeastern.edu/global/assets/favicon/apple-touch-152x152.png?v=2" />
			<link rel="icon" sizes="144x144" type="image/png" href="https://brand.northeastern.edu/global/assets/favicon/android-chrome-144x144.png?v=2" />
			<link rel="icon" sizes="32x32" type="image/png" href="https://brand.northeastern.edu/global/assets/favicon/favicon-32x32.png?v=2" />
			<link rel="icon" sizes="16x16" type="image/png" href="https://brand.northeastern.edu/global/assets/favicon/favicon-16x16.png?v=2" />
			<link rel="manifest" href="https://brand.northeastern.edu/global/assets/favicon/manifest.json" />
			<meta name="msapplication-TileImage" content="https://brand.northeastern.edu/global/assets/favicon/mstile-144x144.png?v=2" />
		';
	}



	/**
	 * Tell it how it is by the way that it does
	 *
	 * @return string the scripts we need from nu global
	 */
	public static function nu__globalHeaderFooterScripts(){

		if( empty(NU__Starter::$themeSettings['global']['global_header_footer']['status']) ){
			return;
		}

		// see @link https://northeastern.netlify.app/docs/changelog/
		// see @link https://northeastern.netlify.app/pattern-library/page-chrome/global-elements/


		// ? we are NOT using kernl(ui) and are only loading the global elements
		// ? we are including Lato in the theme and don't need to load it

		// echo the global scripts
		echo '
		<script src="https://global-packages.cdn.northeastern.edu/global-elements/dist/js/index.umd.js" defer></script>
		<link rel="stylesheet" href="https://global-packages.cdn.northeastern.edu/global-elements/dist/css/index.css">
		<script src="https://global-packages.cdn.northeastern.edu/kernl-ui/dist/js/index.umd.js" defer></script>
		';

	}




	// if we want to use the university GATM
	public static function nu__globalTagManagerScript(){
		if( empty(NU__Starter::$themeSettings['dev']['build_status']) ){
			return;
		}
		if( empty(NU__Starter::$themeSettings['seo']['main_nu_google_analytics']) ){
			return;
		}
		echo "<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WGQLLJ');</script><!-- End Google Tag Manager -->";
	}





	// if we want to use the university GATM
	public static function nu__globalTagManagerBodyScript(){
		// if( empty(NU__Starter::$themeSettings['dev']['build_status']) ){
		// 	return;
		// }
		// if( empty(NU__Starter::$themeSettings['seo']['main_nu_google_analytics']) ){
		// 	return;
		// }
		// echo "<!-- Google Tag Manager (noscript) --><noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id=GTM-WGQLLJ\" height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript><!-- End Google Tag Manager (noscript) -->";
	}





	public static function nu__customTagManagerScripts(){
		if( empty(NU__Starter::$themeSettings['dev']['build_status']) ){
			return;
		}
		if( empty(NU__Starter::$themeSettings['seo']['custom_analytics']) ){
			return;
		}
		echo NU__Starter::$themeSettings['seo']['custom_analytics'];
	}








	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function nu__globalHeaderElement(){
		if( empty(NU__Starter::$themeSettings['global']['global_header_footer']['status']) ){
			return;
		}

		$useMenu = 'true';

		$useWordMark = NU__Starter::$themeSettings['global']['global_header_footer']['use_wordmark'] ? 'true' : 'false';

		return '<div class="itsglobalheader--container"><div id="itsglobalheader" x-data="NUGlobalElements.header({wordmark:'.$useWordMark.', menu:'.$useMenu.'})" x-init="init()"></div></div>';
	}








	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function nu__globalFooterElement(){
		if( empty(NU__Starter::$themeSettings['global']['global_header_footer']['status']) ){
			return;
		}
		echo '<div x-data="NUGlobalElements.footer()" x-init="init()"></div>';
	}




	public static function nu__update_acf_map_api_key( $api ){
		if( empty(NU__Starter::$themeSettings['dev']['google_maps_api_key']) ){
			return;
		}
		$api['key'] = NU__Starter::$themeSettings['dev']['google_maps_api_key'];
		return $api;
	}



}





// * fire the custom construction on init
add_action('acf/init', 'NU__Starter::__init', 10, 2);


//
?>
