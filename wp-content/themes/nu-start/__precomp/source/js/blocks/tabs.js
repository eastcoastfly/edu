(function ($, window, document) {
	/**
	 *   ... code out here will run immediately on load
	 */

	/**
	 *
	 *   ... code in here will run after jQuery says document is ready
	 */
	$(function () {
		//

		//
		let ub_tabs_handler = {
			_update_underline_style: function (element) {
				console.log(element);

				// find width and position of first tab
				let defaultActiveTab = $(
					'.wp-block-ub-tabbed-content-tabs-title div[role="tab"].active',
					element
				);
				let position = defaultActiveTab.position();
				let width = defaultActiveTab.outerWidth();
				// append the required styles to align on page load
				let inline_styles =
					"width: " + width + "px; left: " + position.left + "px";

				// append an element for the active state underline
				$(".wp-block-ub-tabbed-content-tabs-title", element).append(
					'<span class="is-sliding-tabs-underline" style="' +
						inline_styles +
						'"></span>'
				);

				// move the underline on tab click
				$(element).on("click", 'div[role="tab"]', function () {
					let position = $(this).position();
					let width = $(this).outerWidth();
					$(".is-sliding-tabs-underline", element).css({
						left: position.left,
						width: width,
					});
				});
			},
			_init: function () {
				if ($(".wp-block-ub-tabbed-content-underline").length == 0) {
					return;
				}

				$(".wp-block-ub-tabbed-content-underline").each(function (
					index,
					element
				) {
					ub_tabs_handler._update_underline_style(element);
				});
			},
		};
		ub_tabs_handler._init();

		//
	});
})(window.jQuery, window, document);
