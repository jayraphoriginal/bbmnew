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

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/css-loader/index.js):\nModuleBuildError: Module build failed (from ./node_modules/postcss-loader/src/index.js):\nSyntaxError: 'import' and 'export' may appear only with 'sourceType: module' (4:0)\n    at pp$4.raise (/var/www/bbmnew/node_modules/acorn/dist/acorn.js:2927:15)\n    at pp$1.parseStatement (/var/www/bbmnew/node_modules/acorn/dist/acorn.js:870:18)\n    at _class.parseStatement (/var/www/bbmnew/node_modules/acorn-node/lib/dynamic-import/index.js:65:118)\n    at pp$1.parseTopLevel (/var/www/bbmnew/node_modules/acorn/dist/acorn.js:755:23)\n    at _class.parse (/var/www/bbmnew/node_modules/acorn/dist/acorn.js:555:17)\n    at Function.parse (/var/www/bbmnew/node_modules/acorn/dist/acorn.js:578:37)\n    at Object.parse (/var/www/bbmnew/node_modules/acorn-node/index.js:30:28)\n    at parse (/var/www/bbmnew/node_modules/detective/index.js:22:18)\n    at exports.find (/var/www/bbmnew/node_modules/detective/index.js:47:15)\n    at module.exports (/var/www/bbmnew/node_modules/detective/index.js:26:20)\n    at createModule (/var/www/bbmnew/node_modules/tailwindcss/lib/lib/getModuleDependencies.js:21:43)\n    at getModuleDependencies (/var/www/bbmnew/node_modules/tailwindcss/lib/lib/getModuleDependencies.js:29:22)\n    at /var/www/bbmnew/node_modules/tailwindcss/lib/lib/registerConfigAsDependency.js:20:40\n    at LazyResult.run (/var/www/bbmnew/node_modules/postcss/lib/lazy-result.js:288:14)\n    at LazyResult.asyncTick (/var/www/bbmnew/node_modules/postcss/lib/lazy-result.js:212:26)\n    at /var/www/bbmnew/node_modules/postcss/lib/lazy-result.js:217:17\n    at process.processTicksAndRejections (node:internal/process/task_queues:95:5)\n    at /var/www/bbmnew/node_modules/webpack/lib/NormalModule.js:316:20\n    at /var/www/bbmnew/node_modules/loader-runner/lib/LoaderRunner.js:367:11\n    at /var/www/bbmnew/node_modules/loader-runner/lib/LoaderRunner.js:233:18\n    at context.callback (/var/www/bbmnew/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\n    at /var/www/bbmnew/node_modules/postcss-loader/src/index.js:208:9\n    at process.processTicksAndRejections (node:internal/process/task_queues:95:5)");

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../css/app.css */ "./resources/css/app.css");

/***/ }),

/***/ 0:
/*!***********************************************************!*\
  !*** multi ./resources/js/app.js ./resources/css/app.css ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/bbmnew/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /var/www/bbmnew/resources/css/app.css */"./resources/css/app.css");


/***/ })

/******/ });