(function ($, window, document) {
	/**
	 *   ... code out here will run immediately on load
	 */
	const debounce = function (func, delay) {
		let timer;
		return function () {
			//anonymous function
			const context = this;
			const args = arguments;
			clearTimeout(timer);
			timer = setTimeout(() => {
				func.apply(context, args);
			}, delay);
		};
	};
	const throttle = (func, limit) => {
		let inThrottle;
		return function () {
			const args = arguments;
			const context = this;
			if (!inThrottle) {
				func.apply(context, args);
				inThrottle = true;
				setTimeout(() => (inThrottle = false), limit);
			}
		};
	};
	/**
	 *
	 *   ... code in here will run after jQuery says document is ready
	 */
	$(function () {
		let hero_slider = $(
			".is-style-as-hero.wp-block-cover.is-the-pathways-hero-slider .wp-block-eedee-block-gutenslider"
		);
		if (
			hero_slider.length != 0 &&
			hero_slider[0].gutenslider.swiperInstance.length != 0
		) {
			let instance = hero_slider[0].gutenslider.swiperInstance;
			let activeSlide = instance.slides[instance.activeIndex];

			$(activeSlide)
				.find("h1 ~ .wp-block-group")
				.addClass("is-transitioned-into-view");

			instance.on("slideChangeTransitionStart", function (swiper) {
				let activeSlide = swiper.slides[swiper.activeIndex];

				$(swiper.$el)
					.find(".is-transitioned-into-view")
					.removeClass("is-transitioned-into-view");
			});
			instance.on("transitionEnd", function (swiper) {
				let activeSlide = swiper.slides[swiper.activeIndex];
				$(activeSlide)
					.find("h1 ~ .wp-block-group")
					.addClass("is-transitioned-into-view");
			});
		}

		let Custom_GS = {
			_init: function (is_reinit = undefined) {
				let sliders = document.querySelectorAll(
					".wp-block-eedee-block-gutenslider"
				);
				if (!sliders.length) {
					return;
				}
				sliders.forEach((elem, index) => {
					//
					//
					//
					if ($(elem).hasClass("patterns--sliders--red-buttons")) {
						let instance = $(elem)[0].gutenslider.swiperInstance;
						// ? disable touchmove
						instance.allowTouchMove = false;
						// ? add the dots
						let $bullets = instance.pagination.$el[0];
						$(instance.pagination.bullets).each(function (i, el) {
							el.innerHTML = i + 1;
						});
						instance.on("destroy", function () {
							// ? re-init this whole function to re-normalize after a breakpoint or another reason this was destroyed
							// ? the timeout is kinda hacky... but idk how else to fix this right now
							window.setTimeout(function () {
								Custom_GS._init((is_reinit = true));
							}, 16);
						});
					}

					//
					//
					//
					if ($(elem).hasClass("is-style-vertical")) {
						let gutenSlider = $(elem)[0].gutenslider;
						let swiperInstance = gutenSlider.swiperInstance;
						let swiperSettings = gutenSlider.swiperSettings;
						swiperSettings.direction = "vertical";
						gutenSlider.destroy();
						const newSwiper = gutenSlider.initSwiper(swiperSettings);
					}
				});
				return;
			},
		};
		Custom_GS._init();
	});
})(window.jQuery, window, document);
