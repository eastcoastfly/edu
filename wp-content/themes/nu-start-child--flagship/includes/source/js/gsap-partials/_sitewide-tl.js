import { gsap } from "../../../../assets/gsap/umd/gsap";
import { ScrollTrigger } from "../../../../assets/gsap/umd/ScrollTrigger";
import { ScrollSmoother } from "../../../../assets/gsap/umd/ScrollSmoother";
gsap.registerPlugin(ScrollSmoother, ScrollTrigger);

(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	//

	const Batched_ScrollTriggers = {
		staggerFade_els: undefined,
		mediaText_els: undefined,

		_init: function () {
			//
			//
			//
			Batched_ScrollTriggers.staggerFade_els = gsap.utils.toArray([
				".nu__grid .grid-item",
				".wp-block-columns.patterns--is-stats-columns > .wp-block-column",
				".patterns--powered-by-exp-ctas > *",
				".is-a-stagger-fade-container > *"
			]);

			//
			//
			//
			Batched_ScrollTriggers.mediaText_els = gsap.utils.toArray([
				".wp-block-media-text",
			]);

			//
			//
			//
			if ($(".wp-block-cover.alignfull.is-style-default").length > 0) {
				Batched_ScrollTriggers._handle_cover_scrolled_into_view();
			}

			//
			//
			//
			if (Batched_ScrollTriggers.mediaText_els.length > 0) {
				Batched_ScrollTriggers._handle_mediatext_batch(
					Batched_ScrollTriggers.mediaText_els
				);
			}
			//
			//
			//
			if (Batched_ScrollTriggers.staggerFade_els.length > 0) {
				Batched_ScrollTriggers._handle_staggerfade_batch(
					Batched_ScrollTriggers.staggerFade_els
				);
			}
		},
		//
		//
		//
		_handle_mediatext_batch: function (batchArray) {
			gsap.set(".wp-block-media-text__media", { y: 88, opacity: 0 });
			gsap.set(".wp-block-media-text__content", { x: 88, opacity: 0 });

			ScrollTrigger.batch(batchArray, {
				start: "top 85%",
				end: "bottom 15%",
				onEnter: (batch) =>
					batch.forEach((block, index) => {
						let figure = block.querySelectorAll(".wp-block-media-text__media");
						let content = block.querySelectorAll(
							".wp-block-media-text__content"
						);
						//
						gsap.to(figure, {
							duration: 1.3,
							opacity: 1,
							y: 0,
							delay: 0.5,
						});
						gsap.to(content, { duration: 1.3, opacity: 1, x: 0, delay: 0.5 });
					}),
			});

			//
			gsap.set(".wp-block-media-text__media", { y: 88, opacity: 0 });
			gsap.set(".wp-block-media-text__content", { x: 88, opacity: 0 });
			//
			ScrollTrigger.batch(batchArray, {
				start: "top 85%",
				end: "bottom 15%",
				duration: 1,
				onEnter: (batch) =>
					gsap.to(batch, { y: 0, autoAlpha: 1, stagger: 0.2 }),
			});
		},
		//
		//
		//
		_handle_staggerfade_batch: function (batchArray) {
			//
			gsap.set(batchArray, { opacity: 0, y: 44 });
			//
			ScrollTrigger.batch(batchArray, {
				start: "top 85%",
				end: "bottom 15%",
				duration: 1,
				onEnter: (batch) =>
					gsap.to(batch, { y: 0, autoAlpha: 1, stagger: 0.2 }),
			});
			//
		},
		//
		//
		//
		_handle_cover_scrolled_into_view: function () {
			gsap.set(
				".blocks--wrapper > .wp-block-cover.alignfull .wp-block-cover__image-background",
				{ opacity: 0 }
			);
			$(
				".blocks--wrapper > .wp-block-cover.alignfull"
			).width();

			ScrollTrigger.create({
				trigger:
					".blocks--wrapper > .wp-block-cover.alignfull",
				start: "top 85%",
				end: "bottom 15%",
				duration: 1,
				onEnter: (ScrollTrigger) => {
					$(ScrollTrigger.trigger).width();
					$(ScrollTrigger.trigger).addClass("handle-has-entered-view");
				},
				onLeave: (ScrollTrigger) => {
					// $(ScrollTrigger.trigger).removeClass("handle-has-entered-view");
					// $(ScrollTrigger.trigger).width();
				},
			});
		},
	};

	// ? start of $.ready
	$(function () {
		//
		if (!$("body").hasClass("page-template-template-search")) {

			// let scroller = ScrollSmoother.create({
			// 	wrapper: "#main",
			// 	content: ".blocks--wrapper",
			// });

			// window.nu__smoothscroller = scroller;
		}

		// $("body").append('<div id="vertical-scroll-line"></div');
		// $(".blocks--wrapper").append('<div id="vertical-scroll-line"></div');

		if( !$("body").hasClass('search') ){
			$("#main").append('<div id="vertical-scroll-line"></div');
		}



		// * Vertical scroll line
		gsap.to("#vertical-scroll-line", {
			scrollTrigger: {
				trigger: "#vertical-scroll-line",			// this should actually be #main i think?
				start: "top 0%",
				end: "+=" + document.body.scrollHeight,
				scrub: true,
			},
			height: "100vh",
		});

		Batched_ScrollTriggers._init();

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
