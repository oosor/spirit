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


var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ViewBible = function () {
    function ViewBible() {
        _classCallCheck(this, ViewBible);

        this.init();
    }

    _createClass(ViewBible, [{
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

                    if (activePoper || element.closest('#wordModal').length) {
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

                    if (activePoper || element.closest('#wordModal').length) {
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

                var params = element.attr('data').split('/'),
                    cn = element.hasClass('chapter') ? 0 : element.text();
                axios.post('/chapter-greek', {
                    code: element.attr('data'),
                    ot_nt: params[0],
                    book: params[1],
                    chapter: params[2],
                    cn: cn
                }).then(function (response) {

                    var mdata = '',
                        el = response.data;
                    //response.data.forEach((el) => {
                    el.a_1.data.forEach(function (el2, index) {
                        mdata += index == 8 ? '</div>' : '';
                        if (el2.trim() == '') {
                            mdata += index < 9 ? '' : '<br>';
                        } else {
                            mdata += '<div class="word-block">' + '                            <span class="greek-word' + (!isNaN(el2) ? ' digit' + (index < 8 ? ' chapter' : cn != 0 && cn == parseInt(el2, 10) ? ' active' : '') : '') + '" data="' + el.a_3.data[index] + '">' + el2 + '</span>' + '                            <span class="ru-word" data="' + _this.escapeHtml(el.a_4.data[index]) + '">' + el.a_4.data[index] + '</span>' + '                        </div>';
                        }
                    });
                    //});

                    var modal = $('<div class="intro" data="' + el.ot_nt + '.' + el.book + '">' + '                        <div class="title">' + mdata + '                        </div>' + '                      </div>');

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
            }).on('click', '.simphony-ru', function (event) {

                var element = $(event.target);

                if (activePoper) {
                    _this.destroyPopper(activePoper);
                    activePoper = null;
                }

                axios.post('/ru-simphony', {
                    word: element.text()
                }).then(function (response) {

                    var other = '';
                    response.data.word.emptys.forEach(function (el) {
                        other += '<a class="simphony-ru">' + el + '</a>; ';
                    });

                    var links = '';
                    response.data.word.links.forEach(function (el) {
                        var parse = el.split(':');
                        links += '<a class="greek-word digit sim-word" data="' + el + '">' + _this.getShortWord(parse[0]) + ' ' + parse[1] + ';</a> ';
                    });

                    var modal = $('<div class="card detal-word">' + '                  <div class="remove"><i class="fa fa-close"></i></div>' + '                  <blockquote class="card-body">' + '                    <p class="word-bold">' + response.data.word.word + ' (' + response.data.word.cifral + ')</p>' + '                    <small>' + links + '</small>' + '                    <footer>' + '                      <small class="text-muted">см.т. ' + other + '                      </small>' + '                    </footer>' + '                  </blockquote>' + '                </div>');

                    if (element.hasClass('no-modal')) {

                        $('body').append(modal);

                        $('.detal-word').on('click', '.remove', function () {
                            _this.destroyPopper(activePoper);
                            activePoper = null;
                        });

                        activePoper = new Popper(element, modal, {
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
                    } else {
                        _this.setMoodalData(modal, '');
                    }
                });
            }).on('click', 'a.page-link', function (event) {

                var element = $(event.target);
                element = element.hasClass('page-link') ? element : element.parent('.page-link');
                var param = element.attr('href').split('?')[1].split('&').reduce(function (params, param) {
                    var _param$split = param.split('='),
                        _param$split2 = _slicedToArray(_param$split, 2),
                        key = _param$split2[0],
                        value = _param$split2[1];

                    params[key] = value ? decodeURIComponent(value.replace(/\+/g, ' ')) : '';
                    return params;
                }, {});
                param.view = true;
                $('.intro').css({ opacity: '.4' });

                axios.post('/greek-template', param).then(function (response) {
                    $('.intro').css({ opacity: 1 }).attr('data', param.ot_nt + '.' + param.book).html(response.data.chapter);
                    $('.pages').html(response.data.pagination);
                    $('.box-other').html(response.data.links);
                    $('html, body').animate({ scrollTop: $('.intro').offset().top - 85 }, 500);
                    $('#accordion').find('.collapse.show').removeClass('show');
                    $('#accordion').find('li.active').removeClass('active');
                    $('#colapse-' + param.book).addClass('show').find('span').each(function (index, el) {
                        if ($(el).text() == param.chapter) $(el).closest('li.page-item').addClass('active');
                    });

                    try {
                        history.pushState(null, null, element.attr('href'));
                    } catch (e) {}
                });
                return false;
            });
        }
    }, {
        key: 'openRuBook',
        value: function openRuBook(el) {
            var _this2 = this;

            var code = void 0,
                book = void 0,
                ot_nt_book = void 0,
                cn = void 0;

            if (el.hasClass('sim-word')) {
                code = this.setCode(el.attr('data'));
            } else {
                book = el.closest('.intro') /*.length ? el.closest('.intro') : el.closest('.detal-word')*/
                , ot_nt_book = book.attr('data').split('.'), cn = el.hasClass('chapter') ? 0 : el.text();
            }

            axios.post('/ru-bible', el.hasClass('sim-word') ? {
                code: code,
                word: el.text(),
                is: false
            } : {
                ot_nt: ot_nt_book[0],
                book: ot_nt_book[1],
                chapter: book.find('.chapter').text(),
                cn: cn,
                is: true
            }).then(function (response) {

                var box = '';
                response.data.a.data.forEach(function (el, i) {
                    box += '<div ' + (cn != 0 && cn == i + 1 ? 'class="active"' : '') + '>';
                    var arrayWords = el.split(' ');
                    arrayWords.forEach(function (word, index) {
                        if (index == 0) box += word;else if (index == 1) box += ' data="' + (response.data.ot_nt + '/' + response.data.book + '/' + response.data.chapter) + '" ' + word;else if (index == 2) box += ' ' + word;else {
                            box += ' <a class="simphony-ru">' + word + '</a>';
                        }
                    });
                    box += '</div>';
                });

                var modal = $('<div class="card detal-word">' + '                  <div class="remove"><i class="fa fa-close"></i></div>' + '                  <blockquote class="card-body">' + '                    <p class="word-bold chapter greek-chapter ru-bible" data="' + (response.data.ot_nt + '/' + response.data.book + '/' + response.data.chapter) + '">' + response.data.t + '</p>' + '                    <footer>' + '                      <small class="text-muted">' + '                        ' + box + '                      </small>' + '                    </footer>' + '                  </blockquote>' + '                </div>');

                _this2.setMoodalData(modal, '');
            });
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
        key: 'setActive',
        value: function setActive() {}
    }, {
        key: 'getShortWord',
        value: function getShortWord(index) {
            var words = ['Быт', 'Исх', 'Лев', 'Чис', 'Втор', 'Нав', 'Суд', 'Руфь', '1Цар', '2Цар', '3Цар', '4Цар', '1Пар', '2Пар', 'Езд', 'Неем', '2Езд', 'Тов', 'Иудифь', 'Есф', 'Иов', 'Пс', 'Притч', 'Еккл', 'Песн', 'Прем', 'Сир', 'Ис', 'Иер', 'Плач', 'Посл.Иер', 'Вар', 'Иез', 'Дан', 'Ос', 'Иоил', 'Ам', 'Авд', 'Иона', 'Мих', 'Наум', 'Авв', 'Соф', 'Агг', 'Зах', 'Мал', '1Мак', '2Мак', '3Мак', '3Езд', 'Мф', 'Мк', 'Лк', 'Ин', 'Деян', 'Иак', '1Пет', '2Пет', '1Ин', '2Ин', '3Ин', 'Иуд', 'Рим', '1Кф', '2Кф', 'Гал', 'Еф', 'Флп', 'Кол', '1Фес', '2Фес', '1Тим', '2Тим', 'Тит', 'Флм', 'Евр', 'Откр'];
            return words[index - 1];
        }
    }, {
        key: 'setCode',
        value: function setCode(data) {
            var parse = data.split(':');
            return (parse[0].length == 1 ? '0' + parse[0] : parse[0]) + '_' + (parse[1].length == 1 ? '00' + parse[1] : parse[1].length == 2 ? '0' + parse[1] : parse[1]);
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

    return ViewBible;
}();

new ViewBible();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);