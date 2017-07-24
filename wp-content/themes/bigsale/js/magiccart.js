function magicproduct(el, iClass) {

    var options = el.data();
    //console.log(options)
    if(iClass === undefined){
        el.children().addClass('alo-item');
        iClass = '.alo-item';
    }
    var selector = el.selector;
    var classes = selector + ' '+ iClass;
    var padding = options.padding;
    var style = padding ? classes + '{float: left; padding-left: '+padding+'px; padding-right:'+padding+'px} ' + selector + '{margin-left: -'+padding+'px; margin-right: -'+padding+'px}' : '';
    if(options.slidesToShow){
        el.slick(options);
    } else {
        var responsive  = options.responsive;
        if(responsive == undefined) return;
        var length = Object.keys(responsive).length;
        jQuery.each( responsive, function( key, value ) { // data-responsive="[{"1":"1"},{"361":"1"},{"480":"2"},{"640":"3"},{"768":"3"},{"992":"4"},{"1200":"4"}]"
            var col = 0;
            var maxWith = 3600;
            var minWith = 0;
            jQuery.each( value , function(size, num) { minWith = size; col = num; });
            if(key+1<length){
                jQuery.each( responsive[key+1], function( size, num) { maxWith = size-1; });
                // padding = options.padding*(maxWith/1200); // padding responsive
            }
            style += ' @media (min-width: '+minWith+'px) and (max-width: '+maxWith+'px) {'+classes+'{padding-left: '+padding+'px; padding-right:'+padding+'px; width: '+(Math.floor((10/col) * 100000000000) / 10000000000)+'%} '+classes+':nth-child('+col+'n+1){clear: left;}}';
        });

        /*$.each( responsive, function( key, value ) { // data-responsive="[{"col":"1","min":1,"max":360},{"col":"2","min":361,"max":479},{"col":"3","min":480,"max":639},{"col":"3","min":640,"max":767},{"col":"4","min":768,"max":991},{"col":"4","min":992,"max":1199},{"col":"4","min":1200,"max":3600}]"
         style += ' @media (min-width: '+value.min+'px) and (max-width: '+value.max+'px) {'+classes+'{padding: 0 '+padding+'px; width: '+(Math.floor((10/value.col) * 100000000000) / 10000000000)+'%} '+classes+':nth-child('+value.col+'n+1){clear: left;}}';
        });*/
    }

    return '<style type="text/css">'+style+'</style>';
}

/* Timer */
(function ($) {
    "use strict";
    $.fn.timer = function (options) {
        var defaults = {
            classes      : '.countdown',
            layout       : '<span class="day">%%D%%</span><span class="colon">:</span><span class="hour">%%H%%</span><span class="colon">:</span><span class="min">%%M%%</span><span class="colon">:</span><span class="sec">%%S%%</span>',
            layoutcaption: '<div class="timer-box"><span class="day">%%D%%</span><span class="title">Days</span></div><div class="timer-box"><span class="hour">%%H%%</span><span class="title">Hrs</span></div><div class="timer-box"><span class="min">%%M%%</span><span class="title">Mins</span></div><div class="timer-box"><span class="sec">%%S%%</span><span class="title">Secs</span></div>',
            leadingZero  : true,
            countStepper : -1, // s: -1 // min: -60 // hour: -3600
            timeout      : '<span class="timeout">Time out!</span>',
        };

        var settings = $.extend(defaults, options);
        var layout           = settings.layout;
        var layoutcaption    = settings.layoutcaption;
        var leadingZero      = settings.leadingZero;
        var countStepper     = settings.countStepper;
        var setTimeOutPeriod = (Math.abs(countStepper)-1)*1000 + 990;
        var timeout          = settings.timeout;

        var methods = {
            init : function() {
                return this.each(function() {
                    var $countdown  = $(settings.classes, $(this));
                    if( $countdown.length )methods.timerLoad($countdown);
                });
            },
            
            timerLoad: function(el){
                var gsecs = el.data('timer');
                if(isNaN(gsecs)){
                    var start = Date.parse(new Date());
                    var end = Date.parse(gsecs);
                    gsecs  = (end - start)/1000;    
                }
                if(gsecs > 0 ){
                    methods.CountBack(el, gsecs);
                }
            },

            calcage: function (secs, num1, num2) {
                var s = ((Math.floor(secs/num1)%num2)).toString();
                if (leadingZero && s.length < 2) s = "0" + s;
                return "<b>" + s + "</b>";
            },

            CountBack: function (el, secs) {
                if (secs < 0) {
                    el.html(timeout);
                    return;
                }
                if(el.hasClass('caption')){
                    var timerStr = layoutcaption.replace(/%%D%%/g, methods.calcage(secs,86400,100000));
                }else {
                    var timerStr = layout.replace(/%%D%%/g, methods.calcage(secs,86400,100000));                    
                }
                timerStr = timerStr.replace(/%%H%%/g, methods.calcage(secs,3600,24));
                timerStr = timerStr.replace(/%%M%%/g, methods.calcage(secs,60,60));
                timerStr = timerStr.replace(/%%S%%/g, methods.calcage(secs,1,60));
                el.html(timerStr);
                setTimeout(function(){ methods.CountBack(el, (secs+countStepper))}, setTimeOutPeriod);
            },

        };

        if (methods[options]) { // $("#element").pluginName('methodName', 'arg1', 'arg2');
            return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof options === 'object' || !options) { // $("#element").pluginName({ option: 1, option:2 });
            return methods.init.apply(this);
        } else {
            $.error('Method "' + method + '" does not exist in timer plugin!');
        }
    }

    jQuery(document).ready(function($) {
        if (typeof alo_timer_layoutcaption != 'undefined'){
            $('.alo-count-down').not('.exception').timer({
                classes         : '.countdown',
                layout          : alo_timer_layout, 
                layoutcaption   : alo_timer_layoutcaption, 
                timeout         : alo_timer_timeout
            });
        } else {
            $('.alo-count-down').not('.exception').timer({classes : '.countdown'});         
        }
    });
})(jQuery);
/* End Timer */

jQuery(document).ready(function($){

   /* List Gird*/
    $('#grid').click(function() {
        $(this).addClass('active');
        $('#list').removeClass('active');

        $('ul.products').fadeOut(500, function() {
            $(this).removeClass('list').addClass('grid').fadeIn(500);
            $(this).find(".product").each(function(){
                $(this).find('.product-img').append($(this).find('.quickview'));
            });      
        });
        return false;
    });
    $('#list').click(function() {
        $(this).addClass('active');
        $('#grid').removeClass('active');

        $('ul.products').fadeOut(500, function() {
            $(this).removeClass('grid').addClass('list').fadeIn(500);
             $(this).find(".product").each(function(){
                $(this).height('').find('.product-summary').append($(this).find('.quickview'));
            });        
        });
        return false;
    });

    $('#gridlist-toggle a').click(function(event) {
        event.preventDefault();
    });
    
    /* click cart */
    var $toggleTab  = $('.toggle-tab');
    $toggleTab.click(function(){
        $(this).parent().toggleClass('toggle-visible').find('.toggle-content').slideToggle(300).toggleClass('visible');
    });

});

jQuery(document).ready(function($){
    var gallery = $('.woocommerce-product-gallery__wrapper');
    var thumbnails = $('#wrapper-thumbs');
    var html = '';
    gallery.children().each(function(index){
        if(!$(this).data('index') ){
            $(this).data('index', 0);
        }
        html += '<li class="thumb-image" data-index="' + $(this).data('index') + '"><img src="' + $(this).data('thumb') + '"/></li>';
    })
    $('.woocommerce-product-gallery').append('<ol class="slider">' + html + '</ol>');
    var slider = $('.woocommerce-product-gallery .slider').slick(thumbnails.data());
    
    slider.on( "click", ".thumb-image", function() {
        $('.flex-control-nav').children().eq($(this).data('index')).find('img').trigger('click');


    }); 

    $('.flex-control-thumbs li:first img').on('load', function () {
        var src = $(this).attr('src');
        $('ol.slick-initialized .slick-track').children().each(function(index){
            if($(this).data('index') == 0){
                $(this).find('img').attr('src', src);
            }
        });
    });
    
    $(".slider.slick-slider li").click(function(){
        $(".slider.slick-slider li").removeClass("thumb-active");
        $(this).addClass("thumb-active");
        console.log('ok');
    });


    //  QTY
    $(document).on('click', '.reduced.btn-plus', function() {
         var result = $(this).parent().find('.qty'); 
         var e = jQuery.Event("change");
         result.trigger(e);
         var qty = result.val(); 
         var max = parseInt(result.attr('max')); 
         var min = parseInt(result.attr('min'));
        if(qty > max){ 
            result.val(max);
            qty = result.val();
        }
        if( !isNaN( qty ) && qty > 0 && (qty > min)){
            result.val(--qty);
        }else{
            return false;
        }
    });


    $(document).on('click', '.increase.btn-plus', function() {
        var result = $(this).parent().find('.qty');
        var e = jQuery.Event("change");
         result.trigger(e);
        var qty = result.val(); 
        var max = parseInt(result.attr('max')); 
        if(qty > max){ 
            result.val(max);
        }
        if( isNaN(max) || (!isNaN( qty ) && qty < max) ){
            result.val(++qty);
        }else{
            return false;
        }
    });

   //$(".entry-summary.summary .yith-wcwl-add-to-wishlist, .entry-summary.summary .compare").not(".actions .yith-wcwl-add-to-wishlist,.actions .compare").remove();
   
   // $(".entry-summary.summary .actions .yith-wcwl-add-to-wishlist,.entry-summary.summary .actions .compare").css({"display" : "inline-block"});
    var htmlActions = $(".entry-summary.summary .yith-wcwl-add-to-wishlist, .entry-summary.summary .compare");
    $(".actions").append(htmlActions);

    
    // POPUP
var timeCookie = $("#inline-popups").attr("data-popup-cookie");
var timeDelay  = $("#inline-popups").attr("data-popup-delay") * 1000;

    
if($.cookie("cookiePopup") == null){
    var timeS = (1/24/60/60) * timeCookie;
    $.cookie("cookiePopup", "1", {
       expires : timeS,           // S
    });

    $('#inline-popups').magnificPopup({
      delegate: 'a',
      removalDelay: 500, //delay removal by X to allow out-animation
      callbacks: {
        beforeOpen: function() {
           this.st.mainClass = this.st.el.attr('data-effect');
        },
        close: function() {
            if($(".disabled_popup_by_user").is(":checked")){
                timeS = (1/24/60) * 30;
                    $.cookie("cookiePopup", "1", {
                    expires : timeS,           // S
                });
            }
          },
      },
      midClick: true 
    });
    setTimeout(function(){
      $("#inline-popups li a").trigger("click");
    }, timeDelay);
}
 
    /* Image Category banner */
    var url      = window.location.href;
    var item = $(".menu ul li a")
    $.each(item, function(index){
        if(this.href == url){
            var href = $(this).attr('data-image');
            if(href){
                $(".category-image img").attr('src', href);
                return;
            }
        }
    })

    $(".category-image img").css("display", "block");
    $(".widget_price_filter form").css("display", "block");

    $(".action-header .fa-search").click(function(){
        $(".search-dropdown").toggle(1000,function(){
            $(this).css("display", 'block');
        });
    });


});

 //Add to top button when scrolling
jQuery(window).scroll(function() {
    var calScreenWidth = jQuery(window).width();
    
    if(jQuery(this).scrollTop() > 200) {
        jQuery('#toTop').stop().css({opacity: 0.5, "visibility": "visible"}).animate({"visibility": "visible"}, {duration:1000,easing:"easeOutExpo"});
    } else if(jQuery(this).scrollTop() == 0) {
        jQuery('#toTop').stop().css({opacity: 0, "visibility": "hidden"}).animate({"visibility": "hidden"}, {duration:1500,easing:"easeOutExpo"});
    }
});

jQuery('#toTop').on( 'click', function() {
    jQuery('body,html').animate({scrollTop:0},800);
});