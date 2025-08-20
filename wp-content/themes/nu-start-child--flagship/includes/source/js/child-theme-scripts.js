import "./src/takeover-nav";
import "./src/customize-gutenslider";
import "./src/_posts-grid-block-as-swiper";
(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	//

	//
	//
	//
	$(function () {
		//
		// ? start of $.ready

		//
		//
		//

		let demo_images_swapper = {
			localSitePath: "",

			remoteImages: [
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-abstract-1.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-abstract-8.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-abstract-11.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-students-3.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-students-6.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-students-1.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-locations-12.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-locations-8.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-locations-9.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-locations-4.jpg",
				"https://nubrandkits.wpengine.com/wp-content/uploads/2023/02/lorem-locations-3.jpg",
			],
			localImages: [

				"/wp-content/uploads/2650x1440.png.webp",
				"/wp-content/uploads/2650x1440.png",
				"/wp-content/uploads/1024x768.png.webp",
				"/wp-content/uploads/1024x768.png",
				"/wp-content/uploads/768x768.png.webp",
				"/wp-content/uploads/768x768.png",
			],

			getRandomInt: function (max) {
				return Math.floor(Math.random() * max);
			},

			_init: function () {
				if ($("body").hasClass("prod--disabled")) {
					return;
				}

				//
				this.localImages.forEach((imageSource) => {
					//
					let swapSource = window.location.origin + imageSource;
					//
					let findImages = $('img[src="' + swapSource + '"]');

					if (findImages.length == 0) {
						return;
					}

					findImages.each(function (index, element) {
						let randomImageIndex = demo_images_swapper.getRandomInt(
							demo_images_swapper.remoteImages.length
						);
						$(element).attr("sizes", "");
						$(element).attr("srcset", "");
						$(element).attr(
							"src",
							demo_images_swapper.remoteImages[randomImageIndex]
						);
					});
				});
			},
		};

		// demo_images_swapper._init();
		//
		//
		//
		//

		const DP_Interactive = {
			element: undefined,

			_init: function () {
				let element = $(
					".wp-block-ub-tabbed-content-underline.wp-block-ub-tabbed-content-holder.vertical-holder"
				);

				if (!$(element).length) {
					return;
				}

				$('div[role="tab"]', element).on("mouseenter", function (e) {
					console.log(e);
					$(e.delegateTarget).trigger("click");
				});
			},
		};

		// DP_Interactive._init();

		const Reveal_CardContent = {
			cardEls: undefined,

			_init: function () {
				Reveal_CardContent.cardEls = $(".grid-item.post");

				if (!Reveal_CardContent.cardEls.length) {
					return;
				}

				//

				$(Reveal_CardContent.cardEls).each(function (i, el) {
					let titleHeight = $(el).find(".post-title").innerHeight() + 48;
					$(el).css(
						"--offset--reveal--cards--content",
						"calc(100% - " + titleHeight + "px)"
					);
				});
			},
		};

		Reveal_CardContent._init();

		//
		// * Open and close Quick Links menu on mobile
		//
		$(".is-the-quick-links-bar > .wp-block-group > p").click(function () {
			$(this).toggleClass("open");
			//			$(this).next("nav.wp-block-navigation").fadeIn(100);
		});

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
