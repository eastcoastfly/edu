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
		let alertPopup = $("#nu__alerts");
		if (alertPopup.length) {
			alertPopup.prepend(
				'<button class="toggle-alert"><i class="fa-regular fa-chevron-left"></i></button>'
			);
			alertPopup.addClass("is-open");
			if (localStorage.getItem("alert-dismissed")) {
				alertPopup.removeClass("is-open");
			}
			$(alertPopup).on("click", ".toggle-alert", function () {
				alertPopup.toggleClass("is-open");
				localStorage.setItem("alert-dismissed", true);
			});
		}
		//
		//
		//
		//
		// $("#nu__cookiewarning").on("click", "button.cookies-accept", function (e) {
		// 	localStorage.setItem("acceptCookies", "true");
		// 	$("#nu__cookiewarning").remove();
		// });

		//
		//
		//
		//
		// $("#nu__cookiewarning").on("click", "span.closeicon", function (e) {
		// 	$("#nu__cookiewarning").remove();
		// });

		//
		//
		// //
		// if (localStorage.getItem("acceptCookies") !== "true") {
		// 	$("#nu__cookiewarning").show().css("display", "flex");
		// } else {
		// 	$("#nu__cookiewarning").remove();
		// }

		//
	});
})(window.jQuery, window, document);
