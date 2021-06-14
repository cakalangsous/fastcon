$('.fastcon-slick-nav button.owl-prev').click(function(e) {
    $('.slick-prev').trigger('click');
});

$('.fastcon-slick-nav button.owl-next').click(function(e) {
    $('.slick-next').trigger('click');
});


let first_active = $('.owl-stage').first();
if(first_active.hasClass('active')){
    $('.fastcon-slick-nav button.owl-prev').addClass('disabled');
    $('.fastcon-slick-nav button.owl-prev').attr('disabled', 'disabled');
}

$(document).ready(() => {

    if( $body.hasClass('fastcon-menu') && ( $body.hasClass('device-md') || $body.hasClass('device-sm') || $body.hasClass('device-xs') ) ) {
        $('#primary-menu-trigger').off( 'click' ).on( 'click', function() {

            if($body.hasClass('primary-menu-open')){
                $( '.primary-menu:not(.mobile-menu-off-canvas) .menu-container' ).hide("slide", { direction: "right" }, 300);
                $('.primary-menu').css('opacity', 0);
                $('.primary-menu').css('z-index', -2);
                $('.primary-menu').css('pointer-events', 'none');
                $('#primary-menu-trigger').css('z-index', 1);
                $body.css('overflow', 'unset');

            } else {
                $( '.primary-menu:not(.mobile-menu-off-canvas) .menu-container' ).show("slide", { direction: "left" }, 300);
                $('.primary-menu').css('opacity', 1);
                $('.primary-menu').css('z-index', 499);
                $('.primary-menu').css('pointer-events', 'auto');
                $('#primary-menu-trigger, .header-misc, #logo').css('z-index', 599);
                $body.css('overflow', 'hidden');
            }
            
            $( '.primary-menu .menu-container' ).toggleClass('d-flex');


            $body.toggleClass("primary-menu-open");
            return false;
        });
    }
    $('.fastcon-slick').slick({
      centerMode: true,
      centerPadding: '260px',
      slidesToShow: 2,
      responsive: [
        {
          breakpoint: 769,
          settings: {
            arrows: true,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: true,
            centerMode: true,
            centerPadding: '30px',
            slidesToShow: 1
          }
        }
      ]
    })

    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      asNavFor: '.slider-nav',
      autoplay: true,
      fade: true,
      adaptiveHeight: true
    });
    
    $('.slider-nav').slick({
      slidesToShow: 6,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      centerMode: true,
      focusOnSelect: true
    });

    var hidWidth;
    var scrollBarWidths = 40;

    var widthOfList = function(){
      var itemsWidth = 0;
      $('.list a').each(function(){
          var itemWidth = $(this).outerWidth();
          itemsWidth+=itemWidth;
      });
      return itemsWidth;
    };

    var widthOfHidden = function(){
        var ww = 0 - $('.wrapper').outerWidth();
        var hw = (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
        var rp = $(document).width() - ($('.nav-item.nav-link').last().offset().left + $('.nav-item.nav-link').last().outerWidth());
        
        if (ww>hw) {
            //return ww;
            return (rp>ww?rp:ww);
        }
        else {
            //return hw;
            return (rp>hw?rp:hw);
        }
    };

    var getLeftPosi = function(){
        
        var ww = 0 - $('.wrapper').outerWidth();
        var lp = $('.list').position().left;
        
        if (ww>lp) {
            return ww;
        }
        else {
            return lp;
        }
    };

    var reAdjust = function(){
    
    // check right pos of last nav item
    var rp = $(document).width() - ($('.nav-item.nav-link').last().offset().left + $('.nav-item.nav-link').last().outerWidth());
    if (($('.wrapper').outerWidth()) < widthOfList() && (rp<0)) {
        $('.scroller-right').show().css('display', 'flex');
    }
    else {
        $('.scroller-right').hide();
    }
    
    if (getLeftPosi()<0) {
        $('.scroller-left').show().css('display', 'flex');
    }
    else {
        $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
        $('.scroller-left').hide();
    }
    }

    reAdjust();

    $(window).on('resize',function(e){  
        reAdjust();
    });

    $('.scroller-right').click(function() {
    
    $('.scroller-left').fadeIn('slow');
    $('.scroller-right').fadeOut('slow');
    
    $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){
        reAdjust();
    });
    });

    $('.scroller-left').click(function() {
    
        $('.scroller-right').fadeIn('slow');
        $('.scroller-left').fadeOut('slow');
    
        $('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
            reAdjust();
        });
    });
})