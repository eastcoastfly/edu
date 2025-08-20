import "../../../vendor/js/waapi-animate-details";
(function ($, window, document) {
	/**
	 *
	 *   ... code in here will run after jQuery says document is ready
	 */
	$(function () {
		// * Function to automatically open an accordion if a hash is in the URL
		let accordion_hash_handler = {
			_init: function () {
				// check for accordions
				let $accordions = $(".wp-block-nu-blocks-accordion");

				// check for hash value
				let $hash = window.location.hash;

				// bail early
				if ($accordions.length == 0 || $hash.length == 0) {
					return;
				}

				// * Get the accordion item with the hash above
				let anchor = $(".wp-block-nu-blocks-accordion-item" + $hash);

				// * Exit the function if there is no accordion item with this hash
				if (anchor.length == 0) {
					return;
				}

				// * Otherwise click open the element's summary with this hash
				$(anchor).siblings().find("details").removeAttr("open");
				$(anchor).find("details").attr("open", "open");

				let $offset =
					$(anchor).find("details").offset().top - $("header").height();
				$(window).scrollTop($offset);
			},
		};

		$(window).on("hashchange load", function () {
			accordion_hash_handler._init();
		});
	});
})(window.jQuery, window, document);
