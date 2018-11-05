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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 44);
/******/ })
/************************************************************************/
/******/ ({

/***/ 44:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(45);


/***/ }),

/***/ 45:
/***/ (function(module, exports) {

;(function (window) {
    'use strict';

    // Uploader Constructor

    function Updater() {
        this._init();
    }

    // Updater
    Updater.prototype = {
        _init: function _init() {
            this.el = $('#updateIndicator');
            this.progressBar = $('#updateProgress');
            this.progressMessage = $('#updateMessage');

            this.starturl = this.el.data('starturl');
            this.completeurl = this.el.data('completeurl');

            this._start();
        },
        _start: function _start() {
            this._request(this.starturl);
        },
        _next: function _next(data) {
            this.progressMessage.text(data.message);

            if (data.next) {
                this._request(data.next);
            } else {
                this._complete();
            }
        },
        _request: function _request(requestURL) {
            var self = this;

            $.post(requestURL, function (response) {
                self._setProgress(response.progress);

                self._next(response);
            });
        },
        _setProgress: function _setProgress(percent) {
            this.progressBar.attr('value', percent.toString());
            this.progressBar.text(percent.toString() + "%");
        },
        _complete: function _complete() {
            window.location = this.completeurl;
        }
    };

    // Register updater to the window namespace
    window.Updater = Updater;
})(window);

/***/ })

/******/ });