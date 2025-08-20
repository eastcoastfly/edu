/**
 * Creates a bottom dialog component.
 */
// import '../styles/06-components/bottom-dialog.scss';

export class BottomDialogComponent {
	constructor( isExpanding = false, isModal = false, handleText = 'toggle' ) {
		// Creates the component.
		this.bottomDialog = document.createElement( 'dialog' );
		this.bottomDialog.classList.add( 'bottom-dialog' );

		// Adds optional modal.
		if ( isModal ) {
			this.bottomDialog.classList.add( 'is-modal' );
			const scrimElement = document.createElement( 'div' );
			scrimElement.classList.add( 'bottom-dialog__scrim' );
			scrimElement.append( this.bottomDialog );
			document.body.append( scrimElement );
		}

		// Adds optional expanding attributes.
		if ( isExpanding ) {
			this.bottomDialog.setAttribute( 'expanded', false );
			this.controlsElement = document.createElement( 'div' );
			this.controlsElement.classList.add( 'bottom-dialog__controls' );
			const handle = document.createElement( 'button' );
			handle.classList.add( 'bottom-dialog__handle', 'wp-button' );
			handle.textContent = handleText;
			this.controlsElement.append( handle );
			this.bottomDialog.append( this.controlsElement );

			// * We're moving this from append to prepend for instant tabbability
			document.body.prepend( this.bottomDialog );
		}
	}

	/**
	 * Sets controls content
	 *
	 * @param {string} content - The HTML string for the extra control element (e.g. a button).
	 * @since 1.5.11
	 */

	setExtraControls( content ) {
		this.controlsElement.append( content );
	}

	/**
	 * Sets body content.
	 *
	 * @param {string} content - The content of the body for the bottom dialog.
	 */
	setBody( content ) {
		const bodyElement = document.createElement( 'div' );
		bodyElement.classList.add( 'bottom-dialog__body' );
		bodyElement.append( content );

		this.bottomDialog.append( bodyElement );
	}

	/**
	 * Sets header content.
	 *
	 * @param {string} content - The content of the header for the bottom dialog.
	 */
	setHeader( content ) {
		const headerElement = document.createElement( 'div' );
		headerElement.classList.add( 'bottom-dialog__header' );
		headerElement.append( content );

		this.bottomDialog.prepend( headerElement );
	}

	toggle() {
		this.bottomDialog.classList.toggle( 'expanded' );
	}
}
