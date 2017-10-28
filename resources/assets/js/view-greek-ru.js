'use strict';
//const axios = require('axios');


class ViewGreekRu {

    constructor() {
        this.init();
    }

    init() {
        this.clickWord();
    }

    clickWord() {

        let activePoper, apoper2;

        $('body').on('click', '.greek-word', (event) => {
            let element = $(event.target);

            if(element.hasClass('digit')) {
                this.openRuBook(element);
                return true;
            }
            if(activePoper && element.hasClass('word')) {
                this.destroyPopper(activePoper);
                activePoper = null;
            }

            axios.post('/word-greek', {
                code: element.attr('data'),
                word: element.text()
            }).then(response => {

                let links = '';

                response.data.word.links.forEach((el) => {
                    links += '<div>- <a class="ru-word" data="' + this.escapeHtml(el[0]) + '">' + el[0] + '</a> ';
                    links += '<span>(' + el[1] + ')</span> ';
                    el[2].forEach((link) => {
                        links += (link.nameBook.indexOf('..') != -1) ? ('<span>' + link.nameBook + '</span>') : ('<a class="greek-chapter" data="' + link.ot_nt_gl + '/' + link.numberBook +'">' + link.nameBook + ' ' + link.numberBook + '</a>; ');
                    });
                    links += '</div>';
                });

                let other = '';
                response.data.word.emptys.forEach(el => {
                    other += '<a class="other greek-word" data="' + el.code + '" style="font-family: GrkV">' + el.word + '</a> ';
                });

                let poper = $('<div class="card detal-word">' +
                    '                  <div class="remove"><i class="fa fa-close"></i></div>' +
                    '                  <blockquote class="card-body">' +
                    '                    <p class="word-bold" style="font-family: GrkV">' + response.data.word.header.greek + '</p>' +
                    '                    <small class="text-muted">' + links + '</small>' +
                    '                    <footer>' +
                    '                      <small class="text-muted">' +
                    '                        <div><span>сл.ф.:</span> <a class="symphony" data="' + response.data.word.header.otherGreek.code + '" style="font-family: GrkV">' + response.data.word.header.otherGreek.greek + '</a></div>' +
                    '                        ' + ((other.length != 0) ? ('<div><span>см.т.:</span> ' + other) : '') +
                    '                      </small>' +
                    '                    </footer>' +
                    '                  </blockquote>' +
                    '                </div>');

                if(activePoper || element.closest('#wordModal').length) {
                    this.setMoodalData(poper, '');
                }
                else {
                    $('body').append(poper);

                    $('.detal-word').on('click', '.remove', () => {
                        this.destroyPopper(activePoper);
                        activePoper = null;
                    });

                    activePoper = new Popper(
                        element, poper, {
                            placement: 'bottom',
                            modifiers: {
                                flip: {
                                    behavior: ['left', 'bottom', 'top', 'right']
                                },
                                preventOverflow: {
                                    boundariesElement: 'scrollParent',
                                },
                            },
                        }
                    );
                }

            }).catch(error => { console.log(error) });
        }).on('click', '.ru-word', (event) => {
            let element = $(event.target);
            if(activePoper && element.hasClass('word')) {
                this.destroyPopper(activePoper);
                activePoper = null;
            }

            axios.post('/word-ru', {
                word: element.attr('data')
            }).then(response => {

                let links = '';

                let otherGreek = '';
                response.data.word.links.forEach(el => {
                    otherGreek += '<div><a class="other greek-word" data="' + el.code + '" style="font-family: GrkV">' + el.word + '</a></div>';
                });

                let other = '';
                response.data.word.emptys.forEach(el => {
                    other += '<a class="other ru-word" data="' + this.escapeHtml(el) + '">' + el + '</a>; ';
                });

                let poper = $('<div class="card detal-word">' +
                    '                  <div class="remove"><i class="fa fa-close"></i></div>' +
                    '                  <blockquote class="card-body">' +
                    '                    <p class="word-bold">' + response.data.word.header + '</p>' +
                    '                    <small class="text-muted">' + otherGreek + '</small>' +
                    '                    <footer>' +
                    '                      <small class="text-muted">' +
                    '                        ' + ((other.length != 0) ? ('<div><span>см.т.:</span> ' + other) : '') +
                    '                      </small>' +
                    '                    </footer>' +
                    '                  </blockquote>' +
                    '                </div>');

                if(activePoper || element.closest('#wordModal').length) {
                    this.setMoodalData(poper, '');
                }
                else {
                    $('body').append(poper);

                    $('.detal-word').on('click', '.remove', () => {
                        this.destroyPopper(activePoper);
                        activePoper = null;
                    });

                    activePoper = new Popper(
                        element, poper, {
                            placement: 'bottom',
                            modifiers: {
                                flip: {
                                    behavior: ['left', 'bottom', 'top', 'right']
                                },
                                preventOverflow: {
                                    boundariesElement: 'scrollParent',
                                },
                            },
                        }
                    );
                }

            }).catch(error => { console.log(error) });
        }).on('click', '.greek-chapter', (event) => {
            let element = $(event.target);

            let params = element.attr('data').split('/'),
                cn = element.hasClass('chapter') ? 0 : element.text();
            axios.post('/chapter-greek', {
                code: element.attr('data'),
                ot_nt: params[0],
                book: params[1],
                chapter: params[2],
                cn: cn
            }).then(response => {

                let mdata = '';
                response.data.forEach((el) => {
                    el.a_1.data.forEach((el2, index) => {
                        mdata += (index == 8) ? '</div>' : '';
                        if(el2.trim() == '') {
                            mdata += (index < 9) ? '' : '<br>';
                        }
                        else {
                            mdata += '<div class="word-block">' +
            '                            <span class="greek-word' + ((!isNaN(el2)) ? (' digit' + (index < 8 ? ' chapter' : (cn != 0 && cn == parseInt(el2, 10)) ? ' active' : '')) : '') + '" data="' + el.a_3.data[index] + '">' + el2 + '</span>' +
            '                            <span class="ru-word" data="' + this.escapeHtml(el.a_4.data[index]) + '">' + el.a_4.data[index] + '</span>' +
            '                        </div>';
                        }
                    });
                });

                let modal = $('<div class="intro" data="' + response.data[0].ot_nt + '.' + response.data[0].book + '">' +
        '                        <div class="title">' + mdata +
        '                        </div>' +
        '                      </div>');

                this.setMoodalData(modal, '');
            });
        }).on('click', '.symphony', (event) => {
            let element = $(event.target);

            axios.post('/symphony-greek-word', {
                code: element.attr('data'),
                word: element.text()
            }).then(response => {

                let other = '';
                response.data.word.other.forEach(el => {
                    other += '<div>';
                    other += '<a class="other greek-word" data="' + el.code + '" style="font-family: GrkV">' + el.word + '</a> ';
                    other += ' <strong>(' + el.count + ')</strong>';
                    el.ruWord.forEach((el2, index) => {
                        other += (((index > 0) ? ',' : '') + ' <span>' + el2.word + ' (' + el2.count + ')</span>');
                    });
                    other += '</div>';
                });

                let modal = $('<div class="card detal-word">' +
                    '                  <div class="remove"><i class="fa fa-close"></i></div>' +
                    '                  <blockquote class="card-body">' +
                    '                    <p class="word-bold" style="font-family: GrkV">' + response.data.word.word + '</p>' +
                    '                    <small>' + response.data.word.detal + '</small>' +
                    '                    <footer>' +
                    '                      <small class="text-muted">' +
                    '                        ' + ((other.length != 0) ? other : '') +
                    '                      </small>' +
                    '                    </footer>' +
                    '                  </blockquote>' +
                    '                </div>');


                this.setMoodalData(modal, '');

                $('.detal-word').on('click', '.word-abr', (event2) => {

                    if(apoper2) {
                        apoper2.destroy();
                        apoper2 = null;
                        $('.poper-full-click').remove();
                    }
                    let element2 = $(event2.target);

                    axios.post('/abr-word', {
                        word: element2.text()
                    }).then(response => {

                        if(!response.data) return true;
                        let poper2 = $('<div class="card poper-full-click" style="z-index:99999">' +
                            '                  <blockquote class="card-body">' +
                            '                      <small class="text-muted"><strong>' + response.data.krosh + '</strong> - ' + response.data.text +
                            '                      </small>' +
                            '                  </blockquote>' +
                            '                </div>');
                        $('body').append(poper2);

                        $('body').on('click', '#wordModal', () => {
                            if(apoper2) {
                                apoper2.destroy();
                                apoper2 = null;
                            }
                            $('.poper-full-click').remove();
                            $('body').off('click', '#wordModal');
                        });

                        apoper2 = new Popper(
                            element2, poper2, {
                                placement: 'bottom',
                                modifiers: {
                                    flip: {
                                        behavior: ['left', 'bottom', 'top', 'right']
                                    }
                                },
                            }
                        )
                    });

                })
            });
        }).on('click', '.simphony-ru', event => {

            let element = $(event.target);

            axios.post('/ru-simphony', {
                word: element.text()
            }).then(response => {

                let other = '';
                response.data.word.emptys.forEach(el => {
                    other += '<a class="simphony-ru">' + el + '</a>; ';
                });

                let links = '';
                response.data.word.links.forEach(el => {
                    let parse = el.split(':');
                    links += '<a class="greek-word digit sim-word" data="' + el + '">' + this.getShortWord(parse[0]) + ' ' + parse[1] + ';</a> ';
                });

                let modal = $('<div class="card detal-word">' +
                    '                  <div class="remove"><i class="fa fa-close"></i></div>' +
                    '                  <blockquote class="card-body">' +
                    '                    <p class="word-bold">' + response.data.word.word + ' (' + response.data.word.cifral + ')</p>' +
                    '                    <small>' + links + '</small>' +
                    '                    <footer>' +
                    '                      <small class="text-muted">см.т. ' + other +
                    '                      </small>' +
                    '                    </footer>' +
                    '                  </blockquote>' +
                    '                </div>');


                this.setMoodalData(modal, '');

            });
        });

    }


    openRuBook(el) {

        let code, book, ot_nt_book, cn;

        if(el.hasClass('sim-word')) {
            code = this.setCode(el.attr('data'));
        }
        else {
            book = el.closest('.intro')/*.length ? el.closest('.intro') : el.closest('.detal-word')*/,
            ot_nt_book = book.attr('data').split('.'),
            cn = el.hasClass('chapter') ? 0 : el.text();
        }

        axios.post('/ru-bible', (el.hasClass('sim-word') ? {
            code: code,
            word: el.text(),
            is: false
        } : {
            ot_nt: ot_nt_book[0],
            book: ot_nt_book[1],
            chapter: book.find('.chapter').text(),
            cn: cn,
            is: true
        })).then(response => {

            let box = '';
            response.data.a.data.forEach((el, i) => {
                box += '<div ' + ((cn != 0 && cn == i+1) ? 'class="active"' : '') + '>';
                let arrayWords = el.split(' ');
                arrayWords.forEach((word, index) => {
                    if(index == 0) box += word;
                    else if(index == 1) box += ' data="' + (response.data.ot_nt + '/' + response.data.book + '/' +response.data.chapter) + '" ' + word;
                    else if(index == 2) box += ' ' + word;
                    else {
                        box += ' <a class="simphony-ru">' + word + '</a>';
                    }
                })
                box += '</div>';
            });

            let modal = $('<div class="card detal-word">' +
                '                  <div class="remove"><i class="fa fa-close"></i></div>' +
                '                  <blockquote class="card-body">' +
                '                    <p class="word-bold chapter greek-chapter ru-bible" data="' + (response.data.ot_nt + '/' + response.data.book + '/' +response.data.chapter) + '">' + response.data.t + '</p>' +
                '                    <footer>' +
                '                      <small class="text-muted">' +
                '                        ' + box +
                '                      </small>' +
                '                    </footer>' +
                '                  </blockquote>' +
                '                </div>');


            this.setMoodalData(modal, '');

        });
    }



    destroyPopper(poper) {
        poper.destroy();
        $('.detal-word').remove();
    }

    setMoodalData(poper, header) {
        if(!$('#wordModal').hasClass('show'))
            $('#wordModal').modal();

        poper.find('.remove').remove();
        $('#wordModal').find('.modal-title').text(header);
        $('#wordModal').find('.modal-body').html(poper);
    }

    getShortWord(index) {
        let words = [
            'Быт', 'Исх', 'Лев', 'Чис','Втор', 'Нав', 'Суд','Руфь', '1Цар','2Цар', '3Цар','4Цар',
            '1Пар','2Пар', 'Езд','Неем', '2Езд','Тов', 'Иудифь','Есф', 'Иов','Пс', 'Притч',
            'Еккл', 'Песн', 'Прем','Сир', 'Ис','Иер', 'Плач','Посл.Иер',
            'Вар','Иез', 'Дан','Ос', 'Иоил','Ам', 'Авд','Иона', 'Мих','Наум', 'Авв',
            'Соф', 'Агг','Зах', 'Мал', '1Мак', '2Мак', '3Мак', '3Езд',
            'Мф', 'Мк','Лк', 'Ин','Деян', 'Иак','1Пет', '2Пет',
            '1Ин', '2Ин','3Ин', 'Иуд','Рим', '1Кф','2Кф', 'Гал','Еф', 'Флп',
            'Кол', '1Фес','2Фес', '1Тим','2Тим', 'Тит','Флм', 'Евр','Откр'
        ];
        return words[index-1];
    }

    setCode(data) {
        let parse = data.split(':');
        return (parse[0].length == 1 ? ('0' + parse[0]) : parse[0]) + '_'
            + (parse[1].length == 1 ? ('00' + parse[1]) : (parse[1].length == 2 ? ('0' + parse[1]) : parse[1]));
    }

    escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, m => map[m]);
    }

}
new ViewGreekRu();