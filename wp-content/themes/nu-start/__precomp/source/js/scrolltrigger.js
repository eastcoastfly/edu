(function ($, window, document) {
	/* 
		jQuery document ready
	*/
	//
	$(function () {
		let $elements_to_stagger_fade = undefined;
		// create an array of elements that we would like to batch with the same staggered fade-in animation
		// (just syntactical sugar)
		$elements_to_stagger_fade = gsap.utils.toArray([
			".nu__grid .grid-item",
			".wp-block-column > :only-child:not(.is-sticky-on-scroll)",
		]);

		if ($elements_to_stagger_fade.length) {
			// set the initial state of the elements to faded-out and nudged-down
			gsap.set($elements_to_stagger_fade, { opacity: 0, y: 30 });

			// batch animation for all elements
			ScrollTrigger.batch($elements_to_stagger_fade, {
				start: "top 85%",
				end: "bottom 15%",
				duration: 0.6,
				onEnter: (batch) =>
					gsap.to(batch, { y: 0, autoAlpha: 1, stagger: 0.2 }),
			});
		}

		let $media_text_blocks = gsap.utils.toArray([".wp-block-media-text"]);

		if ($media_text_blocks.length) {
			//
			// set the initial state of the elements to faded-out and nudged-down
			gsap.set(".wp-block-media-text__media", { y: 40, opacity: 0 });
			gsap.set(".wp-block-media-text__content", { x: 40, opacity: 0 });

			ScrollTrigger.batch($media_text_blocks, {
				start: "top 85%",
				end: "bottom 15%",
				onEnter: (batch) =>
					batch.forEach((block, index) => {
						let figure = block.querySelectorAll(
							".wp-block-media-text__media"
						);
						let content = block.querySelectorAll(
							".wp-block-media-text__content"
						);
						//
						gsap.to(figure, {
							duration: 1.3,
							opacity: 1,
							y: 0,
							delay: 0.3,
						});
						gsap.to(content, { duration: 1.3, opacity: 1, x: 0 });
					}),
			});
		}
	});
})(window.jQuery, window, document);
