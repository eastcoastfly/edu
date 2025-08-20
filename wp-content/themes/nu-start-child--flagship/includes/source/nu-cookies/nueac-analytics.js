/**
 * Determines whether scripts should wait to be loaded until the user accepts cookies.
 *
 * @type {boolean}
 * @default false
 */
const $shouldWait = false;

/**
 * Checks if the given cookie is present.
 *
 * @param {string} cookieName The name of the cookie to check for
 * @since 1.5.13
 * @return {boolean} True if the cookie exists, false otherwise.
 */
function hasCookie( cookieName ) {
	const cookie = document.cookie.match( '(^|;\\s*)' + cookieName + '\\s*=' );
	return cookie !== null;
}

/**
 * Loads the analytics scripts.
 *
 * @since   1.5.13
 */
export function loadAnalyticsScripts() {
	loadGoogleTagManagerConfig();
	loadGoogleTagManager();
	// loadHotjar();
	// loadParselyScript();
}

/**
 * Loads script for Hotjar.
 *
 * @since   1.5.13
 */
function loadHotjar() {
	// Hotjar script
	( function ( h, o, t, j, a, r ) {
		h.hj =
			h.hj ||
			function () {
				( h.hj.q = h.hj.q || [] ).push( arguments );
			};
		h._hjSettings = { hjid: 2814467, hjsv: 6 };
		a = o.getElementsByTagName( 'head' )[ 0 ];
		r = o.createElement( 'script' );
		r.async = 1;
		r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
		a.appendChild( r );
	} )( window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=' );
}

/**
 * Loads script for Google Tag Manager configuration.
 *
 * @since   1.5.13
 */
function loadGoogleTagManagerConfig() {
	const googleTagManagerConfig = document.createElement( 'script' );
	googleTagManagerConfig.textContent = `
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push( arguments  );
    }

    gtag( 'js', new Date() );

  `;
	document.head.appendChild( googleTagManagerConfig );
}

/**
 * Loads script for Google Tag Manager.
 *
 * @since   1.5.13
 */
function loadGoogleTagManager() {
	// Google Tag Manager initial config
	window.dataLayer.push( {
		'gtm.start': new Date().getTime(),
		event: 'gtm.js',
	} );

	// Create the script element
	const googleTagManagerScript = document.createElement( 'script' );
	googleTagManagerScript.src =
		'https://www.googletagmanager.com/gtm.js?id=GTM-WGQLLJ';
	document.head.appendChild( googleTagManagerScript );


	// ?		we think this is unique to news@
	// Additional Google Tag Manager script
	// const additionalScriptElement = document.createElement( 'script' );
	// additionalScriptElement.src =
	// 	'https://www.googletagmanager.com/gtag/js?id=UA-125695788-1';
	// document.head.appendChild( additionalScriptElement );
}

/**
 * Loads script for Parsely.
 *
 * @since   1.5.13
 */
function loadParselyScript() {
	// Parsely script
	const parselyScript = document.createElement( 'script' );
	parselyScript.src = '//cdn.parsely.com/keys/news.northeastern.edu/p.js';
	parselyScript.id = 'parsely-cfg';
	parselyScript.async = true;
	parselyScript.defer = true;
	document.head.appendChild( parselyScript );
}

function maybeLoadScripts() {
	if ( $shouldWait ) {
		// calls the function to load analytics scripts if user has accepted.
		if ( hasCookie( 'all_cookies' ) ) {
			loadAnalyticsScripts();
		}
		return;
	}
	//calls the function to load analytics scripts unless user has rejected tracking
	loadAnalyticsScripts();
}

if ( ! hasCookie( 'do_not_track' ) ) {
	maybeLoadScripts();
}
