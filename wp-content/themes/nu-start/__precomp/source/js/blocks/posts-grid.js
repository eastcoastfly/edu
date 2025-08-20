/* 
	PostsGrid Block - Scripts
*/

//
(function ($, window, document) {
	/**
	 *   ... code out here will run immediately on load
	 */
	//

	/**
	 *   ... code in here will run after jQuery says document is ready
	 */
	//
	$(function () {
		let currentPage = 1;

		$("#load-more").on("click", function () {
			// this has been added via localize script
			// the query arguments fed to the block are just passed directly here
			const blockSettings = postsgrid_block_settings;
			const presetArgs = block_default_query_args;
			const blockFields = postsgrid_block_fields;
			let queryArgs = presetArgs;

			// Do currentPage + 1, because we want to load the next page
			currentPage++;

			// set the query args directly
			queryArgs.paged = currentPage;

			$.ajax({
				type: "POST",
				url: postsgrid_ajax_object.ajaxurl,
				dataType: "json",
				data: {
					action: "ajax_query_for_posts",
					_ajax_nonce: postsgrid_ajax_object.ajax_nonce,
					paged: currentPage,
					blockFields: blockFields,
					queryArgs: queryArgs,
				},
				success: function (res) {
					//
					if (queryArgs.paged >= res.max) {
						$("#posts-grid--" + blockSettings.id + " #load-more").hide();
					}

					//
					$("#posts-grid--" + blockSettings.id + " .nu__grid > ul").append(
						res.html
					);

					$elements_to_stagger_fade = gsap.utils.toArray([
						".nu__grid .grid-item.is-loaded-by-ajax:not(.is-animated)",
					]);

					if ($elements_to_stagger_fade.length) {
						// set the initial state of the elements to faded-out and nudged-down
						gsap.set($elements_to_stagger_fade, {
							opacity: 0,
							y: 30,
						});

						// batch animation for all elements
						ScrollTrigger.batch($elements_to_stagger_fade, {
							start: "top 85%",
							end: "bottom 15%",
							duration: 0.6,
							onEnter: (batch) =>
								gsap.to(batch, {
									y: 0,
									autoAlpha: 1,
									stagger: 0.2,
									onComplete: function () {
										let $targets = this.targets();
										$($targets).each(function () {
											$(this).addClass("is-animated");
										});
									},
								}),
						});
					}
				},
			});
		});

		// code is poetry...

		$(".acf-block.posts-grid").each(function (index, element) {
			let $id = $(this).attr("id");

			let $filterForm = $(this).find("form");

			$(this).find(".filteringform").addClass("is-revealed");

			let $grid_items = $(this).find(".nu__grid > ul");

			let $formID = $filterForm.attr("name");

			let $filtering_navicon = $(this).find(".filtering-navicon");

			$filtering_navicon.on("click", function (e) {
				$(this).toggleClass("is-revealed");
				// $filterForm.slideToggle();
			});

			$(".js__filteringform select").each(function (index, element) {
				// let $placeholder = $(element).data("placeholder");
				let firstOptionValue = $(element).children()[0].innerHTML;

				// initialize the Selectize control
				var $select = $(element).selectize({
					plugins: ["remove_button", "restore_on_backspace"],
					// placeholder: $placeholder,
					placeholder: firstOptionValue,
				});
			});
		});

		// code was poetry...
	});
})(window.jQuery, window, document);
