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

let result = [];
$('.product_option_select').change(function (e) {
    e.preventDefault();


    $('select[name="product_options[]"]').map(function(index) {
        let arr = {};
        if ($(this).val()) {
            arr["product"] = $(this).data('product');
            arr["option"] = $(this).data('option_id');
            arr["value"] = $(this).val();
        }

        result[index] = arr;
        return result;
    }).get();

    // $.ajax({
    //     url: base_url + 'products/get_related_variants',
    //     type: 'POST',
    //     dataType: 'JSON',
    //     data: {[csrf_name]:csrf_val, result},
    // })
    // .done(function(res) {
    //     console.log(res);
    // });
    
});

$('#add_to_cart_btn').click(function (e) {
    e.preventDefault();

    var quantity = $('form.cart #quantity').val();
    var selected_value = result;

    $.ajax({
        url: base_url + 'products/add_to_cart',
        type: 'post',
        dataType: 'json',
        data: {[csrf_name]:csrf_val, selected_value, quantity},
    })
    .done(function(res) {
        if (res.status===false) {
            if (res.redirect!=undefined) {
                window.location.href = res.redirect;
                return;
            }else{

            }
        }else {
            $('#added_to_cart_modal').modal('show');
        }
    });
    
});

$('.coupon-item').click(function (e) {
    e.preventDefault();

    var voucher_code = $(this).data('code');
    var voucher_desc = $(this).data('desc');


    $('#voucher_code').text(voucher_code);
    $('#voucher_description').html(voucher_desc);
    $('.coupon-details-modal').modal('show');
});

$('.coupon-details-modal').on('.hide.bs.modal', () => {
    $('#voucher_code').text('');
    $('#voucher_description').text('');
});

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

// $('.select-change-page').change(function(event) {
//     var value = $(this).val();
//     window.location.href = value;
// });

$('#kota_kecamatan').keyup(function(event) {
    var search = $("#kota_kecamatan").val();
    if (search.length>2) {
        var result =[] ;
        $.ajax({
            url: base_url + 'member/kota_kecamatan',
            dataType: 'json',
            data: {[csrf_name]:csrf_val, kota_kecamatan:search},
            type: "POST",
            success: function(response) {
                for(i=0;i<response.length;i++)
                {
                    result[i]=(response[i].provinsi + ", " + response[i].kabupaten + ", " + response[i].kecamatan + ", " + response[i].kelurahan + ", " + response[i].kode_pos);
                }
            }
        });

        $("#kota_kecamatan").autocomplete({
            source :result,
            classes: {
                "ui-autocomplete": "frontbox",
            },
            appendTo: '#auto_result',
            change: function(event, ui){
                if (!ui.item) {
                    $(this).val('');
                }
            }
        });
    }
});

$('.edit_address').click(function(e) {
    e.preventDefault();

    let name = $(this).data('name');
    let email = $(this).data('email');
    let phone = $(this).data('phone');
    let address = $(this).data('address');
    let id = $(this).data('id');

    $('#address_form_member input[name="fullname"]').val(name);
    $('#address_form_member input[name="email"]').val(email);
    $('#address_form_member input[name="phone"]').val(phone);
    $('#address_form_member textarea#address').val(address);

    $('#address_form_member').attr('action', base_url+'member/update_address/'+id)

    $('#address_modal_form').modal('show');
});

$('#address_modal_form').on('hide.bs.modal', () => {
    $('#address_form_member').trigger('reset');
});

function calc() {
    var panjang = $('#calculator_form #panjang').val();
    var lebar = $('#calculator_form #lebar').val();
    var tinggi = $('#calculator_form #tinggi').val();
    var ketebalan = $('#calculator_form #ketebalan').val();


    if (panjang!=='' || lebar!=='' || tinggi!=='') {
        panjang = parseInt(panjang);
        lebar = parseInt(lebar);
        tinggi = parseInt(tinggi);


        let bata;

        switch(ketebalan) {
            case '75' : bata = 11.1; break;
            case '100' : bata = 8.3; break;
            default : bata = 0;
        }

        console.log(`bata=${bata}`);

        let keliling, luas, kebutuhan, kubik;

        keliling = 2 * (panjang + lebar);
        console.log(`keliling = ${keliling}`);

        luas = keliling * tinggi;
        console.log(`luas = ${luas}`);

        kebutuhan = luas * bata;
        console.log(`kebutuhan = ${kebutuhan}`);


        kubik = kebutuhan / (bata * 10);
        console.log(`kubik = ${kubik}`);

        if (!isNaN(kebutuhan) && !isNaN(kubik)) {
            $('#needs').text(kebutuhan.toFixed(1));
            $('#kubik_needs').text(kubik.toFixed(1));
        }

    }


}


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



    if (active_page=='distributor') {

        var widthOfHidden = function(){
            var ww = 0 - $('.wrapper').outerWidth();
            var hw = (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
            // var rp = $(document).width() - ($('.nav-item.nav-link').last().offset().left + $('.nav-item.nav-link').last().outerWidth());
            var rp = $(document).width() - ($('.nav-item.nav-link').last().offset() + $('.nav-item.nav-link').last().outerWidth());

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

    }
})