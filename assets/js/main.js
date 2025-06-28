jQuery(function ($) {

    if ($('body').hasClass("home")) {
        // jQuery
        var $carousel = $('.dn__slider').flickity({
            wrapAround: true,
            imagesLoaded: true,
            autoPlay: 5000,
            cellAlign: "center",
            dragThreshold: 15,
            rightToLeft: false,
            adaptiveHeight: true,
            prevNextButtons: false,
            pageDots: true,
            on: {
                ready: function () {
                    setTimeout(function (e) {
                        jQuery("[data-animate]").each(function (t, e) {
                            var i = jQuery(e);
                            i.attr("data-animated", "true");
                        })
                    }, 300)

                },
            }
        });
    }
    function isEmpty(el) {
        return !$.trim(el.html())
    }

    // Sticky navbar
    // =========================

    // Custom function which toggles between sticky class (is-sticky)
    var stickyToggle = function (sticky, stickyWrapper, scrollElement, stickyHeight) {
        var stickyTop = stickyWrapper.offset().top;
        if (scrollElement.scrollTop() >= stickyTop && scrollElement.scrollTop() > 0) {
            stickyWrapper.height(stickyHeight);
            sticky.addClass("is-sticky");
        }
        else {
            sticky.removeClass("is-sticky");
            stickyWrapper.height('auto');
        }
    };
    $('[data-toggle="sticky-onscroll"]').each(function () {
        var sticky = $(this);
        var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
        sticky.before(stickyWrapper);
        sticky.addClass('sticky');
        var stickyHeight = sticky.outerHeight();
        // Scroll & resize events
        $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
            stickyToggle(sticky, stickyWrapper, $(this), stickyHeight);
        });

        // On page load
        stickyToggle(sticky, stickyWrapper, $(window), stickyHeight);
        // Check scroll top
        var winSt_t = 0;
        $(window).scroll(function () {
            var winSt = $(window).scrollTop();
            if (winSt >= winSt_t) {
                sticky.removeClass("top_show")
            } else {
                sticky.addClass("top_show")
            }
            winSt_t = winSt
        });
    });

    //check home
    if ($('body').hasClass("home")) {
        new WOW().init();
    }

    //-------------------------------------------------
    // Header Search
    //-------------------------------------------------
    var $headerSearchToggle = $('.header__search--toggle');
    var $headerSearchForm = $('.header__search__form');

    $headerSearchToggle.on('click', function () {
        var $this = $(this);
        var $header = $(this).closest('.header__search');

        if (!$header.hasClass('open-search')) {
            $header.addClass('open-search');
            $headerSearchForm.slideDown();
        } else {
            $header.removeClass('open-search');
            $headerSearchForm.slideUp();
        }
    });

    // $('.header__search').mousedown(function(e){ e.stopPropagation(); });
    // $(document).mousedown(function(e){
    //     $('.header__search').removeClass('open-search');
    //     $headerSearchForm.slideUp();
    // });


    /*----Get Header Height ---*/
    // function get_header_height() {
    //     var header_sticky=$("header").outerHeight()
    //     $('body').css("--header-height",header_sticky+'px')
    // }

    // setTimeout(function(){
    //     get_header_height()
    // }, 500);

    // $( window ).resize(function() {
    //   get_header_height()
    // });


    /*----Back to top---*/
    var back_to_top = $(".back-to-top"), offset = 220, duration = 500; $(window).scroll(function () { $(this).scrollTop() > offset ? back_to_top.addClass("active") : back_to_top.removeClass("active") }), $(document).on("click", ".back-to-top", function (o) { return o.preventDefault(), $("html, body").animate({ scrollTop: 0 }, duration), !1 });

    //-------------------------------------------------
    // Menu
    //-------------------------------------------------
    $.fn.dnmenu = function (options) {

        let thiz = this
        let menu = $(this).attr('id')
        let menu_id = '#' + menu
        var button = $('a[href="#' + menu + '"]')

        // Default options
        var settings = $.extend({
            name: 'John Doe'
        }, options);

        // get ScrollBar Width
        function getScrollBarWidth() {
            var $outer = $('<div>').css({ visibility: 'hidden', width: 100, overflow: 'scroll' }).appendTo('body'),
                widthWithScroll = $('<div>').css({ width: '100%' }).appendTo($outer).outerWidth();
            $outer.remove();
            return 100 - widthWithScroll;
        };
        let ScrollBarWidth = getScrollBarWidth() + 'px';

        // Create wrap
        // Button click
        button.click(function (e) {
            e.preventDefault()
            console.log(button)
            if (button.hasClass('active')) {
                // $('.dnmenu-backdrop').remove()
                $('body').removeClass('modal-open').css("padding-right", "")
                button.removeClass('active')
                $(menu_id).removeClass('active')

            } else {
                // $('<div class="dnmenu-backdrop">').appendTo('body')
                $('body').addClass('modal-open').css("padding-right", ScrollBarWidth)
                button.addClass('active')
                $(menu_id).addClass('active')

            }
        });

        // Custom close
        // $('.nav__mobile__close').click(function(){
        //     $('body').removeClass('modal-open')
        //     $(this).removeClass('active')
        //     $(menu_id).removeClass('active')
        // })

        // Close menu
        $('body').on("click", ".dnmenu-backdrop", function () {
            $('.dnmenu-backdrop').remove()
            button.removeClass('active')
            $(menu_id).removeClass('active')
        });
        // Menu
        var el = $(thiz).find(".nav__mobile--ul");
        el.find(".menu-item-has-children>a").after('<button class="nav__mobile__btn"><i></i></button>'),

            el.find(".nav__mobile__btn").on("click", function (e) {
                e.stopPropagation(),
                    $(this).parent().find('.sub-menu').first().is(":visible") ? $(this).parent().removeClass("sub-active") :
                        $(this).parent().addClass("sub-active"),
                    $(this).parent().find('.sub-menu').first().slideToggle()
            })

        // Apply options
        return;
    };
    $('#menu__mobile').dnmenu()


    // Shop
    function isInt(n) {
        return parseInt(n) === n
     }
    function number__toFixed(value) {
        return isInt(value) ? value : value.toFixed(1);
    }
    
    $(document).on('click', '.quantity.s1 input[type="button"]' ,quantity_input);
    
    function quantity_input(argument) {
      var input = $(this);
      var input_type = 'plus'
      if($(this).hasClass('minus')) input_type = 'minus'
    
      var input_number =  $(this).parent('.quantity').find('input[type="number"]');
      var input_number_val = (input_number.val()) ? parseFloat(input_number.val()) : 0
      // Get Setting
      var step = (input_number.attr('step')) ? parseFloat(input_number.attr('step')) : 1
      var min = (input_number.attr('min')) ? parseFloat(input_number.attr('min')) : 0
      var max = (input_number.attr('max')) ? parseFloat(input_number.attr('max')) : 999
    
      if(input_type == 'plus') result = number__toFixed( input_number_val + step )
      else result = number__toFixed(input_number_val - step)
      if (result >= min && result <= max) input_number.val( result ).change();
    }

});


