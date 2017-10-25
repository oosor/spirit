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

                if(activePoper) {
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

                if(activePoper) {
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

            let params = element.attr('data').split('/');
            axios.post('/chapter-greek', {
                code: element.attr('data'),
                ot_nt: params[0],
                book: params[1],
                chapter: params[2]
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
            '                            <span class="greek-word' + ((!isNaN(el2) && index > 8) ? ' digit' : '') + '" data="' + el.a_3.data[index] + '">' + el2 + '</span>' +
            '                            <span class="ru-word" data="' + this.escapeHtml(el.a_4.data[index]) + '">' + el.a_4.data[index] + '</span>' +
            '                        </div>';
                        }
                    });
                });

                let modal = $('<div class="intro">' +
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
        });

    }


    openRuBook(el) {

        let book = el.closest('.intro'),
            ot_nt_book = book.attr('data').split('.');

        axios.post('/ru-bible', {
            ot_nt: ot_nt_book[0],
            book: ot_nt_book[1],
            chapter: book.find('.chapter').text(),
            cn: el.hasClass('chapter') ? 0 : el.text()
        }).then(response => {

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