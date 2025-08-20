/**
 * Cookie Disclaimer.
 *
 * Handles the functionality and display of the cookie disclaimer dialog.
 *
 * @summary Handles the functionality and display of the cookie disclaimer dialog.
 * @since      1.5.12
 * @class
 * @augments  BottomDialogComponent
 */

import { BottomDialogComponent } from './class-bottom-dialog';

export class CookieDisclaimer extends BottomDialogComponent {
	/**
	 * Creates an instance of the CookieDisclaimer class.
	 *
	 * @since      1.5.12
	 * @access     public
	 * @memberof   CookieDisclaimer
	 * @class
	 */
	constructor() {
		super( true, false, 'Manage Cookies' );

		if ( this.cookieExists( [ 'all_cookies', 'do_not_track' ] ) ) {
			this.bottomDialog.remove();
			return;
		}

		this.bottomDialog.classList.add( 'cookie-disclaimer' );

		this.populateDialog();
		this.bindEvents();
	}

	/**
	 * Populates the dialog with the necessary content and options.
	 *
	 * @since   1.5.12
	 * @access  private
	 * @memberof CookieDisclaimer
	 * @return {void}
	 */
	populateDialog() {
		const cookieOptions = [
			{
				label: 'Necessary',
				name: 'necessary-cookies',
				id: 'necessary-cookies',
				checked: true,
				disabled: true,
				description:
					'Necessary cookies are required to enable the basic features of this site, such as providing secure log-in or adjusting your consent preferences. These cookies do not store any personally identifiable data.',
			},
			{
				label: 'Tracking',
				name: 'tracking-cookies',
				id: 'tracking-cookies',
				checked: true,
				disabled: false,
				description:
					'Tracking cookies are used to understand how visitors interact with the website. These cookies help provide information on metrics such as the number of visitors, bounce rate, traffic source, etc.',
			},
		];

		/**
		 * Defines the content of the header for the cookie disclaimer dialog.
		 *
		 * @since 1.5.12
		 * @type {string}
		 */
		const headerContent = `
	    <p class="cookie-disclaimer__text">This website uses cookies and similar technologies to understand your use of our website and give you a better experience. By continuing to use the site or closing this banner without changing your cookie settings, you agree to our use of cookies and other technologies. To find out more about our use of cookies and how to change your settings, please go to our <a href="//northeastern.edu/privacy-information" title="Privacy information" target="_blank">Privacy Statement</a>.</p>
		`;

		const headerElement = document.createElement( 'div' );
		headerElement.innerHTML = headerContent;

		this.setHeader( headerElement );

		const acceptButton = document.createElement( 'button' );
		acceptButton.classList.add( 'wp-button', 'is-style-filled' );
		acceptButton.setAttribute( 'id', 'cookie-disclaimer--accept' );
		acceptButton.innerHTML = 'Accept';
		this.setExtraControls( acceptButton );

		const cookieOptionsContent = cookieOptions
			.map(
				( option ) => `
		  <div class="cookie-disclaimer__option">
		    <label>${ option.label } ${
					option.disabled ? '<span>Always On</span>' : ''
				}
		      <input id="${
					option.id
				}" class="cookie-disclaimer__input" type="checkbox" role="switch" name="${
					option.name
				}" ${ option.checked ? 'checked' : '' } ${
					option.disabled ? 'disabled' : ''
				}>
		      <span class="cookie-disclaimer__toggle"></span>
		    </label>
		    <p class="cookie-disclaimer__text">${ option.description }</p>
		  </div>
		`
			)
			.join( '' );

		/**
		 * Defines the content of the body for the cookie disclaimer dialog.
		 *
		 * @since 1.5.12
		 * @type {string}
		 */
		const bodyContent = `
		  <p class="cookie-disclaimer__settings-intro">We use cookies to help you navigate efficiently and perform certain functions. "Necessary" cookies are stored on your browser as they are essential for enabling the basic functionalities of the site. We also use third-party cookies that help us analyze how you use this website. These cookies will only be stored in your browser with your prior consent. You can choose to enable or disable these cookies.</p>
		  <div class="cookie-disclaimer__options">
		    ${ cookieOptionsContent }
		  </div>
		  <div class="cookie-disclaimer__controls">
		    <button class="cookie-disclaimer__save">Save Settings</button>
		  </div>
		`;

		const bodyElement = document.createElement( 'div' );
		bodyElement.innerHTML = bodyContent;

		this.setBody( bodyElement );
	}

	/**
	 * Binds click event listeners to the elements in the bottom dialog.
	 *
	 * @since   1.5.12
	 * @access  private
	 * @memberof CookieDisclaimer
	 * @return {void}
	 */
	bindEvents() {
		this.bottomDialog
			.querySelector( '#cookie-disclaimer--accept' )
			.addEventListener( 'click', this.handleAccept.bind( this ) );

		this.bottomDialog
			.querySelector( '.cookie-disclaimer__save' )
			.addEventListener( 'click', this.handleSaveSettings.bind( this ) );

		this.bottomDialog
			.querySelector( '.bottom-dialog__handle' )
			.addEventListener( 'click', this.manageCookies.bind( this ) );

		this.bottomDialog
			.querySelectorAll( '.cookie-disclaimer__option' )
			.forEach( ( option ) => {
				const labelElement = option.querySelector( 'label' );

				labelElement.addEventListener( 'click', () => {
					this.toggleOption( labelElement );
				} );
			} );
	}

	/**
	 * Handles the action when the accept button is clicked.
	 *
	 * @since   1.5.12
	 * @access  private
	 * @memberof CookieDisclaimer
	 * @return {void}
	 */
	handleAccept() {
		this.setCookie( 'all_cookies' );
		this.closeDialog();
	}

	/**
	 * Handles the action when the save settings button is clicked.
	 *
	 * @since     1.5.12
	 * @access    private
	 * @memberof  CookieDisclaimer
	 * @return    {void}
	 */
	handleSaveSettings() {
		const necessaryCookiesChecked =
			this.bottomDialog.querySelector( '#necessary-cookies' ).checked;
		const trackingCookiesChecked =
			this.bottomDialog.querySelector( '#tracking-cookies' ).checked;

		if ( necessaryCookiesChecked && ! trackingCookiesChecked ) {
			this.setCookie( 'do_not_track' );
		} else if ( necessaryCookiesChecked && trackingCookiesChecked ) {
			this.setCookie( 'all_cookies' );
		}

		this.closeDialog();
	}

	closeDialog() {
		this.bottomDialog.classList.add( 'is-hidden' );

		setTimeout( () => {
			this.bottomDialog.remove();
		}, 500 );
	}

	/**
	 * Toggles the state of the cookie options.
	 *
	 * @since     1.5.12
	 * @access    private
	 * @memberof CookieDisclaimer
	 * @param {Element} toggleElement - The element representing the toggle.
	 * @return   {void}
	 */
	toggleOption( toggleElement ) {
		const inputElement = toggleElement.querySelector(
			'.cookie-disclaimer__input'
		);

		if ( ! inputElement.disabled ) {
			inputElement.checked = ! inputElement.checked;
		}
	}

	/**
	 * Checks if a cookie by a given name exists.
	 *
	 * @since      1.5.12
	 * @access     private
	 * @memberof   CookieDisclaimer
	 *
	 * @param {Array} cookies - The array of cookie names to check.
	 * @return     {boolean} True if any of the cookies exist, false otherwise.
	 */
	cookieExists( cookies ) {
		const cookieString = document.cookie;
		return cookies.some( ( cookie ) =>
			cookieString.includes( cookie + '=' )
		);
	}

	/**
	 * Sets a cookie with the specified name.
	 *
	 * @since     1.5.12
	 * @access    private
	 * @memberof  CookieDisclaimer
	 *
	 * @param {string} cookieName - The name of the cookie to set.
	 * @return    {void}
	 */
	setCookie( cookieName ) {
		const expiry = new Date();
		const months = 1;
		const d = expiry.getDate();
		expiry.setMonth( expiry.getMonth() + months );
		if ( expiry.getDate() !== d ) {
			expiry.setDate( 0 );
		}

		document.cookie =
			cookieName +
			'=1; expires=' +
			expiry.toUTCString() +
			'; SameSite=lax; path=/';
	}

	/**
	 * Toggles the cookie settings display.
	 *
	 * @since   1.5.12
	 * @access  private
	 * @memberof CookieDisclaimer
	 * @return {void}
	 */
	manageCookies() {
		this.toggle();
	}
}
