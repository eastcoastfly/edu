//
(function ($, window, document) {
	//

	const PostsGrid_Swiper = {
		swiperSettings: {
			autoplay: false,
			speed: 700,
			direction: "horizontal",
			loop: false,
			centeredSlides: false,
			spaceBetween: 4,
			slidesPerView: 1.2,
			slidesPerGroup: 1,

			effect: "slide",
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			createElements: true,
			draggable: true,
			freeMode: true,
			pagination: {
				type: "progressbar",
				clickable: true,
				dynamicBullets: false,
			},
			scrollbar: {
				draggable: true,
				snapOnRelease: true,
				dragSize: "80",
				hide: false,
			},
			navigation: {
				prevEl: null,
				nextEl: null,
			},
			width: null,
			slidesPerGroupAuto: false,
		},

		_init: function () {
			const foundBlocks = $(".is-style-as-draggable-slider.posts-grid");

			if (!foundBlocks.length > 0) {
				return;
			}

			// loop thru all hits
			for (let index = 0; index < foundBlocks.length; index++) {
				PostsGrid_Swiper._instance(foundBlocks[index]);
			}
		},

		//
		_instance: function (blockElem) {
			if (!window.Swiper) {
				return;
			}
			//
			const Swiper = window.Swiper;
			//
			let blockID = "#" + $(blockElem).attr("ID");
			//
			let groupContainer = $(blockElem).closest(".wp-block-group");
			//
			//
			PostsGrid_Swiper._handleModifySettings(blockID, groupContainer);
			//
			PostsGrid_Swiper._handleSetupClasses(blockID, groupContainer);
			//
			PostsGrid_Swiper._handleAppendElems(blockID, groupContainer);

			const swiper = new Swiper( blockID+" .swiper", PostsGrid_Swiper.swiperSettings);

			PostsGrid_Swiper._handleHoistScrollProgress(blockID, groupContainer);

		},
		//
		_handleModifySettings: function (blockID, groupContainer) {
			//
			PostsGrid_Swiper.swiperSettings.scrollbar.el =
				blockID + " .swiper-scrollbar";
			PostsGrid_Swiper.swiperSettings.pagination.el =
				blockID + " .swiper-pagination";
		},
		//
		_handleHoistScrollProgress: function (blockID, groupContainer) {
			//
			//
			$(blockID + " .swiper-scrollbar-drag").append(
				'<i class="fa-light fa-arrow-left"></i><i class="fa-light fa-arrow-right"></i>'
			);
			//
			let newScrollbarContainer = $(
				".swiper-scrollbar-custom-container",
				groupContainer
			);
			//
			//
			$(blockID + " .swiper-scrollbar")
				.detach()
				.appendTo(newScrollbarContainer);
			//
			$(blockID + " .swiper-pagination-progressbar")
				.detach()
				.appendTo(newScrollbarContainer);
		},

		_handleAppendElems: function (blockID, groupContainer) {
			// add a container to build our progress/drag bar
			groupContainer.append(
				'<div class="swiper-scrollbar-custom-container alignwide"></div>'
			);
			//
			$(".swiper-wrapper", groupContainer).append(
				'<div class="swiper-pagination"></div>'
			);
			$(".swiper-wrapper", groupContainer).append(
				'<div class="swiper-scrollbar"></div>'
			);
		},
		//
		_handleSetupClasses: function (blockID, groupContainer) {
			//
			groupContainer.addClass('is-the-draggable-slider-container');
			let gridWrapper = groupContainer.find(".nu__grid");
			//
			$(gridWrapper).removeClass([
				"cols-1",
				"cols-2",
				"cols-3",
				"cols-4",
				"cols-5",
				"cols-6",
				"cols-7",
			]);

			$(gridWrapper)
				.addClass("swiper")
				.children("ul")
				.addClass("swiper-wrapper")
				.children(".grid-item")
				.addClass("swiper-slide");
		},
	};

	//
	PostsGrid_Swiper._init();

	//
	$(function () {
		//
		// ? start of $.ready

		//
		// PostsGrid_Swiper._init();

		//

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
