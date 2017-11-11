'use strict';

class Comment {

    constructor() {
        this.init();
    }

    init() {
        this.run();
    }

    run() {

        $('body').on('click', '.ru-link', event => {

            let element = $(event.target).hasClass('page-link') ? $(event.target) : $(event.target).closest('.page-link');

            this.animateShow({is: false});

            axios.post('/comment-book', {
                code: element.attr('href').split('=')[1]
            }).then(response => {

                let data = {
                    is: true,
                    object: element
                };
                this.animateShow(data);
                $('.intro').html(response.data.chapter);
                $('.pages').html(response.data.pagination);
            });

            return false;

        }).on('click', '.tip, .greek-chapter' , event => {

            let element = $(event.target);

            if(!$(event.target).hasClass('greek-chapter'))
                element = element.hasClass('tip') ? element : element.closest('.tip');

            axios.post('/comment-data', {
                code: element.attr('data')
            }).then(response => {

                let modal = $('<div class="card detal-word">' +
                    '                  <div class="remove"><i class="fa fa-close"></i></div>' +
                    '                  <blockquote class="card-body">' +
                    '                    <footer style="border-top:none">' +
                    '                      <small class="text-muted">' +
                    '                        ' + response.data.chapter +
                    '                      </small>' +
                    '                    </footer>' +
                    '                  </blockquote>' +
                    '                </div>');

                this.setMoodalData(modal, '');

                if(element.attr('data').split('.').length > 1) {
                    let data = (element.attr('data').split('.')[2]).split('-'),
                        _data = [];
                    if(data.length == 1) {
                        _data.push(+data[0]);
                    }
                    else {
                        for(let i=(+data[0]);i<=(+data[1]);i++) {
                            _data.push(i);
                        }
                    }



                    $('#wordModal').find('.greek-chapter').each((i, el) => {

                        if (_data.indexOf(+$(el).text()) != -1) {
                            $(el).parent().addClass('active');
                        }
                    });
                }

            });

        });
    }

    animateShow(data) {
        if(!data.is) {
            $('.intro').css({opacity: .4});
            return true;
        }
        $('.intro').css({opacity: 1});
        $('html, body').animate({scrollTop: $('.intro').offset().top - 85}, 500);
        $('.updates').find('.collapse.show').removeClass('show').find('.page-item.active').removeClass('active');

        $('.updates').find('#colapse-' + (data.object.attr('href').split('=')[1]).split('_')[0] + '_').addClass('show');
        data.object.closest('.page-item').addClass('active');

        try {
            history.pushState(null, null, data.object.attr('href'));
        } catch(e) {}
    }

    setMoodalData(poper, header) {
        if(!$('#wordModal').hasClass('show'))
            $('#wordModal').modal();

        poper.find('.remove').remove();
        $('#wordModal').find('.modal-title').text(header);
        $('#wordModal').find('.modal-body').html(poper);
    }


}

new Comment();