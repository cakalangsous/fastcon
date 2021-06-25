$('.fastcon-slick-nav button.owl-prev').click(function(e) {
    $('.slick-prev').trigger('click');
    let post_item = $('.slick-slide:nth-last-child(2)');
    if(post_item.hasClass('slick-active') || post_item.hasClass('slick-current')) {
        $('.fastcon-slick-nav button.owl-next').removeAttr('disabled', 'disabled');
        $('.fastcon-slick-nav button.owl-next').removeAttr('readonly', 'readonly');
    }

    checkFirst();
    
});

$('.fastcon-slick-nav button.owl-next').click(function(e) {
    let post_item = $('.slick-slide:nth-last-child(2)');
    if(post_item.hasClass('slick-active') || post_item.hasClass('slick-current')) {
        $('.fastcon-slick-nav button.owl-next').attr('disabled', 'disabled');
        $('.fastcon-slick-nav button.owl-next').attr('readonly', 'readonly');
    }

    let post_item_second = $('.slick-track:nth-child(2)');
    if(!post_item_second.hasClass('slick-active') || post_item_second.hasClass('slick-current')) {
        $('.fastcon-slick-nav button.owl-prev').removeAttr('disabled', 'disabled');
        $('.fastcon-slick-nav button.owl-prev').removeAttr('readonly', 'readonly');
    }
    

    $('.slick-next').trigger('click');
});


let first_active = $('.owl-stage').first();
if(first_active.hasClass('active')){
    $('.fastcon-slick-nav button.owl-prev').addClass('disabled');
    $('.fastcon-slick-nav button.owl-prev').attr('disabled', 'disabled');
}

const checkFirst = () => {
    let post_item_first = $('.slick-slide:first-child');
    if(post_item_first.hasClass('slick-active') || post_item_first.hasClass('slick-current')) {
        $('.fastcon-slick-nav button.owl-prev').attr('disabled', 'disabled');
        $('.fastcon-slick-nav button.owl-prev').attr('readonly', 'readonly');
    }else {
        $('.fastcon-slick-nav button.owl-prev').removeAttr('disabled', 'disabled');
        $('.fastcon-slick-nav button.owl-prev').removeAttr('readonly', 'readonly');
    }


    let post_item_last = $('.slick-slide:nth-last-child(2)');

    if(post_item_last.hasClass('slick-active') || post_item_last.hasClass('slick-current')) {
        $('.fastcon-slick-nav button.owl-next').removeAttr('disabled', 'disabled');
        $('.fastcon-slick-nav button.owl-next').removeAttr('readonly', 'readonly');
    }
}

$('.select-change-page').change(function(event) {
    var selected_value = $(this).children("option:selected").val();

    if(selected_value !== 'logout'){
        window.location.href = selected_value;
    }else {
        $('.logout-modal').modal('show');
    }
});

$('#add_address_btn').click(() => {
    $('.address-modal').modal('hide');
    $('.form-address-modal').modal('show');
})

$('.member-nav-select').on('show.bs.select', () => {
    setTimeout(() => {
        $('.member-nav-select .dropdown-menu').css('left', '5px');
    }, 0.001)
})


$(document).ready(() => {

    setTimeout(() => {
        let member_content = $('.member-content-wrap');
        if(member_content !== 'undefined') {
            $('.member-wrapper .content-wrap').css('min-height', member_content.height());
        }
    }, 80)


    $('.modal').on('show.bs.modal', () => {
        $('body').css('overflow', 'hidden');
    });

    $('.modal').on('hide.bs.modal', () => {
        $('body').css('overflow', 'unset');
    });

    setTimeout(() => {
        checkFirst();
    },2000);

    $('#home_modal').modal('show');

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
      centerMode: false,
      centerPadding: '0',
      slidesToShow: 2,
      infinite:false,
      variableWidth: true,
      responsive: [
        {
          breakpoint: 769,
          settings: {
            arrows: true,
            centerMode: false,
            centerPadding: '20px',
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: true,
            centerMode: true,
            centerPadding: '0',
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
      responsive: [{
            breakpoint: 768,
            settings: {
                autoplay: false,
                // autoplaySpeed: 6000,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                centerMode: true
            }
      }]
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