/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/shortcode/blockIcon.js":
/*!************************************!*\
  !*** ./src/shortcode/blockIcon.js ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_escape_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/escape-html */ "@wordpress/escape-html");
/* harmony import */ var _wordpress_escape_html__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_0__);
const el = wp.element.createElement;

const icons = {};
icons.sprtfIcon = el('img', {
  src: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_0__.escapeAttribute)(sp_testimonial_free.url + 'Admin/GutenbergBlock/assets/real-testimonials-logo.svg')
});
/* harmony default export */ __webpack_exports__["default"] = (icons);

/***/ }),

/***/ "./src/shortcode/dynamicShortcode.js":
/*!*******************************************!*\
  !*** ./src/shortcode/dynamicShortcode.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/escape-html */ "@wordpress/escape-html");
/* harmony import */ var _wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__);


/**
 * Shortcode select component.
 */

const {
  __
} = wp.i18n;
const {
  Fragment
} = wp.element;
const el = wp.element.createElement;

const DynamicShortcodeInput = _ref => {
  let {
    attributes: {
      shortcode
    },
    shortCodeList,
    shortcodeUpdate
  } = _ref;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, el('div', {
    className: 'sprtf-gutenberg-shortcode editor-styles-wrapper'
  }, el('select', {
    className: 'sprtf-shortcode-selector',
    onChange: e => shortcodeUpdate(e),
    value: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__.escapeAttribute)(shortcode)
  }, el('option', {
    value: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__.escapeAttribute)('0')
  }, (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__.escapeHTML)(__('-- Select a view (shortcode) --', 'testimonial-pro'))), shortCodeList.map(shortcode => {
    var title = shortcode.title.length > 30 ? shortcode.title.substring(0, 25) + '.... #(' + shortcode.id + ')' : shortcode.title + ' #(' + shortcode.id + ')';
    return el('option', {
      value: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__.escapeAttribute)(shortcode.id.toString()),
      key: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__.escapeAttribute)(shortcode.id.toString())
    }, (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_1__.escapeHTML)(title));
  }))));
};

/* harmony default export */ __webpack_exports__["default"] = (DynamicShortcodeInput);

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/escape-html":
/*!************************************!*\
  !*** external ["wp","escapeHtml"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["escapeHtml"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _shortcode_blockIcon__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./shortcode/blockIcon */ "./src/shortcode/blockIcon.js");
/* harmony import */ var _shortcode_dynamicShortcode__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./shortcode/dynamicShortcode */ "./src/shortcode/dynamicShortcode.js");
/* harmony import */ var _wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/escape-html */ "@wordpress/escape-html");
/* harmony import */ var _wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);





const {
  __
} = wp.i18n;
const {
  registerBlockType
} = wp.blocks;
const {
  PanelBody,
  PanelRow
} = wp.components;
const {
  Fragment
} = wp.element;
const ServerSideRender = wp.serverSideRender;
const el = wp.element.createElement;
/**
 * Register: aa Gutenberg Block.
 */

registerBlockType("sp-testimonial-free/shortcode", {
  title: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("Real Testimonials", "testimonial-free")),
  description: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("Use Real Testimonials to insert a view shortcode (testimonials) in your page", "testimonial-free")),
  icon: _shortcode_blockIcon__WEBPACK_IMPORTED_MODULE_1__["default"].sprtfIcon,
  category: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)("common"),
  supports: {
    html: true
  },
  edit: props => {
    const {
      attributes,
      setAttributes
    } = props;
    var shortCodeList = sp_testimonial_free.shortCodeList;

    let scriptLoad = shortcodeId => {
      let sprtfBlockLoaded = false;
      let sprtfBlockLoadedInterval = setInterval(function () {
        let uniqId = jQuery("#sp-testimonial-free-wrapper-" + shortcodeId).parents().attr("id");

        if (document.getElementById(uniqId)) {
          jQuery.getScript(sp_testimonial_free.loadScript);
          jQuery('#sp-testimonial-preloader-' + shortcodeId).css({
            'opacity': 0,
            'display': 'none'
          });
          jQuery('#sp-testimonial-free-' + shortcodeId).animate({
            opacity: 1
          }, 600);
          sprtfBlockLoaded = true;
          uniqId = "";
        }

        if (sprtfBlockLoaded) {
          clearInterval(sprtfBlockLoadedInterval);
        }

        if (0 == shortcodeId) {
          clearInterval(sprtfBlockLoadedInterval);
        }
      }, 10);
    };

    let updateShortcode = updateShortcode => {
      setAttributes({
        shortcode: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(updateShortcode.target.value)
      });
    };

    let shortcodeUpdate = e => {
      updateShortcode(e);
      let shortcodeId = (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(e.target.value);
      scriptLoad(shortcodeId);
    };

    document.addEventListener("readystatechange", event => {
      if (event.target.readyState === "complete") {
        let shortcodeId = (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(attributes.shortcode);
        scriptLoad(shortcodeId);
      }
    });

    if (attributes.preview) {
      return el('div', {
        className: 'sprtf_shortcode_block_preview_image'
      }, el('img', {
        src: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(sp_testimonial_free.url + "Admin/GutenbergBlock/assets/rt-block-preview.svg")
      }));
    }

    if (shortCodeList.length === 0) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, el("div", {
        className: "components-placeholder components-placeholder is-large sprtf_block_shortcode"
      }, el("div", {
        className: "components-placeholder__label"
      }, el("img", {
        className: 'block-editor-block-icon',
        src: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(sp_testimonial_free.url + 'Admin/GutenbergBlock/assets/real-testimonials-logo.svg')
      }), el("h4", {}, (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("Real Testimonials", "testimonial-free")))), el("div", {
        className: "sprtf_block_shortcode_text"
      }, (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("No view shortcode found. ", "testimonial-free")), el("a", {
        href: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(sp_testimonial_free.link)
      }, (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("Create a view now!", "testimonial-free"))))));
    }

    if (!attributes.shortcode || attributes.shortcode == 0) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
        title: "Select a view (shortcode)"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_shortcode_dynamicShortcode__WEBPACK_IMPORTED_MODULE_2__["default"], {
        attributes: attributes,
        shortCodeList: shortCodeList,
        shortcodeUpdate: shortcodeUpdate
      })))), el('div', {
        className: 'components-placeholder components-placeholder is-large sprtf_block_shortcode'
      }, el('div', {
        className: 'components-placeholder__label'
      }, el('img', {
        className: 'block-editor-block-icon',
        src: (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeAttribute)(sp_testimonial_free.url + 'Admin/GutenbergBlock/assets/real-testimonials-logo.svg')
      }), (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("Real Testimonial", "testimonial-free"))), el('div', {
        className: 'components-placeholder__instructions'
      }, (0,_wordpress_escape_html__WEBPACK_IMPORTED_MODULE_3__.escapeHTML)(__("Select a view (shortcode)", "testimonial-free"))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_shortcode_dynamicShortcode__WEBPACK_IMPORTED_MODULE_2__["default"], {
        attributes: attributes,
        shortCodeList: shortCodeList,
        shortcodeUpdate: shortcodeUpdate
      })));
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
      title: "Real Testimonials Block Settings"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_shortcode_dynamicShortcode__WEBPACK_IMPORTED_MODULE_2__["default"], {
      attributes: attributes,
      shortCodeList: shortCodeList,
      shortcodeUpdate: shortcodeUpdate
    })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ServerSideRender, {
      block: "sp-testimonial-free/shortcode",
      attributes: attributes
    }));
  },

  save() {
    // Rendering in PHP
    return null;
  }

});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map