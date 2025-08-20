import { gsap } from "../../../../assets/gsap/umd/gsap";
import { ScrollTrigger } from "../../../../assets/gsap/umd/ScrollTrigger";
import { ScrollSmoother } from "../../../../assets/gsap/umd/ScrollSmoother";
import { DrawSVGPlugin } from "../../../../assets/gsap/umd/DrawSVGPlugin";
(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	gsap.registerPlugin(ScrollTrigger);
	gsap.registerPlugin(ScrollSmoother);
	gsap.registerPlugin(DrawSVGPlugin);
	//
	$(function () {
		//
		// ? start of $.ready
		//
		// * Vertical scroll line

		// ! wrap up this "feature" into a scope
		const Husky_Handler = {
			// ! separate the initiation from the core logic
			_init: function () {
				// !		check if we have the thing
				if ($(".separating-text-image-carousel").length > 0) {
					Husky_Handler._create_huskytl_instance();
				}
			},
			//
			// 	! 100% of your code is inside here untouched
			//
			_create_huskytl_instance: function () {
				// * GSAP Animation Timeline for SEPARATING TEXT WITH IMAGE CAROUSEL (e.g. "#LikeAHusky")
				var huskyTL = gsap.timeline({
					scrollTrigger: {
						trigger: ".separating-text-image-carousel",
						start: "center 50%",
						end: "+=8000",
						pin: true,
						scrub: 1,
					},
				});

				// * Fade in text ("#Like A Husky")
				huskyTL.from(".separating-text-image-carousel > p", {
					opacity: 0,
					duration: 2,
					y: 60,
					delay: 6,
				});

				// ! We need to get the height and width of the image carousel to be exact
				var carouselWidth = $(
					".separating-text-image-carousel > .wp-block-group"
				).width();

				var carouselHeight = $(
					".separating-text-image-carousel > .wp-block-group"
				).height();

		if (screen.width >= 600) {
			var finalCarouselWidth = carouselWidth / 3.5;
			var finalCarouselHeight = carouselHeight / 1.75;
		} else {
			finalCarouselHeight = carouselHeight / 1.85;
			finalCarouselWidth = 0;
		}

				// * Push "#Like" up to the top left corner
				huskyTL.to(
					".separating-text-image-carousel > p:first-child",
					{
						x: "-" + finalCarouselWidth,
						y: "-" + finalCarouselHeight,
						duration: 10,
						delay: 6,
					},
					">"
				);

				// * Push "AHusky" down to the bottom right corner
				huskyTL.to(
					".separating-text-image-carousel > p:nth-child(2)",
					{
						x: finalCarouselWidth,
						y: finalCarouselHeight,
						duration: 10,
					},
					"<"
				);

				// * Fade in first item in carousel
				huskyTL.to(
					".separating-text-image-carousel > .wp-block-group",
					{
						opacity: 1,
						duration: 2,
					},
					">"
				);

				// * Loop through array to account for unknown number of carousel items

				var carouselItems = $(
					".separating-text-image-carousel > .wp-block-group > .wp-block-group"
				).toArray();

				var cycles = carouselItems.length;

				for (let i = 0; i < cycles; i++) {
					huskyTL.to(
						".separating-text-image-carousel > .wp-block-group > .wp-block-group",
						{
							y: "-" + i * 100 + "%",
							duration: 6,
						},
						">"
					);
				}

				// * Fade out carousel
				huskyTL.to(
					".separating-text-image-carousel > .wp-block-group",
					{
						opacity: 0,
						delay: 2,
						duration: 3,
					},
					">"
				);

				// * Move "#Like" back to vertical center
				huskyTL.to(
					".separating-text-image-carousel > p:first-child",
					{
						x: 0,
						y: 0,
						duration: 3,
					},
					">"
				);

				// * Move "A Husky" back to vertical center
				huskyTL.to(
					".separating-text-image-carousel > p:nth-child(2)",
					{
						x: 0,
						y: 0,
						duration: 3,
					},
					"<"
				);

				// huskyTL.from(
				// 	".separating-text-image-carousel .wp-block-buttons",
				// 	{
				// 		opacity: 0,
				// 		x: -100,
				// 		duration: 3,
				// 		delay: 2,
				// 	},
				// 	"<"
				// );
			},
		};
		Husky_Handler._init();

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
