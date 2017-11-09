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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Comment = function () {
    function Comment() {
        _classCallCheck(this, Comment);

        this.init();
    }

    _createClass(Comment, [{
        key: 'init',
        value: function init() {
            this.run();
        }
    }, {
        key: 'run',
        value: function run() {
            var _this = this;

            $('body').on('click', '.ru-link', function (event) {

                var element = $(event.target).hasClass('page-link') ? $(event.target) : $(event.target).closest('.page-link');

                _this.animateShow({ is: false });

                axios.post('/comment-book', {
                    code: element.attr('href').split('=')[1]
                }).then(function (response) {

                    var data = {
                        is: true,
                        object: element
                    };
                    _this.animateShow(data);
                    $('.intro').html(response.data.chapter);
                    $('.pages').html(response.data.pagination);
                });

                return false;
            }).on('click', '.tip, .greek-chapter', function (event) {

                var element = $(event.target);

                if (!$(event.target).hasClass('greek-chapter')) element = element.hasClass('tip') ? element : element.closest('.tip');

                axios.post('/comment-data', {
                    code: element.attr('data')
                }).then(function (response) {

                    var modal = $('<div class="card detal-word">' + '                  <div class="remove"><i class="fa fa-close"></i></div>' + '                  <blockquote class="card-body">' + '                    <footer style="border-top:none">' + '                      <small class="text-muted">' + '                        ' + response.data.chapter + '                      </small>' + '                    </footer>' + '                  </blockquote>' + '                </div>');

                    _this.setMoodalData(modal, '');

                    if (element.attr('data').split('.').length > 1) {
                        var data = element.attr('data').split('.')[2].split('-'),
                            _data = [];
                        if (data.length == 1) {
                            _data.push(+data[0]);
                        } else {
                            for (var i = +data[0]; i <= +data[1]; i++) {
                                _data.push(i);
                            }
                        }

                        $('#wordModal').find('.greek-chapter').each(function (i, el) {

                            if (_data.indexOf(+$(el).text()) != -1) {
                                $(el).parent().addClass('active');
                            }
                        });
                    }
                });
            });
        }
    }, {
        key: 'animateShow',
        value: function animateShow(data) {
            if (!data.is) {
                $('.intro').css({ opacity: .4 });
                return true;
            }
            $('.intro').css({ opacity: 1 });
            $('html, body').animate({ scrollTop: $('.intro').offset().top - 85 }, 500);
            $('.updates').find('.collapse.show').removeClass('show').find('.page-item.active').removeClass('active');

            $('.updates').find('#colapse-' + data.object.attr('href').split('=')[1].split('_')[0] + '_').addClass('show');
            data.object.closest('.page-item').addClass('active');

            try {
                history.pushState(null, null, data.object.attr('href'));
            } catch (e) {}
        }
    }, {
        key: 'setMoodalData',
        value: function setMoodalData(poper, header) {
            if (!$('#wordModal').hasClass('show')) $('#wordModal').modal();

            poper.find('.remove').remove();
            $('#wordModal').find('.modal-title').text(header);
            $('#wordModal').find('.modal-body').html(poper);
        }
    }]);

    return Comment;
}();

new Comment();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);