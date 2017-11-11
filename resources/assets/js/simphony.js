'use strict';

class Simphony {

    constructor() {
        this.init();
    }

    init() {
        this.run();
    }

    run() {

        $('body').on('click', '.action-class', (event) => {
            let element = $(event.target);

            this.animateShow({is: false});

            axios.post('/simphony-' + element.attr('data'), {
                word: element.attr('href').split('word=')[1]
            }).then(response => {

                let data = {
                    is: true,
                    object: element
                };
                this.animateShow(data);
                $('.intro').html(response.data);
            });

            return false;
        });

    }

    animateShow(data) {
        if(!data.is) {
            $('.intro').css({opacity: .4});
            return true;
        }
        $('.intro').css({opacity: 1});
        $('html, body').animate({scrollTop: $('.intro').offset().top - 85}, 500);
        $('.updates').find('.simphony-class.active').removeClass('active');
        $('.updates').find('.simphony-class').each((index, el) => {
            if($(el).find('a').text() == data.object.text())
                $(el).addClass('active');
        });

        try {
            history.pushState(null, null, data.object.attr('href'));
        } catch(e) {}
    }

}

new Simphony();