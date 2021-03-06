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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

// require('./bootstrap');
$('#name-field').dblclick(function () {
  var attr = $(this).attr('profile'); // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.

  if (!(_typeof(attr) !== ( true ? "undefined" : undefined) && attr !== false)) {
    return;
  }

  var elem = $(this).find('p');

  if (elem != undefined) {
    var parent = $(elem).parent();
    var text = elem.text();
    $(elem).remove();
    $(parent).append('<input class="form-control" type="text" name="name" id="nameInputs" required value="' + text + '">');
    $('#nameInputs').focus().attr('placeholder', 'username');
  } else {
    var elem = $(this).find('#nameInputs');
    var text = elem.val();
    $(elem).remove();
    $(parent).append('<p>' + text + '</p>');
  }
});
$('#email-field').dblclick(function () {
  var attr = $(this).attr('profile'); // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.

  if (!(_typeof(attr) !== ( true ? "undefined" : undefined) && attr !== false)) {
    return;
  }

  var elem = $(this).find('p');

  if (elem != undefined) {
    var parent = $(elem).parent();
    var text = elem.text();
    $(elem).remove();
    $(parent).append('<input class="form-control" type="email" name="email" id="emailInputs" required value="' + text + '">');
    $('#emailInputs').focus().attr('placeholder', 'email');
  } else {
    var elem = $(this).find('#emailInputs');
    var text = elem.val();
    $(elem).remove();
    $(parent).append('<p>' + text + '</p>');
  }
});
$('#password-field').dblclick(function () {
  var elem = $(this).find('p');

  if (elem != undefined) {
    var parent = $(elem).parent();
    $(elem).remove();
    $(parent).append("<div class='pop-up change-password'><input class='form-control' type='password' name='password' placeholder='password' required><input class='form-control' type='password' name='password_confirmation' placeholder='password confirmation' required></div>");
  } else {
    var elem = $(this).find('.change-password')[0];
    $(elem).children().each(function (item) {
      item.remove();
    });
    $(parent).append('<p>Click to the field for change password</p>');
  }
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/user/website/blog/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/user/website/blog/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });