"use strict";
(globalThis["webpackChunkgutenslider"] = globalThis["webpackChunkgutenslider"] || []).push([["gutenslider-js"],{

/***/ "./src/blocks/gutenslider/gutenslider.js":
/*!***********************************************!*\
  !*** ./src/blocks/gutenslider/gutenslider.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Gutenslider)
/* harmony export */ });
/* harmony import */ var _media_video_player_placeholder_gif__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./media/video_player_placeholder.gif */ "./src/blocks/gutenslider/media/video_player_placeholder.gif");

class Gutenslider {
  constructor(el) {
    const gsDomSlideSelector = ".swiper-wrapper .wp-block-eedee-block-gutenslide:not(.swiper-slide-duplicate)";
    const gsBgImgSelector = ".wp-block-eedee-block-gutenslide:not(.swiper-slide-duplicate) .eedee-background-div img";
    this.el = el;
    this.domSwiper = this.el.querySelector(".swiper");
    this.swiperSettings = JSON.parse(this.domSwiper.dataset.settings);
    this.domSlides = this.el.querySelectorAll(gsDomSlideSelector);

    // this.mouseX = this.el.clientWidth / 2.0;
    // this.mouseY = this.el.clientHeight / 2.0;
    // this.dMouseX = 0;
    // this.dMouseY = 0;
    this.damping = 0.5;
    this.isMouseOnLeft = true;
    this.isLeftArrowVisible = false;
    this.isRightArrowVisible = false;
    this.leftArrow = this.el.querySelector(".eedee-gutenslider-prev");
    this.rightArrow = this.el.querySelector(".eedee-gutenslider-next");
    this.gsBreakpoints = [600, 960];

    // medias (as an array to make it a little easier to manage)
    this.gsMediaQueries = [window.matchMedia(`(max-width: ${this.gsBreakpoints[0]}px)`), window.matchMedia(`(min-width: ${this.gsBreakpoints[0] + 1}px) and (max-width: ${this.gsBreakpoints[1]}px)`), window.matchMedia(`(min-width: ${this.gsBreakpoints[1] + 1}px)`)];
    this.overlayBgColor = getComputedStyle(this.el).getPropertyValue("--gutenslider-lightgallery-bg");
    this.fontColor = getComputedStyle(this.el).getPropertyValue("--gutenslider-lightgallery-font");
    this.lgTransition = this.el.dataset.lgTransition || "lg-slide";
    this.initSwiper = this.initSwiper.bind(this);
    this.destroy = this.destroy.bind(this);
    this.onLgAfterSlide = this.onLgAfterSlide.bind(this);
    this.onLgBeforeClose = this.onLgBeforeClose.bind(this);
    this.onLgBeforeOpen = this.onLgBeforeOpen.bind(this);
    this.addMediaQueryListeners = this.addMediaQueryListeners.bind(this);
    this.gsHandleBreakpoint = this.gsHandleBreakpoint.bind(this);
    this.onMouseMove = this.onMouseMove.bind(this);
    this.onMouseEnter = this.onMouseEnter.bind(this);
    this.onMouseLeave = this.onMouseLeave.bind(this);
    this.onClick = this.onClick.bind(this);
    this.init();
    return this;
  }
  init() {
    this.addMediaQueryListeners();
    this.updateDom();
    if (window.matchMedia && window.matchMedia("(pointer:fine)").matches && window.matchMedia("(hover:hover)").matches) {
      this.initArrowsFollowMouse();
    }
    this.gsHandleBreakpoint();
    if (this.swiperSettings.hasLg) {
      this.initLg();
    }
    /* <fs_premium_only> */
    // this.addParallax();
    /* </fs_premium_only> */
  }

  addMediaQueryListeners() {
    for (let i = 0; i < this.gsMediaQueries.length; i++) {
      try {
        // Chrome & Firefox
        this.gsMediaQueries[i].addEventListener("change", this.gsHandleBreakpoint);
      } catch (e) {
        // Safari 13.x
        if (e instanceof TypeError) {
          this.gsMediaQueries[i].addListener(e => this.gsHandleBreakpoint);
        } else {
          console.error(e);
        }
      }
    }
  }
  destroy() {
    this.swiperInstance && this.swiperInstance.destroy(true, true);
    return this;
  }
  initArrowsFollowMouse() {
    if (!this.swiperSettings.arrowsFollowMouse) {
      return;
    }
    this.raf();
    if (this.el.classList.contains("is-full")) {
      document.addEventListener("mousemove", this.onMouseMove);
      document.addEventListener("mouseenter", this.onMouseEnter);
      document.addEventListener("mouseleave", this.onMouseLeave);
      document.addEventListener("click", this.onClick);
      this.mouseX = 0;
      this.mouseY = 0;
      this.dMouseX = 0;
      this.dMouseY = 0;
      document.body.style.cursor = "none";
    } else {
      this.el.addEventListener("mousemove", this.onMouseMove);
      this.el.addEventListener("mouseenter", this.onMouseEnter);
      this.el.addEventListener("mouseleave", this.onMouseLeave);
      this.el.addEventListener("click", this.onClick);
      this.el.style.cursor = "none";
    }
    this.leftArrow.style.pointerEvents = "none";
    this.rightArrow.style.pointerEvents = "none";
    this.leftArrow.style.transition = "opacity 0.5s";
    this.rightArrow.style.transition = "opacity 0.5s";
    this.leftArrow.style.top = 0;
    this.leftArrow.style.left = 0;
    this.rightArrow.style.top = 0;
    this.rightArrow.style.left = 0;
    const extraSettings = {
      allowTouchMove: false
    };
    Object.assign(this.swiperSettings, extraSettings);
  }
  updateArrows() {
    const lArrowTop = `${this.dMouseY - this.leftArrow.clientHeight / 2.0}px`;
    const lArrowLeft = `${this.dMouseX - this.leftArrow.clientWidth / 2.0}px`;
    const rArrowTop = `${this.dMouseY - this.rightArrow.clientHeight / 2.0}px`;
    const rArrowLeft = `${this.dMouseX - this.rightArrow.clientWidth / 2.0}px`;
    this.leftArrow.style.transform = `translate3d(${lArrowLeft},${lArrowTop},0)`;
    this.rightArrow.style.transform = `translate3d(${rArrowLeft},${rArrowTop},0)`;
  }
  raf() {
    if (typeof this.dMouseX !== "undefined" && typeof this.dMouseY !== "undefined") {
      this.dMouseX -= (this.dMouseX - this.mouseX) * this.damping;
      this.dMouseY -= (this.dMouseY - this.mouseY) * this.damping;
    }
    this.updateArrows();
    window.requestAnimationFrame(this.raf.bind(this));
  }
  gsHandleBreakpoint() {
    let gsBreakpointKey = "";
    if (this.gsMediaQueries[0].matches) {
      gsBreakpointKey = "";
    } else if (this.gsMediaQueries[1].matches) {
      gsBreakpointKey = "settingsMd";
    } else if (this.gsMediaQueries[2].matches) {
      gsBreakpointKey = "settingsLg";
    }
    const extraSettings = gsBreakpointKey !== "" ? this.swiperSettings[gsBreakpointKey] : {};
    Object.assign(this.swiperSettings, extraSettings);
    this.initSwiper();
  }
  onMouseMove(e) {
    const bbox = this.el.getBoundingClientRect();
    this.mouseX = e.clientX - bbox.left;
    this.mouseY = e.clientY - bbox.top;
    if (this.mouseX > bbox.width / 2.0) {
      this.isMouseOnLeft = false;
      this.leftArrow.classList.remove("ed-active");
      this.rightArrow.classList.add("ed-active");
    } else {
      this.isMouseOnLeft = true;
      this.leftArrow.classList.add("ed-active");
      this.rightArrow.classList.remove("ed-active");
    }
    if (e.target.classList && e.target.classList.contains("swiper-pagination-bullet") || e.target.tagName === "A" || e.target.tagName === "BUTTON") {
      this.leftArrow.style.opacity = 0;
      this.rightArrow.style.opacity = 0;
    } else {
      this.leftArrow.style.opacity = 1;
      this.rightArrow.style.opacity = 1;
    }
  }
  onClick() {
    if (this.isMouseOnLeft && this.leftArrow.style.opacity !== "0") {
      this.swiperInstance && this.swiperInstance.slidePrev();
    } else if (!this.isMouseOnLeft && this.rightArrow.style.opacity !== "0") {
      this.swiperInstance && this.swiperInstance.slideNext();
    }
  }
  onMouseEnter(e) {
    this.mouseY = e.offsetY;
    this.mouseX = e.offsetX;
    this.dMouseX = e.offsetX;
    this.dMouseY = e.offsetY;
    this.leftArrow.style.opacity = 1;
    this.rightArrow.style.opacity = 1;
  }
  onMouseLeave() {
    this.leftArrow.style.opacity = 0;
    this.rightArrow.style.opacity = 0;
  }
  async initSwiper() {
    var _this$swiperSettings$, _this$swiperSettings$2, _this$swiperSettings$3;
    //first fix classNames
    if (this.swiperSettings.autoHeight) {
      this.el.classList.add("adaptive-height");
      this.el.classList.remove("fixed-height");
    } else {
      this.el.classList.remove("adaptive-height");
      this.el.classList.add("fixed-height");
    }
    if (this.swiperSettings.slidesPerView === "auto") {
      this.el.classList.remove("slides-number");
      this.el.classList.add("slides-auto");
    } else {
      this.el.classList.add("slides-number");
      this.el.classList.remove("slides-auto");
    }
    const {
      default: Swiper,
      A11y,
      History,
      HashNavigation
    } = await Promise.all(/*! import() | vendor/gs-swiper-base */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-base")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
    await Promise.all(/*! import() | vendor/gs-swiper-base */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-base")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css */ "./node_modules/swiper/swiper.min.css"));
    await __webpack_require__.e(/*! import() | vendor/gs-base */ "vendor/gs-base").then(__webpack_require__.bind(__webpack_require__, /*! ./style/gutenslider.scss */ "./src/blocks/gutenslider/style/gutenslider.scss"));
    if (this.el.classList.contains("content-change")) {
      await __webpack_require__.e(/*! import() | vendor/gs-content-change */ "vendor/gs-content-change").then(__webpack_require__.bind(__webpack_require__, /*! ./style/content-change.scss */ "./src/blocks/gutenslider/style/content-change.scss"));
    } else if (this.el.classList.contains("content-fixed")) {
      await __webpack_require__.e(/*! import() | vendor/gs-content-fixed */ "vendor/gs-content-fixed").then(__webpack_require__.bind(__webpack_require__, /*! ./style/content-fixed.scss */ "./src/blocks/gutenslider/style/content-fixed.scss"));
    }
    if (this.el.classList.contains("adaptive-height") || this.el.classList.contains("adaptive-height-md") || this.el.classList.contains("adaptive-height-sm")) {
      await __webpack_require__.e(/*! import() | vendor/gs-navigation */ "vendor/gs-navigation").then(__webpack_require__.bind(__webpack_require__, /*! ./style/adaptive-height.scss */ "./src/blocks/gutenslider/style/adaptive-height.scss"));
    }
    if (this.el.classList.contains("slides-auto")) {
      await __webpack_require__.e(/*! import() | vendor/gs-content-change */ "vendor/gs-content-change").then(__webpack_require__.bind(__webpack_require__, /*! ./style/slides-auto.scss */ "./src/blocks/gutenslider/style/slides-auto.scss"));
    }
    if ((_this$swiperSettings$ = this.swiperSettings.dividers) !== null && _this$swiperSettings$ !== void 0 ? _this$swiperSettings$ : false) {
      await __webpack_require__.e(/*! import() | vendor/gs-dividers */ "vendor/gs-dividers").then(__webpack_require__.bind(__webpack_require__, /*! ./style/dividers.scss */ "./src/blocks/gutenslider/style/dividers.scss"));
    }
    const swiperModules = [A11y, History, HashNavigation];
    if ((_this$swiperSettings$2 = this.swiperSettings.keyboard) !== null && _this$swiperSettings$2 !== void 0 ? _this$swiperSettings$2 : false) {
      const {
        Keyboard
      } = await __webpack_require__.e(/*! import() | vendor/gs-swiper-keyboard */ "vendor/gs-swiper-autoplay").then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
      swiperModules.push(Keyboard);
    }
    if (this.el.classList.contains("arrows-lg") || this.el.classList.contains("arrows-md") || this.el.classList.contains("arrows-sm")) {
      const {
        Navigation
      } = await __webpack_require__.e(/*! import() | vendor/gs-swiper-navigation */ "vendor/gs-swiper-autoplay").then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
      await __webpack_require__.e(/*! import() | vendor/gs-gs-swiper-navigation */ "vendor/gs-gs-swiper-navigation").then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/navigation */ "./node_modules/swiper/modules/navigation/navigation.min.css"));
      await __webpack_require__.e(/*! import() | vendor/gs-navigation */ "vendor/gs-navigation").then(__webpack_require__.bind(__webpack_require__, /*! ./style/navigation.scss */ "./src/blocks/gutenslider/style/navigation.scss"));
      swiperModules.push(Navigation);
    }
    if (this.el.classList.contains("dots-lg") || this.el.classList.contains("dots-md") || this.el.classList.contains("dots-sm")) {
      const {
        Pagination
      } = await Promise.all(/*! import() | vendor/gs-swiper-pagination */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-pagination")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
      await Promise.all(/*! import() | vendor/gs-swiper-pagination */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-pagination")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/pagination */ "./node_modules/swiper/modules/pagination/pagination.min.css"));
      await __webpack_require__.e(/*! import() | vendor/gs-pagination */ "vendor/gs-pagination").then(__webpack_require__.bind(__webpack_require__, /*! ./style/pagination.scss */ "./src/blocks/gutenslider/style/pagination.scss"));
      swiperModules.push(Pagination);
    }
    this.el.classList.add("gs-finished-controls");
    switch (this.swiperSettings.effect) {
      case "fade":
        const {
          EffectFade
        } = await Promise.all(/*! import() | vendor/gs-swiper-effect-fade */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-fade")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
        await Promise.all(/*! import() | vendor/gs-swiper-effect-fade */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-fade")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/effect-fade */ "./node_modules/swiper/modules/effect-fade/effect-fade.min.css"));
        swiperModules.push(EffectFade);
        break;
      case "flip":
        const {
          EffectFlip
        } = await Promise.all(/*! import() | vendor/gs-swiper-effect-flip */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-flip")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
        await Promise.all(/*! import() | vendor/gs-swiper-effect-flip */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-flip")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/effect-flip */ "./node_modules/swiper/modules/effect-flip/effect-flip.min.css"));
        swiperModules.push(EffectFlip);
        break;
      case "cube":
        const {
          EffectCube
        } = await Promise.all(/*! import() | vendor/gs-swiper-effect-cube */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-cube")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
        await Promise.all(/*! import() | vendor/gs-swiper-effect-cube */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-cube")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/effect-cube */ "./node_modules/swiper/modules/effect-cube/effect-cube.min.css"));
        swiperModules.push(EffectCube);
        break;
      case "cards":
        const {
          EffectCards
        } = await Promise.all(/*! import() | vendor/gs-swiper-effect-cards */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-cards")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
        await Promise.all(/*! import() | vendor/gs-swiper-effect-cards */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-effect-cards")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/effect-cards */ "./node_modules/swiper/modules/effect-cards/effect-cards.min.css"));
        swiperModules.push(EffectCards);
        break;
      case "coverflow":
        const {
          EffectCoverflow
        } = await __webpack_require__.e(/*! import() | vendor/gs-swiper-effect-coverflow */ "vendor/gs-swiper-autoplay").then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
        await Promise.all(/*! import() | vendor/gs-swiper-pagination */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-pagination")]).then(__webpack_require__.bind(__webpack_require__, /*! swiper/css/effect-coverflow */ "./node_modules/swiper/modules/effect-coverflow/effect-coverflow.min.css"));
        swiperModules.push(EffectCoverflow);
        break;
      case "gl":
        console.log("yeah GL");
        const {
          default: SwiperGL
        } = await __webpack_require__.e(/*! import() | vendor/gs-swiper-gl */ "vendor/gs-swiper-gl").then(__webpack_require__.bind(__webpack_require__, /*! ../../../vendor/swiper-gl */ "./vendor/swiper-gl.js"));
        await Promise.all(/*! import() | vendor/gs-swiper-pagination */[__webpack_require__.e("vendor/gs-swiper-autoplay"), __webpack_require__.e("vendor/gs-swiper-pagination")]).then(__webpack_require__.bind(__webpack_require__, /*! ./style/swiper-gl.scss */ "./src/blocks/gutenslider/style/swiper-gl.scss"));
        swiperModules.push(SwiperGL);
        break;
      default:
    }
    if ((_this$swiperSettings$3 = this.swiperSettings.autoplay) !== null && _this$swiperSettings$3 !== void 0 ? _this$swiperSettings$3 : false) {
      const {
        Autoplay
      } = await __webpack_require__.e(/*! import() | vendor/gs-swiper-autoplay */ "vendor/gs-swiper-autoplay").then(__webpack_require__.bind(__webpack_require__, /*! swiper */ "./node_modules/swiper/swiper.esm.js"));
      swiperModules.push(Autoplay);
    }
    this.swiperInstance && this.swiperInstance.destroy(true, true);
    this.swiperInstance = new Swiper(this.domSwiper, {
      ...this.swiperSettings,
      // gl: { shader: "morph-x" },
      modules: swiperModules,
      // preloadImages: true,
      // watchSlidesProgress: true,
      // watchSlidesVisibility: true,
      on: {
        init: () => {
          /* <fs_premium_only> */
          this.addParallax();
          /* </fs_premium_only> */
        },

        transitionStart: swiper => {
          this.addParallax();

          // pause videos if wanted
          swiper.slides.forEach(slide => {
            if (slide.classList.contains("ed-bg-video")) {
              const video = slide.querySelector("video");
              if (!video.classList.contains("bg-video-autopause")) {
                return;
              }
              if (slide.classList.contains("swiper-slide-visible")) {
                if (video) {
                  video.play();
                }
              } else {
                if (video) {
                  video.pause();
                }
              }
            }
          });
        }
      }
    });
    this.el.classList.add("gs-finished-layout");

    // some styles are only added after loading
    [...document.querySelectorAll(".eedee-gutenslider-nav svg, .eedee-gutenslider-nav #bg, .eedee-gutenslider-nav .bg, .eedee-gutenslider-nav #arrow, .eedee-gutenslider-nav .arrow")].forEach(e => {
      e.style.transition = "fill 0.3s, stroke 0.3s, background 0.3s, transform 0.5s";
    });
    return this.swiperInstance;
  }

  /**
   * Add dataset attributes to all dom elements for lg + hashnavigation
   */
  updateDom() {
    const slides = this.el.querySelectorAll(".wp-block-eedee-block-gutenslide");
    let relevantLgMediaIdx = 0;
    const sliderHashId = this.el.dataset.hash ? this.el.dataset.hash : this.el.id;
    [...slides].forEach(function (lgSlide, idx) {
      if (lgSlide.classList.contains("ed-bg-image") || lgSlide.classList.contains("ed-bg-video")) {
        //we have a lg relevant slide
        lgSlide.dataset.lgImageIdx = relevantLgMediaIdx;
        relevantLgMediaIdx++;
        if (lgSlide.classList.contains("ed-bg-video")) {
          const bgVideoEl = lgSlide.querySelector(".eedee-background-div video");
          lgSlide.style.width = `${bgVideoEl.width}px`;
        }
      }
      if (typeof lgSlide.dataset.hash === undefined || lgSlide.dataset.hash === "") {
        lgSlide.dataset.hash = `${sliderHashId}-${idx + 1}`;
      }
    });
  }
  async initLg() {
    const {
      default: lightGallery
    } = await Promise.all(/*! import() | vendor/gs-lightgallery-base */[__webpack_require__.e("vendors-node_modules_lightgallery_lightgallery_es5_js"), __webpack_require__.e("vendor/gs-lightgallery-base")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery */ "./node_modules/lightgallery/lightgallery.es5.js"));
    await Promise.all(/*! import() | vendor/gs-lightgallery-base */[__webpack_require__.e("vendors-node_modules_lightgallery_lightgallery_es5_js"), __webpack_require__.e("vendor/gs-lightgallery-base")]).then(__webpack_require__.bind(__webpack_require__, /*! ./style/lightgallery.scss */ "./src/blocks/gutenslider/style/lightgallery.scss"));
    const lgPlugins = [];

    //todo only when video
    const {
      default: lgVideo
    } = await Promise.all(/*! import() | vendor/gs-lightgallery-video */[__webpack_require__.e("vendors-node_modules_lightgallery_plugins_video_lg-video_es5_js-node_modules_lightgallery_scs-d9ecf1"), __webpack_require__.e("vendor/gs-lightgallery-video")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery/plugins/video */ "./node_modules/lightgallery/plugins/video/lg-video.es5.js"));
    await Promise.all(/*! import() | vendor/gs-lightgallery-video */[__webpack_require__.e("vendors-node_modules_lightgallery_plugins_video_lg-video_es5_js-node_modules_lightgallery_scs-d9ecf1"), __webpack_require__.e("vendor/gs-lightgallery-video")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery/scss/lg-video.scss */ "./node_modules/lightgallery/scss/lg-video.scss"));
    lgPlugins.push(lgVideo);
    if (this.swiperSettings.lgZoomEnabled) {
      const {
        default: lgZoom
      } = await Promise.all(/*! import() | vendor/gs-lightgallery-zoom */[__webpack_require__.e("vendors-node_modules_lightgallery_plugins_zoom_lg-zoom_es5_js-node_modules_lightgallery_scss_-e0fa60"), __webpack_require__.e("vendor/gs-lightgallery-zoom")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery/plugins/zoom */ "./node_modules/lightgallery/plugins/zoom/lg-zoom.es5.js"));
      await Promise.all(/*! import() | vendor/gs-lightgallery-zoom */[__webpack_require__.e("vendors-node_modules_lightgallery_plugins_zoom_lg-zoom_es5_js-node_modules_lightgallery_scss_-e0fa60"), __webpack_require__.e("vendor/gs-lightgallery-zoom")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery/scss/lg-zoom.scss */ "./node_modules/lightgallery/scss/lg-zoom.scss"));
      lgPlugins.push(lgZoom);
    }
    if (this.swiperSettings.lgThumbnails) {
      const {
        default: lgThumbnail
      } = await Promise.all(/*! import() | vendor/gs-lightgallery-thumbnail */[__webpack_require__.e("vendors-node_modules_lightgallery_plugins_thumbnail_lg-thumbnail_es5_js-node_modules_lightgal-0a31ec"), __webpack_require__.e("vendor/gs-lightgallery-thumbnail")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery/plugins/thumbnail */ "./node_modules/lightgallery/plugins/thumbnail/lg-thumbnail.es5.js"));
      await Promise.all(/*! import() | vendor/gs-lightgallery-thumbnail */[__webpack_require__.e("vendors-node_modules_lightgallery_plugins_thumbnail_lg-thumbnail_es5_js-node_modules_lightgal-0a31ec"), __webpack_require__.e("vendor/gs-lightgallery-thumbnail")]).then(__webpack_require__.bind(__webpack_require__, /*! lightgallery/scss/lg-thumbnail.scss */ "./node_modules/lightgallery/scss/lg-thumbnail.scss"));
      lgPlugins.push(lgThumbnail);
    }
    const dynamicEl = [...this.domSlides].reduce((result, domSlide) => {
      let lgElement;
      if (domSlide.classList.contains("ed-bg-image")) {
        const bgImg = domSlide.querySelector(".eedee-background-div img");
        lgElement = {
          src: bgImg.src,
          thumb: bgImg.src,
          alt: bgImg.alt,
          srcset: bgImg.srcset
        };
      } else if (domSlide.classList.contains("ed-bg-video")) {
        const bgVideo = domSlide.querySelector(".eedee-background-div video");
        const poster = bgVideo.hasAttribute("poster") && bgVideo.getAttribute("poster") !== "" ? bgVideo.poster : eedeeGutenslider.pluginsUrl + "/build/images/video_player_placeholder.gif";
        lgElement = {
          size: `${bgVideo.dataset.width}-${bgVideo.dataset.height}`,
          video: {
            source: [{
              src: bgVideo.src,
              type: bgVideo.getAttribute("type"),
              alt: bgVideo.alt
            }],
            attributes: {
              controls: true
            }
          },
          poster: poster,
          thumb: poster
        };
        if (bgVideo.hasAttribute("loop")) {
          lgElement.video.attributes.loop = "";
        }
      } else {
        return result;
      }
      const slideMedium = domSlide.querySelector("img, video");
      let slideTitle = "";
      if (this.swiperSettings.lgTitle) {
        if (this.swiperSettings.lgTitle === "title") {
          slideTitle = typeof slideMedium.dataset.title === "undefined" ? "" : slideMedium.dataset.title;
        }
        if (this.swiperSettings.lgTitle === "alt") {
          slideTitle = typeof slideMedium.dataset.alt === "undefined" ? "" : slideMedium.alt;
        }
      }
      let slideCaption = "";
      if (this.swiperSettings.lgCaption) {
        if (this.swiperSettings.lgCaption === "caption") {
          slideCaption = typeof slideMedium.dataset.caption === "undefined" ? "" : slideMedium.dataset.caption;
        }
        if (this.swiperSettings.lgCaption === "description") {
          slideCaption = typeof slideMedium.dataset.description === "undefined" ? "" : slideMedium.dataset.description;
        }
        if (this.swiperSettings.lgCaption === "alt") {
          slideCaption = typeof slideMedium.dataset.alt === "undefined" ? "" : slideMedium.alt;
        }
      }
      lgElement = {
        ...lgElement,
        subHtml: `<h4>${slideTitle}</h4><p>${slideCaption}</p>`
      };
      result.push(lgElement);
      return result;
    }, []);
    console.log("dynamicEl", dynamicEl);
    this.lightGallery = lightGallery(this.el, {
      licenseKey: "1234-4932-1281-3121",
      plugins: lgPlugins,
      dynamic: true,
      dynamicEl,
      mode: this.lgTransition,
      container: document.body,
      addClass: "gs-lightgallery",
      download: false,
      hideBarsDelay: 2000,
      loop: Boolean(this.swiperSettings.loop),
      counter: Boolean(this.swiperSettings.hasLgCounter),
      autoplayFirstVideo: false
    });
    this.el.addEventListener("lgAfterSlide", this.onLgAfterSlide);
    this.el.addEventListener("lgBeforeOpen", this.onLgBeforeOpen);
    this.el.addEventListener("lgBeforeClose", this.onLgBeforeClose);

    // add event listeners
    [...this.el.querySelectorAll(".wp-block-eedee-block-gutenslide")].map((slide, idx) => {
      //do not add lightgallery if we have no bg media
      if (!slide.classList.contains("ed-bg-image") && !slide.classList.contains("ed-bg-video")) {
        return;
      }
      //do not add lightgallery if we have a link
      if (slide.querySelector(".slide-link") !== null) {
        return;
      }
      slide.addEventListener("click", () => {
        const indexToOpen = parseInt(slide.dataset.lgImageIdx);
        this.lightGallery.openGallery(indexToOpen ? indexToOpen : 0);
        this.lightGallery.$backdrop.firstElement.style.backgroundColor = this.overlayBgColor ? this.overlayBgColor : "#fff";
        this.lightGallery.$container.firstElement.style.setProperty("--gutenslider-lightgallery-font", this.fontColor);
      });
    });
  }
  onLgBeforeOpen(e) {
    if (this.swiperSettings.autoplay) {
      this.swiperInstance.autoplay.stop();
    }
  }
  onLgBeforeClose(e) {
    if (this.swiperSettings.autoplay) {
      setTimeout(() => {
        this.swiperInstance && this.swiperInstance.autoplay.start();
      }, 1000);
    }
  }
  onLgAfterSlide(e) {
    const {
      index
    } = e.detail;
    if (typeof index !== "undefined") {
      const activeSlide = this.el.querySelector(`[data-lg-image-idx="${index}"]`);
      const imageIndex = activeSlide && activeSlide.dataset.swiperSlideIndex;
      if (this.swiperSettings.loop) {
        this.swiperInstance && this.swiperInstance.slideToLoop(parseInt(imageIndex));
      } else {
        this.swiperInstance && this.swiperInstance.slideTo(parseInt(imageIndex));
      }
    }
  }
  /* <fs_premium_only> */
  async addParallax() {
    const that = this;
    if (this.el.classList.contains("has-parallax")) {
      const {
        default: simpleParallax
      } = await __webpack_require__.e(/*! import() | gs-parallax */ "gs-parallax").then(__webpack_require__.t.bind(__webpack_require__, /*! simple-parallax-js */ "./node_modules/simple-parallax-js/dist/simpleParallax.min.js", 23));
      if (typeof simpleParallax !== undefined) {
        const orientation = this.el.dataset.parallaxDirection || "top";
        const scale = this.el.dataset.parallaxAmount || 1.3;
        const images = this.el.querySelectorAll(".swiper-slide-visible .eedee-background-div img");
        images.forEach(img => {
          if (!img.classList.contains("simpleParallax")) {
            new simpleParallax(img, {
              scale,
              orientation
            });
          }
        });
      }
    }
  }

  /* </fs_premium_only> */
}

/***/ }),

/***/ "./src/blocks/gutenslider/media/video_player_placeholder.gif":
/*!*******************************************************************!*\
  !*** ./src/blocks/gutenslider/media/video_player_placeholder.gif ***!
  \*******************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/video_player_placeholder.gif";

/***/ })

}]);
//# sourceMappingURL=gutenslider-js.js.map