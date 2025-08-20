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

		const mfp_gallery_block = $(".wp-block-gallery.js__magnific");
		const mfp_image_block = $(
			".wp-block-image:not(.wp-block-gallery .wp-block-image).js__magnific:not(.video)"
		);
		const mfp_video_block = $(
			".wp-block-image:not(.wp-block-gallery .wp-block-image).js__magnific.video"
		);

		mfp_video_block.each(function () {
			$(this).magnificPopup({
				delegate: "a",
				type: "iframe",
			});
		});

		//
		//
		mfp_image_block.each(function () {
			$(this).magnificPopup({
				delegate: "a",
				type: "image",
			});
		});

		mfp_gallery_block.each(function () {
			// the containers for all your galleries
			$(this).magnificPopup({
				delegate: ":not(.is-hidden) a", // the selector for gallery item
				type: "image",
				zoom: {
					enabled: true, // By default it's false, so don't forget to enable it
					duration: 300, // duration of the effect, in milliseconds
					easing: "ease-in-out", // CSS transition easing function
				},
				gallery: {
					enabled: true,
				},
				image: {
					titleSrc: function (item) {
						// clone the entire .wp-element-caption element (including the container)
						let value = item.el.next(".wp-element-caption").clone();
						// return the full caption, including the class, container and the styling
						return value;
					},
				},
			});
		});

		//
	});
})(window.jQuery, window, document);
