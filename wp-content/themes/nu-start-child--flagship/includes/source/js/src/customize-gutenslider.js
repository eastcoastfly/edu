function isTouchDevice() {
	return (
		"ontouchstart" in window ||
		navigator.maxTouchPoints > 0 ||
		navigator.msMaxTouchPoints > 0
	);
}
//
//
//
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
				// * 		is the draggable slider
				//
				if ($(elem).hasClass("is-the-homepage-hero")) {
					let sliderUID = "#" + $(elem).attr("ID");
					let sliderContainer = $(sliderUID).closest(".wp-block-group");
					let gutenSlider = $(elem)[0].gutenslider;
					let swiperInstance = gutenSlider.swiperInstance;
					let swiperSettings = gutenSlider.swiperSettings;

					$(elem).append(
						'<button role="button" aria-label="Pause Slideshow" class="nu-gutenslider-play-pause"><span>Pause</span><i class="fa-sharp fa-solid fa-pause"></i></button>'
					);
					//
					$(elem)
						.find(".nu-gutenslider-play-pause")
						.on("click", function (e) {
							if ($(e.delegateTarget).hasClass("is-paused")) {
								$(e.delegateTarget).removeClass("is-paused");
								$(e.delegateTarget).attr('aria-label', 'Pause Slideshow');
								$(e.delegateTarget).find(".fa-solid").removeClass("fa-play");
								$(e.delegateTarget).find(".fa-solid").addClass("fa-pause");
								$(e.delegateTarget).find("span").html("Pause");
								swiperInstance.autoplay.start();
							} else {
								$(e.delegateTarget).addClass("is-paused");
								$(e.delegateTarget).attr('aria-label', 'Play Slideshow');
								$(e.delegateTarget).find(".fa-solid").removeClass("fa-pause");
								$(e.delegateTarget).find(".fa-solid").addClass("fa-play");

								$(e.delegateTarget).find("span").html("Play");
								swiperInstance.autoplay.stop();
							}
						});
				}

				//
				//
				//
				//
				if ($(elem).hasClass("is-style-draggable")) {
					//
					const Swiper = window.Swiper;
					let sliderUID = "#" + $(elem).attr("ID");
					let sliderContainer = $(sliderUID).closest(".wp-block-group");

					sliderContainer.addClass("is-the-draggable-slider-container");

					$(elem)
						.find(".eedee-swiper-outer")
						.append('<div class="swiper-scrollbar"></div>');

					let gutenSlider = $(elem)[0].gutenslider;
					let swiperInstance = gutenSlider.swiperInstance;
					let swiperSettings = gutenSlider.swiperSettings;
					// swiperSettings.simulateTouch = true;
					swiperSettings.createElements = true;
					swiperSettings.scrollbar = true;
					swiperSettings.draggable = true;
					gutenSlider.destroy();

					//
					//
					//
					swiperSettings.scrollbar = {
						el: sliderUID + " .swiper-scrollbar",
						// Makes the Scrollbar Draggable
						draggable: true,
						// Snaps slider position to slides when you release Scrollbar
						snapOnRelease: false,
						// Size (Length) of Scrollbar Draggable Element in px
						dragSize: "80",
						hide: false,
					};

					swiperSettings.freeMode = true;

					//
					//
					//
					const newSwiper = new Swiper(sliderUID + " .swiper", swiperSettings);

					if (index == 0) {
						window.nuSwipers = newSwiper;
					}

					$(sliderUID + " .swiper-scrollbar-drag").append(
						'<i class="fa-light fa-arrow-left"></i><i class="fa-light fa-arrow-right"></i>'
					);

					// console.log(newSwiper);

					sliderContainer.append(
						'<div class="swiper-scrollbar-custom-container alignwide"></div>'
					);
					let scrollbar_and_pagination_container = $(
						".swiper-scrollbar-custom-container",
						sliderContainer
					);
					//
					$(sliderUID + " .swiper-scrollbar")
						.detach()
						.appendTo(scrollbar_and_pagination_container);
					$(sliderUID + " .swiper-pagination-progressbar")
						.detach()
						.appendTo(scrollbar_and_pagination_container);

					// newSwiper.scrollbar.destroy();
					// newSwiper.scrollbar.init();
					// newSwiper.scrollbar.setTranslate();
					newSwiper.scrollbar.updateSize();

					// ? 		end of if is the draggable slider
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

		let listener = window.matchMedia("(max-width:780px)");
		// touch only
		if (isTouchDevice() == true) {
		}

		// mobile only
		if (listener.matches == true) {
			//

			$(
				".grid-item.nu_campuses, .grid-item.nu_colleges, .grid-item.post"
			).addClass("is-touch-disabled");
			//
			$(
				".grid-item.nu_campuses.is-touch-disabled, .grid-item.nu_colleges.is-touch-disabled, .grid-item.post.is-touch-disabled"
			).on("click", function (e) {
				$(e.delegateTarget).removeClass("is-touch-disabled");
			});

			//
		}

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
