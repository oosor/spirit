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

//const axios = require('axios');


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ViewGreekRu = function () {
    function ViewGreekRu() {
        _classCallCheck(this, ViewGreekRu);

        this.init();
    }

    _createClass(ViewGreekRu, [{
        key: 'init',
        value: function init() {
            this.clickWord();
        }
    }, {
        key: 'clickWord',
        value: function clickWord() {
            var _this = this;

            var activePoper = void 0,
                apoper2 = void 0;

            $('body').on('click', '.greek-word', function (event) {
                var element = $(event.target);

                if (element.hasClass('digit')) {
                    _this.openRuBook(element);
                    return true;
                }
                if (activePoper && element.hasClass('word')) {
                    _this.destroyPopper(activePoper);
                    activePoper = null;
                }

                axios.post('/word-greek', {
                    code: element.attr('data'),
                    word: element.text()
                }).then(function (response) {

                    var links = '';

                    response.data.word.links.forEach(function (el) {
                        links += '<div>- <a class="ru-word" data="' + _this.escapeHtml(el[0]) + '">' + el[0] + '</a> ';
                        links += '<span>(' + el[1] + ')</span> ';
                        el[2].forEach(function (link) {
                            links += link.nameBook.indexOf('..') != -1 ? '<span>' + link.nameBook + '</span>' : '<a class="greek-chapter" data="' + link.ot_nt_gl + '/' + link.numberBook + '">' + link.nameBook + ' ' + link.numberBook + '</a>; ';
                        });
                        links += '</div>';
                    });

                    var other = '';
                    response.data.word.emptys.forEach(function (el) {
                        other += '<a class="other greek-word" data="' + el.code + '" style="font-family: GrkV">' + el.word + '</a> ';
                    });

                    var poper = $('<div class="card detal-word">' + '                  <div class="remove"><i class="fa fa-close"></i></div>' + '                  <blockquote class="card-body">' + '                    <p class="word-bold" style="font-family: GrkV">' + response.data.word.header.greek + '</p>' + '                    <small class="text-muted">' + links + '</small>' + '                    <footer>' + '                      <small class="text-muted">' + '                        <div><span>сл.ф.:</span> <a class="symphony" data="' + response.data.word.header.otherGreek.code + '" style="font-family: GrkV">' + response.data.word.header.otherGreek.greek + '</a></div>' + '                        ' + (other.length != 0 ? '<div><span>см.т.:</span> ' + other : '') + '                      </small>' + '                    </footer>' + '                  </blockquote>' + '                </div>');

                    if (activePoper) {
                        _this.setMoodalData(poper, '');
                    } else {
                        $('body').append(poper);

                        $('.detal-word').on('click', '.remove', function () {
                            _this.destroyPopper(activePoper);
                            activePoper = null;
                        });

                        activePoper = new Popper(element, poper, {
                            placement: 'bottom',
                            modifiers: {
                                flip: {
                                    behavior: ['left', 'bottom', 'top', 'right']
                                },
                                preventOverflow: {
                                    boundariesElement: 'scrollParent'
                                }
                            }
                        });
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }).on('click', '.ru-word', function (event) {
                var element = $(event.target);
                if (activePoper && element.hasClass('word')) {
                    _this.destroyPopper(activePoper);
                    activePoper = null;
                }

                axios.post('/word-ru', {
                    word: element.attr('data')
                }).then(function (response) {

                    var links = '';

                    var otherGreek = '';
                    response.data.word.links.forEach(function (el) {
                        otherGreek += '<div><a class="other greek-word" data="' + el.code + '" style="font-family: GrkV">' + el.word + '</a></div>';
                    });

                    var other = '';
                    response.data.word.emptys.forEach(function (el) {
                        other += '<a class="other ru-word" data="' + _this.escapeHtml(el) + '">' + el + '</a>; ';
                    });

                    var poper = $('<div class="card detal-word">' + '                  <div class="remove"><i class="fa fa-close"></i></div>' + '                  <blockquote class="card-body">' + '                    <p class="word-bold">' + response.data.word.header + '</p>' + '                    <small class="text-muted">' + otherGreek + '</small>' + '                    <footer>' + '                      <small class="text-muted">' + '                        ' + (other.length != 0 ? '<div><span>см.т.:</span> ' + other : '') + '                      </small>' + '                    </footer>' + '                  </blockquote>' + '                </div>');

                    if (activePoper) {
                        _this.setMoodalData(poper, '');
                    } else {
                        $('body').append(poper);

                        $('.detal-word').on('click', '.remove', function () {
                            _this.destroyPopper(activePoper);
                            activePoper = null;
                        });

                        activePoper = new Popper(element, poper, {
                            placement: 'bottom',
                            modifiers: {
                                flip: {
                                    behavior: ['left', 'bottom', 'top', 'right']
                                },
                                preventOverflow: {
                                    boundariesElement: 'scrollParent'
                                }
                            }
                        });
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }).on('click', '.greek-chapter', function (event) {
                var element = $(event.target);

                var params = element.attr('data').split('/');
                axios.post('/chapter-greek', {
                    code: element.attr('data'),
                    ot_nt: params[0],
                    book: params[1],
                    chapter: params[2]
                }).then(function (response) {

                    var mdata = '';
                    response.data.forEach(function (el) {
                        el.a_1.data.forEach(function (el2, index) {
                            mdata += index == 8 ? '</div>' : '';
                            if (el2.trim() == '') {
                                mdata += index < 9 ? '' : '<br>';
                            } else {
                                mdata += '<div class="word-block">' + '                            <span class="greek-word' + (!isNaN(el2) && index > 8 ? ' digit' : '') + '" data="' + el.a_3.data[index] + '">' + el2 + '</span>' + '                            <span class="ru-word" data="' + _this.escapeHtml(el.a_4.data[index]) + '">' + el.a_4.data[index] + '</span>' + '                        </div>';
                            }
                        });
                    });

                    var modal = $('<div class="intro">' + '                        <div class="title">' + mdata + '                        </div>' + '                      </div>');

                    _this.setMoodalData(modal, '');
                });
            }).on('click', '.symphony', function (event) {
                var element = $(event.target);

                axios.post('/symphony-greek-word', {
                    code: element.attr('data'),
                    word: element.text()
                }).then(function (response) {

                    var other = '';
                    response.data.word.other.forEach(function (el) {
                        other += '<div>';
                        other += '<a class="other greek-word" data="' + el.code + '" style="font-family: GrkV">' + el.word + '</a> ';
                        other += ' <strong>(' + el.count + ')</strong>';
                        el.ruWord.forEach(function (el2, index) {
                            other += (index > 0 ? ',' : '') + ' <span>' + el2.word + ' (' + el2.count + ')</span>';
                        });
                        other += '</div>';
                    });

                    var modal = $('<div class="card detal-word">' + '                  <div class="remove"><i class="fa fa-close"></i></div>' + '                  <blockquote class="card-body">' + '                    <p class="word-bold" style="font-family: GrkV">' + response.data.word.word + '</p>' + '                    <small>' + response.data.word.detal + '</small>' + '                    <footer>' + '                      <small class="text-muted">' + '                        ' + (other.length != 0 ? other : '') + '                      </small>' + '                    </footer>' + '                  </blockquote>' + '                </div>');

                    _this.setMoodalData(modal, '');

                    $('.detal-word').on('click', '.word-abr', function (event2) {

                        if (apoper2) {
                            apoper2.destroy();
                            apoper2 = null;
                            $('.poper-full-click').remove();
                        }
                        var element2 = $(event2.target);

                        axios.post('/abr-word', {
                            word: element2.text()
                        }).then(function (response) {

                            if (!response.data) return true;
                            var poper2 = $('<div class="card poper-full-click" style="z-index:99999">' + '                  <blockquote class="card-body">' + '                      <small class="text-muted"><strong>' + response.data.krosh + '</strong> - ' + response.data.text + '                      </small>' + '                  </blockquote>' + '                </div>');
                            $('body').append(poper2);

                            $('body').on('click', '#wordModal', function () {
                                if (apoper2) {
                                    apoper2.destroy();
                                    apoper2 = null;
                                }
                                $('.poper-full-click').remove();
                                $('body').off('click', '#wordModal');
                            });

                            apoper2 = new Popper(element2, poper2, {
                                placement: 'bottom',
                                modifiers: {
                                    flip: {
                                        behavior: ['left', 'bottom', 'top', 'right']
                                    }
                                }
                            });
                        });
                    });
                });
            });
        }
    }, {
        key: 'openRuBook',
        value: function openRuBook(el) {

            var book = el.closest('.intro'),
                ot_nt_book = book.attr('data').split('.');

            axios.post('/ru-bible', {
                ot_nt: ot_nt_book[0],
                book: ot_nt_book[1],
                chapter: book.find('.chapter').text(),
                cn: el.hasClass('chapter') ? 0 : el.text()
            }).then(function (response) {});
        }
    }, {
        key: 'destroyPopper',
        value: function destroyPopper(poper) {
            poper.destroy();
            $('.detal-word').remove();
        }
    }, {
        key: 'setMoodalData',
        value: function setMoodalData(poper, header) {
            if (!$('#wordModal').hasClass('show')) $('#wordModal').modal();

            poper.find('.remove').remove();
            $('#wordModal').find('.modal-title').text(header);
            $('#wordModal').find('.modal-body').html(poper);
        }
    }, {
        key: 'escapeHtml',
        value: function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return text.replace(/[&<>"']/g, function (m) {
                return map[m];
            });
        }
    }]);

    return ViewGreekRu;
}();

new ViewGreekRu();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);