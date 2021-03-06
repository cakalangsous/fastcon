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

$('#product_options1').change(function (e) {
    e.preventDefault();

    let option1 = $(this).val();
    let product = $(this).data('product');

    $('.helper-text.option1').hide();

    $.ajax({
        url: base_url + 'products/get_option2',
        type: 'post',
        dataType: 'json',
        data: {[csrf_name]:csrf_val, option1, product},
    })
    .done(function(res) {
        if (res.status===200) {
            let html = '';
            $.each(res.data, function(index, val) {
                 html += `<option value="${val.option_value2_id}">${val.option_value2}</option>`
            });
            $('#product_options2').html(html).selectpicker('refresh');
        }else if(res.status===404){
            let price_text = 0;
            let real_price_text = false;
            let sku = '';
            $.each(res.data, function(index, val) {
                price_text = parseInt(val.price) - parseInt(val.discount);
                sku = val.sku;
                $('.main-price').removeClass('cl-error');
                 if(val.discount>0) {
                    real_price_text = val.price;
                    $('.main-price').addClass('cl-error');
                 }
            });

            if (real_price_text==false) {
                $('.normal-price').hide();
            }else{
                $('.normal-price').text('Rp'+convert_rupiah(real_price_text));
                $('.normal-price').show();
            }
            $('.main-price').text('Rp'+convert_rupiah(price_text));
            $('.product-sku span').text(sku + ' |');
        }
    });
    
});

$('.cancel-order').click(function (e) {
    e.preventDefault();

    const url = $(this).data('url');

    $('#cancel_order_modal .remove-btn').attr('href', url);
    $('#cancel_order_modal').modal('show');
});

$('#product_options2').change(function (e) {
    e.preventDefault();

    let product = $(this).data('product');
    let option1 = $('#product_options1').val();
    let option2 = $(this).val();

    $('.helper-text.option2').hide();

    $.ajax({
        url: base_url + 'products/get_variant',
        type: 'post',
        dataType: 'json',
        data: {[csrf_name]:csrf_val, product, option1, option2},
    })
    .done(function(res) {
        const data = res.data;
        let price_text = parseInt(data.price) - parseInt(data.discount);;
        let real_price_text = false;
        let sku = data.sku;
        $('.main-price').removeClass('cl-error');
        if(data.discount>0) {
            real_price_text = data.price;
            $('.main-price').addClass('cl-error');
        }

        if (real_price_text==false) {
            $('.normal-price').hide();
        }else{
            $('.normal-price').text('Rp'+convert_rupiah(real_price_text));
            $('.normal-price').show();
        }
        $('.main-price').text('Rp'+convert_rupiah(price_text));
        $('.product-sku span').text(sku + ' |');
    });
});

function convert_rupiah(angka) {
    var number_string = angka.toString(),
    sisa    = number_string.length % 3,
    rupiah  = number_string.substr(0, sisa),
    ribuan  = number_string.substr(sisa).match(/\d{3}/g);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return rupiah;
}

$('#add_to_cart_btn').click(function (e) {
    e.preventDefault();

    let quantity = $('form.cart #quantity').val();
    let option1 = $('#product_options1').val();
    let option2 = $('#product_options2').val();
    const product = $(this).data('product');

    let option = {};

    option['option1'] = option1;
    if (option2!=null) {
        option['option2'] = option2;
    }

    $.ajax({
        url: base_url + 'products/add_to_cart',
        type: 'post',
        dataType: 'json',
        data: {[csrf_name]:csrf_val, product, option, quantity},
    })
    .done(function(res) {
        if (res.status==true) {
            $('#added_to_cart_modal').modal('show');
            $('.icon-line-shopping-cart').addClass('cart-not-empty')
        }else {
            if (res.option=='option1') {
                $('.helper-text.option1').show();
                $('.helper-text.option2').show();
            }
            if (res.option=='option2') {
                $('.helper-text.option2').show();
            }
        }
    });
});

let variant_to_delete;
$('.delete-cart').click(function (e) {
    e.preventDefault();
    $('#delete_cart_modal img').removeAttr('src');
    $('#delete_cart_modal h4').text('');

    let product = $(this).data('product');
    let variant_id = $(this).data('variant');
    let rowid = $(this).data('rowid');
    let image = $(this).data('image');

    if (rowid!=null) {
        variant_to_delete = rowid;
    }else {
        variant_to_delete = variant_id;
    }

    $('#delete_cart_modal img').attr('src', image);
    $('#delete_cart_modal h4').text(product);
    $('#delete_cart_modal').modal('show');
});

$('.delete_action').click(function (e) {
    e.preventDefault();

    $.ajax({
        url: base_url + 'products/delete_cart_item',
        type: 'post',
        dataType: 'json',
        data: {[csrf_name]:csrf_val, variant:variant_to_delete},
    })
    .done(function(res) {
        if (res.status==true) {
            location.reload();
        }else{
            // add if cart failed to delete
        }
    });
    
});

if (active_page=='cart') {

    $(".plus").off( 'click' ).on( 'click', function(){
        let element = $(this).parents('.quantity').find('.qty'),
            elValue = element.val(),
            elStep = element.attr('step') || 1,
            elMax = element.attr('max'),
            intRegex = /^\d+$/;

        if( elMax && ( Number(elValue) >= Number( elMax ) ) ) { return false; }

        if( intRegex.test( elValue ) ) {
            let elValuePlus = Number(elValue) + Number(elStep);
            element.val( elValuePlus ).change();
        } else {
            element.val( Number(elStep) ).change();
        }

        let variant = $(this).data('variant');
        let quantity = $('#'+variant).val();

        $('#update_cart').removeClass('toast hide');

        return false;
    });

    $(".minus").off( 'click' ).on( 'click', function(){
        let element = $(this).parents('.quantity').find('.qty'),
            elValue = element.val(),
            elStep = element.attr('step') || 1,
            elMin = element.attr('min'),
            intRegex = /^\d+$/;

        if( !elMin || elMin < 0 ) { elMin = 1; }

        if( intRegex.test( elValue ) ) {
            if( Number(elValue) > Number( elMin ) ) {
                let elValueMinus = Number(elValue) - Number(elStep);
                element.val( elValueMinus ).change();
            }
        } else {
            element.val( Number(elStep) ).change();
        }

        let variant = $(this).data('variant');
        let quantity = $('#'+variant).val();
        $('#update_cart').removeClass('toast hide');

        return false;
    });
}

$('#copy_user').change(function() {
    if(this.checked) {
        let name = $('.guest-form #fullname').val();
        let phone = $('.guest-form #phone').val();

        $('#receiver_name').val(name);
        $('#receiver_phone').val(phone);
    }
});

$('.list-address-trigger').click(function (e) {
    e.preventDefault();

    $('.address-modal').modal('show');
});

$('.coupon-item').click(function (e) {
    e.preventDefault();

    const voucher_code = $(this).data('code');
    const voucher_desc = $(this).data('desc');
    const voucher_id = $(this).data('id');

    $('#voucher_code').text(voucher_code);
    $('#voucher_description').html(voucher_desc);
    // $('#use_coupon').attr('href', base_url+'member/use_coupon/'+voucher_id);
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
        $('#logout_modal').modal('show');
    }
});

$('.remove-address').click(function (e) {
    e.preventDefault();

    var id = $(this).data('id');
    
    $('.remove-btn').attr('href', base_url + 'member/delete_address/' + id);
    $('#delete_address_modal').modal('show');
});

$('#add_address_btn').click(() => {
    let btn = lang=='indonesian'?'TAMBAH ALAMAT':'ADD ADDRESS';
    $('#address_form_member .primary-btn').text(btn);
    $('.address-modal').modal('hide');
    $('.form-address-modal').modal('show');
})

$('.member-nav-select').on('show.bs.select', () => {
    setTimeout(() => {
        $('.member-nav-select .dropdown-menu').css('left', '5px');
    }, 0.001)
})

$('.member-nav-select').change(function (e) {
    e.preventDefault();

    let nav_val = $(this).val();

    if (nav_val=='logout') {
        $('#logout_modal').modal('show')
    }
});


$('#kota_kecamatan').keyup(function(event) {
    var search = $("#kota_kecamatan").val();
    if (search.length>2) {
        var result =[] ;
        $.ajax({
            url: base_url + 'pages/kota_kecamatan',
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
    let provinsi = $(this).data('province_id');
    let id = $(this).data('id');


    let btn = lang=='indonesian'?'PERBAHARUI ALAMAT':'UPDATE ADDRESS';

    $('#address_form_member input[name="fullname"]').val(name);
    $('#address_form_member input[name="email"]').val(email);
    $('#address_form_member input[name="phone"]').val(phone);
    $('#address_form_member textarea#address').val(address);
    $('#address_form_member select#province_id').val(provinsi);

    $('#address_form_member select#province_id').selectpicker('refresh');

    $('#address_form_member').attr('action', base_url+'member/update_address/'+id)
    $('#address_form_member .primary-btn').text(btn)

    if (member==='') {
        $('#address_form_member').attr('action', base_url+'checkout/change_guest_address/'+id);
    }
    $('#address_modal_form').modal('show');
});

$('#address_modal_form').on('hide.bs.modal', () => {
    $('#address_form_member').trigger('reset');
});

$('#agree').change(function (e) {
    e.preventDefault();
    $(this).closest('form').attr('action', base_url+'register_submit');
    if (member!=='') {
        $(this).closest('form').attr('action', base_url+'member/update_profile');
    }
    $(this).closest('form').find(':submit').removeAttr('disabled');
    $(this).closest('form').find(':submit').removeClass('disabled');
    if (!this.checked) {
        $(this).closest('form').attr('action', '');
        $(this).closest('form').find(':submit').attr('disabled', 'disabled');
        $(this).closest('form').find(':submit').addClass('disabled');
    }
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
            case '125' : bata = 6.67; break;
            default : bata = 0;
        }

        let keliling, luas, kebutuhan, kubik, minimum_purchase;

        keliling = 2 * (panjang + lebar);

        luas = keliling * tinggi;

        kebutuhan = luas * bata;

        kubik = kebutuhan / (bata * 10);


        minimum_purchase = 0;
        if (kubik < 10.8 ) {
            minimum_purchase = 10.8;
        }
        if(kubik > 10.8 && kubik < 30) {
            minimum_purchase = 30;
        }

        if (kubik > 30) {
            minimum_purchase = 45.36;
        }

        if (!isNaN(kebutuhan) && !isNaN(kubik)) {
            $('#needs').text(kebutuhan.toFixed(1));
            $('#kubik_needs').text(kubik.toFixed(1));
            $('#minimum_purchase').text(minimum_purchase);
            $('#mortar_needed').text(Math.round(kubik.toFixed(1)));
        }

    }

}

function submit_user_order() {
    $('.submit_order_btn').attr({
        readonly: 'readonly',
        disabled: 'disabled'
    });

    let btn_text = lang=='indonesian'?'Mengirim....':'Sending....';

    $('.submit_order_btn').addClass('disabled');

    $('.submit_order_btn').text(btn_text);

    window.location.href = base_url + 'checkout/submit_order';
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

    if (active_page=='dist') {

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