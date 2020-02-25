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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./dev-assets/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./dev-assets/js/main.js":
/*!*******************************!*\
  !*** ./dev-assets/js/main.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(/*! ./starter */ "./dev-assets/js/starter.js");

+function ($) {
  function searchToggler() {
    $("#search-toggler").on('click', function (event) {
      event.preventDefault();
      $(".top-search-form").slideToggle();
      $('.top-search-form .search-field').focus();
    });
  }

  function scrollToTop() {
    jQuery('.scroll-top').click(function () {
      jQuery('body,html').animate({
        scrollTop: 0
      }, 500);
    });
  }

  var documentReadyCallbackFunc = function documentReadyCallbackFunc() {
    searchToggler();
    scrollToTop();
  };
  /* DOM ready event */


  $(document).ready(documentReadyCallbackFunc);
  $(window).scroll(function () {
    if ($(this).scrollTop() >= 500) {
      $('.scroll-top').fadeIn(200);
    } else {
      $('.scroll-top').fadeOut(200);
    }
  });
  $(window).load(function () {
    $("#loader-wrapper").fadeOut();
    $("#loaded").delay(1000).fadeOut("slow");
  });
}(jQuery);

/***/ }),

/***/ "./dev-assets/js/mobile-menu.js":
/*!**************************************!*\
  !*** ./dev-assets/js/mobile-menu.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// shiftMenu
+function ($) {
  var classToggler = function classToggler(param) {
    this.animation = param.animation, this.toggler = param.toggler, this.className = param.className, this.exceptions = param.exceptions;

    this.init = function () {
      var that = this; // for stop propagation

      var stopToggler = this.implode(this.exceptions);

      if (typeof stopToggler !== 'undefined') {
        $(document).on('click', stopToggler, function (e) {
          e.stopPropagation();
        });
      } // for toggle class


      var toggler = this.implode(this.toggler);

      if (typeof toggler !== 'undefined') {
        $(document).on('click', toggler, function (e) {
          e.stopPropagation();
          e.preventDefault();
          that.toggle();
        });
      }
    }; //class toggler


    this.toggle = function () {
      var selectors = this.implode(this.animation);

      if (typeof selectors !== 'undefined') {
        $(selectors).toggleClass(this.className);
      }
    }; // array selector maker


    this.implode = function (arr, imploder) {
      // checking arg is array or not
      if (!(arr instanceof Array)) {
        return arr;
      } // setting default imploder


      if (typeof imploder == 'undefined') {
        imploder = ',';
      } // making selector


      var data = arr;
      var ele = '';

      for (var j = 0; j < arr.length; j++) {
        ele += arr[j];

        if (j !== arr.length - 1) {
          ele += imploder;
        }
      }

      data = ele;
      return data;
    };
  }; //End mobileMenu


  $.fn.mrMobileMenu = function (config) {
    /* defining default config*/
    var defaultConfig = {
      icon: '#menu-icon',
      closeIcon: true,
      overlay: true
    };
    $.extend(defaultConfig, config);

    if (!$(this.selector).length) {
      console.error('Selected Element not found in DOM (Mobile menu plugin)');
      return this;
    }

    var _this = this;

    var shiftMenu = function shiftMenu() {
      var mobileMenuHTML = $(_this.selector).html(),
          that = this;
      /* constructor function */

      this.init = function () {
        $(document).ready(function () {
          that.createMenu();
          that.addDownArrow();
          that.toggleSubUl();
          that.menuToggler();
          that.addClassOnFirstUl();
        });
      };

      this.createMenu = function () {
        var closeHTML = defaultConfig.closeIcon ? this.closeMenuIcon() : null,
            overlayHTML = defaultConfig.overlay ? this.addOverlay() : null;
        $('body').append('<div class="mr-mobile-menu" id="mr-mobile-menu">' + closeHTML + mobileMenuHTML + '</div>' + overlayHTML);
      };

      this.closeMenuIcon = function () {
        return '<div class="mr-close-wrapper"> <span class="mr-inner-box" id="mr-close"><span class="mr-inner"></span></span> </div>';
      };

      this.addOverlay = function () {
        return '<div class="mr-mobile-menu-overlay"></div>';
      };

      this.addClassOnFirstUl = function () {
        if ($('#mr-mobile-menu ul').first().hasClass('menu')) {} else {
          $('#mr-mobile-menu ul').first().addClass('menu');
        }
      };

      this.addDownArrow = function () {
        var $mobileMenu = $('#mr-mobile-menu'),
            $hasSubUl = $('#mr-mobile-menu .menu-item-has-children'),
            haveClassOnLi = $mobileMenu.find('.menu-item-has-children');

        if (haveClassOnLi.length > 0) {
          $hasSubUl.children('a').append('<span class="mr-arrow-box"><span class="mr-down-arrow"></span></span>');
        } else {
          $('#mr-mobile-menu ul li:has(ul)').children('a').append('<span class="mr-arrow-box"><span class="mr-down-arrow"></span></span>');
        }
      };

      this.toggleSubUl = function () {
        $(document).on('click', '.mr-arrow-box', toggleSubMenu);

        function toggleSubMenu(e) {
          e.stopPropagation();
          e.preventDefault();
          $(this).toggleClass('open').parent().next().slideToggle();
        }
      };

      this.menuToggler = function () {
        var menuConfig = {
          animation: ['.mr-mobile-menu-overlay', '#mr-mobile-menu', 'body', '#menu-icon'],
          //where class add element
          exceptions: ['#mr-mobile-menu'],
          //stop propagation
          toggler: ['#menu-icon', '.mr-mobile-menu-overlay', '#mr-close'],
          //class toggle on click
          className: 'mr-menu-open'
        };
        new classToggler(menuConfig).init();
      };
    };
    /* End shiftMenu */

    /* instance of shiftmenu */


    new shiftMenu().init();
  };
  /* End shiftMenu */

}(jQuery);

/***/ }),

/***/ "./dev-assets/js/skip-link-focus-fix.js":
/*!**********************************************!*\
  !*** ./dev-assets/js/skip-link-focus-fix.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function () {
  var isIe = /(trident|msie)/i.test(navigator.userAgent);

  if (isIe && document.getElementById && window.addEventListener) {
    window.addEventListener('hashchange', function () {
      var id = location.hash.substring(1),
          element;

      if (!/^[A-z0-9_-]+$/.test(id)) {
        return;
      }

      element = document.getElementById(id);

      if (element) {
        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
          element.tabIndex = -1;
        }

        element.focus();
      }
    }, false);
  }
})();

/***/ }),

/***/ "./dev-assets/js/starter.js":
/*!**********************************!*\
  !*** ./dev-assets/js/starter.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(/*! ./mobile-menu */ "./dev-assets/js/mobile-menu.js");

__webpack_require__(/*! ./skip-link-focus-fix.js */ "./dev-assets/js/skip-link-focus-fix.js");

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

+function ($) {
  var Starter =
  /*#__PURE__*/
  function () {
    function Starter() {
      _classCallCheck(this, Starter);

      this.$body = $('body');
      this.toggleSearchWithOverlay();
      this.mobileMenuInit();
      this.triggerEventEscButtonPress();
      this.closeMobileMenuOnEscKeyPress();
    }

    _createClass(Starter, [{
      key: "mobileMenuInit",
      value: function mobileMenuInit() {
        var $mrMenu = $('#site-navigation');
        $mrMenu.length && $mrMenu.mrMobileMenu();
      }
    }, {
      key: "triggerEventEscButtonPress",
      value: function triggerEventEscButtonPress() {
        document.addEventListener('keydown', function (e) {
          e = e || window.event;

          if (e.keyCode == 27) {
            /* Creating custom event */
            var event = new Event('onEscKeypressed');
            document.dispatchEvent(event);
          }
        });
      }
    }, {
      key: "closeMobileMenuOnEscKeyPress",
      value: function closeMobileMenuOnEscKeyPress() {
        var _this = this;

        document.addEventListener('onEscKeypressed', function () {
          return _this.$body.hasClass('mr-menu-open') && document.getElementById('menu-icon').click();
        });
      }
    }, {
      key: "toggleSearchWithOverlay",
      value: function toggleSearchWithOverlay() {
        var _this2 = this;

        var $searchToggler = $('.gutenbiz-toggle-search');
        var className = 'gutenbiz-search-opened';
        var $searchInput = $('.gutenbiz-header-search .search-field');
        /* Overlay */

        var overlayClassName = 'gutenbiz-search-overlay';
        var overlayHtml = "<div class=\"".concat(overlayClassName, "\"></div>");
        var delayAmountToFocusInput = 300;

        var toggleSearech = function toggleSearech() {
          _this2.$body.toggleClass(className);

          if (_this2.$body.hasClass(className)) {
            setTimeout(function () {
              var searchInputValue = $searchInput.val();
              $searchInput.val('');
              $searchInput.focus().val(searchInputValue);
            }, delayAmountToFocusInput);

            _this2.$body.prepend(overlayHtml);
          } else $(document).find(".".concat(overlayClassName)).remove();
        };

        $searchToggler.length && $searchToggler.on('click', function () {
          toggleSearech();
        });
        /* Close if Esc key pressed */

        document.addEventListener('onEscKeypressed', function () {
          return $(_this2.$body).hasClass(className) && toggleSearech();
        });
      }
    }]);

    return Starter;
  }();

  $(document).ready(function () {
    new Starter();
  });
}(jQuery);

/***/ })

/******/ });
//# sourceMappingURL=main.js.map