'use strict';

class App {

    constructor() {
        this.init();
    }

    init() {
        this.topMenu();
    }

    topMenu() {
        $(window).scroll(() => {
            if ($(window).scrollTop() > 40)
                $('.navbar').removeClass('bg-transparent');
            else
                $('.navbar').addClass('bg-transparent');
        });

        $('.navbar-nav').on('mouseover', 'a.dropdown-toggle', (event) => {
            setTimeout(() => {
                $(event.target).parent('.dropdown').addClass('show');
            }, 200);
        }).on('mouseleave', 'a.dropdown-toggle, .dropdown-menu', (event) => {
            setTimeout(() => {
                if(!$(event.target).parents('.nav-item.dropdown').first().find(':hover').length) {
                    $(event.target).parents('.dropdown').removeClass('show');
                    return true;
                }
                if($(event.target).hasClass('dropdown-toggle')
                    && $(event.target).parent().hasClass('dropdown-submenu')) {
                    if(!$(event.target).closest('.dropdown').find(':hover').length)
                        $(event.target).closest('.dropdown').removeClass('show');
                    return true;
                }
                if($(event.target).parent().hasClass('dropdown-submenu')
                    || ($(event.target).parent().hasClass('dropdown-menu')
                        && !$(event.target).parent().hasClass('dropdown-submenu'))) {
                    $(event.target).closest('.dropdown').removeClass('show');
                }
            }, 200);
        });

    }

}

new App();