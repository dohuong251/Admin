/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/bootstrap/js/src/modal.js":
/*!************************************************!*\
  !*** ./node_modules/bootstrap/js/src/modal.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./util */ "./node_modules/bootstrap/js/src/util.js");
/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.3.1): modal.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */




/**
 * ------------------------------------------------------------------------
 * Constants
 * ------------------------------------------------------------------------
 */

const NAME               = 'modal'
const VERSION            = '4.3.1'
const DATA_KEY           = 'bs.modal'
const EVENT_KEY          = `.${DATA_KEY}`
const DATA_API_KEY       = '.data-api'
const JQUERY_NO_CONFLICT = jquery__WEBPACK_IMPORTED_MODULE_0___default.a.fn[NAME]
const ESCAPE_KEYCODE     = 27 // KeyboardEvent.which value for Escape (Esc) key

const Default = {
  backdrop : true,
  keyboard : true,
  focus    : true,
  show     : true
}

const DefaultType = {
  backdrop : '(boolean|string)',
  keyboard : 'boolean',
  focus    : 'boolean',
  show     : 'boolean'
}

const Event = {
  HIDE              : `hide${EVENT_KEY}`,
  HIDDEN            : `hidden${EVENT_KEY}`,
  SHOW              : `show${EVENT_KEY}`,
  SHOWN             : `shown${EVENT_KEY}`,
  FOCUSIN           : `focusin${EVENT_KEY}`,
  RESIZE            : `resize${EVENT_KEY}`,
  CLICK_DISMISS     : `click.dismiss${EVENT_KEY}`,
  KEYDOWN_DISMISS   : `keydown.dismiss${EVENT_KEY}`,
  MOUSEUP_DISMISS   : `mouseup.dismiss${EVENT_KEY}`,
  MOUSEDOWN_DISMISS : `mousedown.dismiss${EVENT_KEY}`,
  CLICK_DATA_API    : `click${EVENT_KEY}${DATA_API_KEY}`
}

const ClassName = {
  SCROLLABLE         : 'modal-dialog-scrollable',
  SCROLLBAR_MEASURER : 'modal-scrollbar-measure',
  BACKDROP           : 'modal-backdrop',
  OPEN               : 'modal-open',
  FADE               : 'fade',
  SHOW               : 'show'
}

const Selector = {
  DIALOG         : '.modal-dialog',
  MODAL_BODY     : '.modal-body',
  DATA_TOGGLE    : '[data-toggle="modal"]',
  DATA_DISMISS   : '[data-dismiss="modal"]',
  FIXED_CONTENT  : '.fixed-top, .fixed-bottom, .is-fixed, .sticky-top',
  STICKY_CONTENT : '.sticky-top'
}

/**
 * ------------------------------------------------------------------------
 * Class Definition
 * ------------------------------------------------------------------------
 */

class Modal {
  constructor(element, config) {
    this._config              = this._getConfig(config)
    this._element             = element
    this._dialog              = element.querySelector(Selector.DIALOG)
    this._backdrop            = null
    this._isShown             = false
    this._isBodyOverflowing   = false
    this._ignoreBackdropClick = false
    this._isTransitioning     = false
    this._scrollbarWidth      = 0
  }

  // Getters

  static get VERSION() {
    return VERSION
  }

  static get Default() {
    return Default
  }

  // Public

  toggle(relatedTarget) {
    return this._isShown ? this.hide() : this.show(relatedTarget)
  }

  show(relatedTarget) {
    if (this._isShown || this._isTransitioning) {
      return
    }

    if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).hasClass(ClassName.FADE)) {
      this._isTransitioning = true
    }

    const showEvent = jquery__WEBPACK_IMPORTED_MODULE_0___default.a.Event(Event.SHOW, {
      relatedTarget
    })

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).trigger(showEvent)

    if (this._isShown || showEvent.isDefaultPrevented()) {
      return
    }

    this._isShown = true

    this._checkScrollbar()
    this._setScrollbar()

    this._adjustDialog()

    this._setEscapeEvent()
    this._setResizeEvent()

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).on(
      Event.CLICK_DISMISS,
      Selector.DATA_DISMISS,
      (event) => this.hide(event)
    )

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._dialog).on(Event.MOUSEDOWN_DISMISS, () => {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).one(Event.MOUSEUP_DISMISS, (event) => {
        if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(event.target).is(this._element)) {
          this._ignoreBackdropClick = true
        }
      })
    })

    this._showBackdrop(() => this._showElement(relatedTarget))
  }

  hide(event) {
    if (event) {
      event.preventDefault()
    }

    if (!this._isShown || this._isTransitioning) {
      return
    }

    const hideEvent = jquery__WEBPACK_IMPORTED_MODULE_0___default.a.Event(Event.HIDE)

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).trigger(hideEvent)

    if (!this._isShown || hideEvent.isDefaultPrevented()) {
      return
    }

    this._isShown = false
    const transition = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).hasClass(ClassName.FADE)

    if (transition) {
      this._isTransitioning = true
    }

    this._setEscapeEvent()
    this._setResizeEvent()

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).off(Event.FOCUSIN)

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).removeClass(ClassName.SHOW)

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).off(Event.CLICK_DISMISS)
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._dialog).off(Event.MOUSEDOWN_DISMISS)


    if (transition) {
      const transitionDuration  = _util__WEBPACK_IMPORTED_MODULE_1__["default"].getTransitionDurationFromElement(this._element)

      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element)
        .one(_util__WEBPACK_IMPORTED_MODULE_1__["default"].TRANSITION_END, (event) => this._hideModal(event))
        .emulateTransitionEnd(transitionDuration)
    } else {
      this._hideModal()
    }
  }

  dispose() {
    [window, this._element, this._dialog]
      .forEach((htmlElement) => jquery__WEBPACK_IMPORTED_MODULE_0___default()(htmlElement).off(EVENT_KEY))

    /**
     * `document` has 2 events `Event.FOCUSIN` and `Event.CLICK_DATA_API`
     * Do not move `document` in `htmlElements` array
     * It will remove `Event.CLICK_DATA_API` event that should remain
     */
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).off(Event.FOCUSIN)

    jquery__WEBPACK_IMPORTED_MODULE_0___default.a.removeData(this._element, DATA_KEY)

    this._config              = null
    this._element             = null
    this._dialog              = null
    this._backdrop            = null
    this._isShown             = null
    this._isBodyOverflowing   = null
    this._ignoreBackdropClick = null
    this._isTransitioning     = null
    this._scrollbarWidth      = null
  }

  handleUpdate() {
    this._adjustDialog()
  }

  // Private

  _getConfig(config) {
    config = {
      ...Default,
      ...config
    }
    _util__WEBPACK_IMPORTED_MODULE_1__["default"].typeCheckConfig(NAME, config, DefaultType)
    return config
  }

  _showElement(relatedTarget) {
    const transition = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).hasClass(ClassName.FADE)

    if (!this._element.parentNode ||
        this._element.parentNode.nodeType !== Node.ELEMENT_NODE) {
      // Don't move modal's DOM position
      document.body.appendChild(this._element)
    }

    this._element.style.display = 'block'
    this._element.removeAttribute('aria-hidden')
    this._element.setAttribute('aria-modal', true)

    if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._dialog).hasClass(ClassName.SCROLLABLE)) {
      this._dialog.querySelector(Selector.MODAL_BODY).scrollTop = 0
    } else {
      this._element.scrollTop = 0
    }

    if (transition) {
      _util__WEBPACK_IMPORTED_MODULE_1__["default"].reflow(this._element)
    }

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).addClass(ClassName.SHOW)

    if (this._config.focus) {
      this._enforceFocus()
    }

    const shownEvent = jquery__WEBPACK_IMPORTED_MODULE_0___default.a.Event(Event.SHOWN, {
      relatedTarget
    })

    const transitionComplete = () => {
      if (this._config.focus) {
        this._element.focus()
      }
      this._isTransitioning = false
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).trigger(shownEvent)
    }

    if (transition) {
      const transitionDuration  = _util__WEBPACK_IMPORTED_MODULE_1__["default"].getTransitionDurationFromElement(this._dialog)

      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._dialog)
        .one(_util__WEBPACK_IMPORTED_MODULE_1__["default"].TRANSITION_END, transitionComplete)
        .emulateTransitionEnd(transitionDuration)
    } else {
      transitionComplete()
    }
  }

  _enforceFocus() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(document)
      .off(Event.FOCUSIN) // Guard against infinite focus loop
      .on(Event.FOCUSIN, (event) => {
        if (document !== event.target &&
            this._element !== event.target &&
            jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).has(event.target).length === 0) {
          this._element.focus()
        }
      })
  }

  _setEscapeEvent() {
    if (this._isShown && this._config.keyboard) {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).on(Event.KEYDOWN_DISMISS, (event) => {
        if (event.which === ESCAPE_KEYCODE) {
          event.preventDefault()
          this.hide()
        }
      })
    } else if (!this._isShown) {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).off(Event.KEYDOWN_DISMISS)
    }
  }

  _setResizeEvent() {
    if (this._isShown) {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(window).on(Event.RESIZE, (event) => this.handleUpdate(event))
    } else {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(window).off(Event.RESIZE)
    }
  }

  _hideModal() {
    this._element.style.display = 'none'
    this._element.setAttribute('aria-hidden', true)
    this._element.removeAttribute('aria-modal')
    this._isTransitioning = false
    this._showBackdrop(() => {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(document.body).removeClass(ClassName.OPEN)
      this._resetAdjustments()
      this._resetScrollbar()
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).trigger(Event.HIDDEN)
    })
  }

  _removeBackdrop() {
    if (this._backdrop) {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._backdrop).remove()
      this._backdrop = null
    }
  }

  _showBackdrop(callback) {
    const animate = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).hasClass(ClassName.FADE)
      ? ClassName.FADE : ''

    if (this._isShown && this._config.backdrop) {
      this._backdrop = document.createElement('div')
      this._backdrop.className = ClassName.BACKDROP

      if (animate) {
        this._backdrop.classList.add(animate)
      }

      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._backdrop).appendTo(document.body)

      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).on(Event.CLICK_DISMISS, (event) => {
        if (this._ignoreBackdropClick) {
          this._ignoreBackdropClick = false
          return
        }
        if (event.target !== event.currentTarget) {
          return
        }
        if (this._config.backdrop === 'static') {
          this._element.focus()
        } else {
          this.hide()
        }
      })

      if (animate) {
        _util__WEBPACK_IMPORTED_MODULE_1__["default"].reflow(this._backdrop)
      }

      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._backdrop).addClass(ClassName.SHOW)

      if (!callback) {
        return
      }

      if (!animate) {
        callback()
        return
      }

      const backdropTransitionDuration = _util__WEBPACK_IMPORTED_MODULE_1__["default"].getTransitionDurationFromElement(this._backdrop)

      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._backdrop)
        .one(_util__WEBPACK_IMPORTED_MODULE_1__["default"].TRANSITION_END, callback)
        .emulateTransitionEnd(backdropTransitionDuration)
    } else if (!this._isShown && this._backdrop) {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._backdrop).removeClass(ClassName.SHOW)

      const callbackRemove = () => {
        this._removeBackdrop()
        if (callback) {
          callback()
        }
      }

      if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._element).hasClass(ClassName.FADE)) {
        const backdropTransitionDuration = _util__WEBPACK_IMPORTED_MODULE_1__["default"].getTransitionDurationFromElement(this._backdrop)

        jquery__WEBPACK_IMPORTED_MODULE_0___default()(this._backdrop)
          .one(_util__WEBPACK_IMPORTED_MODULE_1__["default"].TRANSITION_END, callbackRemove)
          .emulateTransitionEnd(backdropTransitionDuration)
      } else {
        callbackRemove()
      }
    } else if (callback) {
      callback()
    }
  }

  // ----------------------------------------------------------------------
  // the following methods are used to handle overflowing modals
  // todo (fat): these should probably be refactored out of modal.js
  // ----------------------------------------------------------------------

  _adjustDialog() {
    const isModalOverflowing =
      this._element.scrollHeight > document.documentElement.clientHeight

    if (!this._isBodyOverflowing && isModalOverflowing) {
      this._element.style.paddingLeft = `${this._scrollbarWidth}px`
    }

    if (this._isBodyOverflowing && !isModalOverflowing) {
      this._element.style.paddingRight = `${this._scrollbarWidth}px`
    }
  }

  _resetAdjustments() {
    this._element.style.paddingLeft = ''
    this._element.style.paddingRight = ''
  }

  _checkScrollbar() {
    const rect = document.body.getBoundingClientRect()
    this._isBodyOverflowing = rect.left + rect.right < window.innerWidth
    this._scrollbarWidth = this._getScrollbarWidth()
  }

  _setScrollbar() {
    if (this._isBodyOverflowing) {
      // Note: DOMNode.style.paddingRight returns the actual value or '' if not set
      //   while $(DOMNode).css('padding-right') returns the calculated value or 0 if not set
      const fixedContent = [].slice.call(document.querySelectorAll(Selector.FIXED_CONTENT))
      const stickyContent = [].slice.call(document.querySelectorAll(Selector.STICKY_CONTENT))

      // Adjust fixed content padding
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(fixedContent).each((index, element) => {
        const actualPadding = element.style.paddingRight
        const calculatedPadding = jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).css('padding-right')
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(element)
          .data('padding-right', actualPadding)
          .css('padding-right', `${parseFloat(calculatedPadding) + this._scrollbarWidth}px`)
      })

      // Adjust sticky content margin
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(stickyContent).each((index, element) => {
        const actualMargin = element.style.marginRight
        const calculatedMargin = jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).css('margin-right')
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(element)
          .data('margin-right', actualMargin)
          .css('margin-right', `${parseFloat(calculatedMargin) - this._scrollbarWidth}px`)
      })

      // Adjust body padding
      const actualPadding = document.body.style.paddingRight
      const calculatedPadding = jquery__WEBPACK_IMPORTED_MODULE_0___default()(document.body).css('padding-right')
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(document.body)
        .data('padding-right', actualPadding)
        .css('padding-right', `${parseFloat(calculatedPadding) + this._scrollbarWidth}px`)
    }

    jquery__WEBPACK_IMPORTED_MODULE_0___default()(document.body).addClass(ClassName.OPEN)
  }

  _resetScrollbar() {
    // Restore fixed content padding
    const fixedContent = [].slice.call(document.querySelectorAll(Selector.FIXED_CONTENT))
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(fixedContent).each((index, element) => {
      const padding = jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).data('padding-right')
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).removeData('padding-right')
      element.style.paddingRight = padding ? padding : ''
    })

    // Restore sticky content
    const elements = [].slice.call(document.querySelectorAll(`${Selector.STICKY_CONTENT}`))
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(elements).each((index, element) => {
      const margin = jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).data('margin-right')
      if (typeof margin !== 'undefined') {
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).css('margin-right', margin).removeData('margin-right')
      }
    })

    // Restore body padding
    const padding = jquery__WEBPACK_IMPORTED_MODULE_0___default()(document.body).data('padding-right')
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(document.body).removeData('padding-right')
    document.body.style.paddingRight = padding ? padding : ''
  }

  _getScrollbarWidth() { // thx d.walsh
    const scrollDiv = document.createElement('div')
    scrollDiv.className = ClassName.SCROLLBAR_MEASURER
    document.body.appendChild(scrollDiv)
    const scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth
    document.body.removeChild(scrollDiv)
    return scrollbarWidth
  }

  // Static

  static _jQueryInterface(config, relatedTarget) {
    return this.each(function () {
      let data = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).data(DATA_KEY)
      const _config = {
        ...Default,
        ...jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).data(),
        ...typeof config === 'object' && config ? config : {}
      }

      if (!data) {
        data = new Modal(this, _config)
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).data(DATA_KEY, data)
      }

      if (typeof config === 'string') {
        if (typeof data[config] === 'undefined') {
          throw new TypeError(`No method named "${config}"`)
        }
        data[config](relatedTarget)
      } else if (_config.show) {
        data.show(relatedTarget)
      }
    })
  }
}

/**
 * ------------------------------------------------------------------------
 * Data Api implementation
 * ------------------------------------------------------------------------
 */

jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (event) {
  let target
  const selector = _util__WEBPACK_IMPORTED_MODULE_1__["default"].getSelectorFromElement(this)

  if (selector) {
    target = document.querySelector(selector)
  }

  const config = jquery__WEBPACK_IMPORTED_MODULE_0___default()(target).data(DATA_KEY)
    ? 'toggle' : {
      ...jquery__WEBPACK_IMPORTED_MODULE_0___default()(target).data(),
      ...jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).data()
    }

  if (this.tagName === 'A' || this.tagName === 'AREA') {
    event.preventDefault()
  }

  const $target = jquery__WEBPACK_IMPORTED_MODULE_0___default()(target).one(Event.SHOW, (showEvent) => {
    if (showEvent.isDefaultPrevented()) {
      // Only register focus restorer if modal will actually get shown
      return
    }

    $target.one(Event.HIDDEN, () => {
      if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).is(':visible')) {
        this.focus()
      }
    })
  })

  Modal._jQueryInterface.call(jquery__WEBPACK_IMPORTED_MODULE_0___default()(target), config, this)
})

/**
 * ------------------------------------------------------------------------
 * jQuery
 * ------------------------------------------------------------------------
 */

jquery__WEBPACK_IMPORTED_MODULE_0___default.a.fn[NAME] = Modal._jQueryInterface
jquery__WEBPACK_IMPORTED_MODULE_0___default.a.fn[NAME].Constructor = Modal
jquery__WEBPACK_IMPORTED_MODULE_0___default.a.fn[NAME].noConflict = () => {
  jquery__WEBPACK_IMPORTED_MODULE_0___default.a.fn[NAME] = JQUERY_NO_CONFLICT
  return Modal._jQueryInterface
}

/* harmony default export */ __webpack_exports__["default"] = (Modal);


/***/ }),

/***/ "./node_modules/bootstrap/js/src/util.js":
/*!***********************************************!*\
  !*** ./node_modules/bootstrap/js/src/util.js ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.3.1): util.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */



/**
 * ------------------------------------------------------------------------
 * Private TransitionEnd Helpers
 * ------------------------------------------------------------------------
 */

const TRANSITION_END = 'transitionend'
const MAX_UID = 1000000
const MILLISECONDS_MULTIPLIER = 1000

// Shoutout AngusCroll (https://goo.gl/pxwQGp)
function toType(obj) {
  return {}.toString.call(obj).match(/\s([a-z]+)/i)[1].toLowerCase()
}

function getSpecialTransitionEndEvent() {
  return {
    bindType: TRANSITION_END,
    delegateType: TRANSITION_END,
    handle(event) {
      if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(event.target).is(this)) {
        return event.handleObj.handler.apply(this, arguments) // eslint-disable-line prefer-rest-params
      }
      return undefined // eslint-disable-line no-undefined
    }
  }
}

function transitionEndEmulator(duration) {
  let called = false

  jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).one(Util.TRANSITION_END, () => {
    called = true
  })

  setTimeout(() => {
    if (!called) {
      Util.triggerTransitionEnd(this)
    }
  }, duration)

  return this
}

function setTransitionEndSupport() {
  jquery__WEBPACK_IMPORTED_MODULE_0___default.a.fn.emulateTransitionEnd = transitionEndEmulator
  jquery__WEBPACK_IMPORTED_MODULE_0___default.a.event.special[Util.TRANSITION_END] = getSpecialTransitionEndEvent()
}

/**
 * --------------------------------------------------------------------------
 * Public Util Api
 * --------------------------------------------------------------------------
 */

const Util = {

  TRANSITION_END: 'bsTransitionEnd',

  getUID(prefix) {
    do {
      // eslint-disable-next-line no-bitwise
      prefix += ~~(Math.random() * MAX_UID) // "~~" acts like a faster Math.floor() here
    } while (document.getElementById(prefix))
    return prefix
  },

  getSelectorFromElement(element) {
    let selector = element.getAttribute('data-target')

    if (!selector || selector === '#') {
      const hrefAttr = element.getAttribute('href')
      selector = hrefAttr && hrefAttr !== '#' ? hrefAttr.trim() : ''
    }

    try {
      return document.querySelector(selector) ? selector : null
    } catch (err) {
      return null
    }
  },

  getTransitionDurationFromElement(element) {
    if (!element) {
      return 0
    }

    // Get transition-duration of the element
    let transitionDuration = jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).css('transition-duration')
    let transitionDelay = jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).css('transition-delay')

    const floatTransitionDuration = parseFloat(transitionDuration)
    const floatTransitionDelay = parseFloat(transitionDelay)

    // Return 0 if element or transition duration is not found
    if (!floatTransitionDuration && !floatTransitionDelay) {
      return 0
    }

    // If multiple durations are defined, take the first
    transitionDuration = transitionDuration.split(',')[0]
    transitionDelay = transitionDelay.split(',')[0]

    return (parseFloat(transitionDuration) + parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER
  },

  reflow(element) {
    return element.offsetHeight
  },

  triggerTransitionEnd(element) {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(element).trigger(TRANSITION_END)
  },

  // TODO: Remove in v5
  supportsTransitionEnd() {
    return Boolean(TRANSITION_END)
  },

  isElement(obj) {
    return (obj[0] || obj).nodeType
  },

  typeCheckConfig(componentName, config, configTypes) {
    for (const property in configTypes) {
      if (Object.prototype.hasOwnProperty.call(configTypes, property)) {
        const expectedTypes = configTypes[property]
        const value         = config[property]
        const valueType     = value && Util.isElement(value)
          ? 'element' : toType(value)

        if (!new RegExp(expectedTypes).test(valueType)) {
          throw new Error(
            `${componentName.toUpperCase()}: ` +
            `Option "${property}" provided type "${valueType}" ` +
            `but expected type "${expectedTypes}".`)
        }
      }
    }
  },

  findShadowRoot(element) {
    if (!document.documentElement.attachShadow) {
      return null
    }

    // Can find the shadow root otherwise it'll return the document
    if (typeof element.getRootNode === 'function') {
      const root = element.getRootNode()
      return root instanceof ShadowRoot ? root : null
    }

    if (element instanceof ShadowRoot) {
      return element
    }

    // when we don't find a shadow root
    if (!element.parentNode) {
      return null
    }

    return Util.findShadowRoot(element.parentNode)
  }
}

setTransitionEndSupport()

/* harmony default export */ __webpack_exports__["default"] = (Util);


/***/ }),

/***/ "./resources/js/vendor/modal.js":
/*!**************************************!*\
  !*** ./resources/js/vendor/modal.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! bootstrap/js/src/modal */ "./node_modules/bootstrap/js/src/modal.js");

/***/ }),

/***/ 1:
/*!********************************************!*\
  !*** multi ./resources/js/vendor/modal.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! E:\MDC\MDCAdmin\Admin\resources\js\vendor\modal.js */"./resources/js/vendor/modal.js");


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ })

/******/ });