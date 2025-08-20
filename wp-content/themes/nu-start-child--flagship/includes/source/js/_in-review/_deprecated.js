(function ($, window, document) {
	//
	// ... code out here will run immediately on load

	let Custom_GS = {
		_init: function (is_reinit = undefined) {
			//
			// 	?		maybe bail early...
			//
			let sliders = document.querySelectorAll(
				".wp-block-eedee-block-gutenslider"
			);
			if (!sliders.length) {
				return;
			}

			//
			// ?		if we have sliders...
			//
			sliders.forEach((elem, index) => {
				//
				//
				if ($(elem).hasClass("is-the-temporary-hero-slider")) {
					const Swiper = window.Swiper;
					let sliderUID = "#" + $(elem).attr("ID");
					let sliderContainer = $(sliderUID).closest(".wp-block-group");
					let gutenSlider = $(elem)[0].gutenslider;
					let swiperInstance = gutenSlider.swiperInstance;
					let swiperSettings = gutenSlider.swiperSettings;

					$(elem)
						.find(".swiper-slide-active .slide-content > .wp-block-group")
						.addClass("is-transitioned-into-view");

					let $bullets = swiperInstance.pagination.$el[0];
					//
					let slideTitles = $(
						".wp-block-eedee-block-gutenslider.is-the-temporary-hero-slider"
					).find(".swiper-slide:not(.swiper-slide-duplicate) h1");

					//
					$($bullets)
						.addClass("is-using-dynamic-bullet-titles")
						.children()
						.each(function (index, element) {
							$(element).html(slideTitles[index].innerHTML);
						});

					swiperInstance.on("slideChangeTransitionEnd", function (e) {
						// swiperInstance.on("slideChange", function (e) {

						$(swiperInstance.slides)
							.find(".slide-content > .wp-block-group")
							.removeClass("is-transitioned-into-view");

						$(swiperInstance.slides[swiperInstance.activeIndex])
							.find(".slide-content > .wp-block-group")
							.addClass("is-transitioned-into-view");
					});
				}
			});
			return;
		},
	};

	//
	$(function () {
		//
		// ? start of $.ready

		Custom_GS._init();

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
