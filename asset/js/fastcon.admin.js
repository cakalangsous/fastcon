$(document).ready(function($) {
      $(document).on("click", '.send-btn', function(event) { 
          const order_code = $(this).data('order');

          $('#courier_info_form').attr('data-order', order_code);
          $('#courier_modal').modal('show');
      });

      $('#courier_name').keyup(function(e) {
            /* Act on the event */
            $('#courier_name_error').text('');
      });

      $('#courier_phone').keyup(function(e) {
            /* Act on the event */
            $('#courier_phone_error').text('');
      });

      $('#courier_info_form').submit(function(e) {
            /* Act on the event */

            e.preventDefault();

            const url = base_url + '/administrator/fastcon_product_orders/send_order';
            const order_code = $(this).data('order');

            let courier_name = $('#courier_name').val();
            let courier_phone = $('#courier_phone').val();

            if (courier_name == '' ) {
                  $('#courier_name_error').text('Please input the Courier Name');
                  return;
            }

            if (courier_phone == '' ) {
                  $('#courier_phone_error').text('Please input the Courier Phone');
                  return;
            }

            swal({
                  title: "Are you sure?",
                  text: "This action can't be cancelled. You will update the order status to SENT and add the courier info to this order. Don't refresh this page during the process.",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#00a65a",
                  confirmButtonText: "Yes, update this order",
                  cancelButtonText: "Cancel",
                  closeOnConfirm: true,
                  closeOnCancel: true
                },
                function(isConfirm){
                  if (isConfirm) {
                        $('#submit_courier_info').addClass('disabled');
                        $('#submit_courier_info').attr({
                              disabled: true,
                              readOnly: true
                        });

                        $('#submit_courier_info').text('Processing...');

                        $.ajax({
                              url: url,
                              type: 'post',
                              dataType: 'json',
                              data: {[csrf_name]: csrf_val, order_code, courier_name, courier_phone},
                        })
                        .done(function(res) {
                              if (res.success==true) {
                                    location.reload();
                              }
                        });

                  }
            });
      });

      $(document).on("click", '.order-details-btn', function(event) {
            $('.checkout-wrap').hide();

            const order_code = $(this).data('order');

            $.ajax({
                  url: base_url + 'administrator/fastcon_product_orders/order_details/',
                  type: 'POST',
                  dataType: 'json',
                  data: {[csrf_name]: csrf_val, order_code},
            })
            .done(function(res) {
                  let html = '';
                  let address_html = '';
                  let product_summary = '';
                  if (res.success==true) {
                        $.each(res.order, function(index, val) {
                              let img = val.product_images.split(',');
                               html += `<div class="cart-card-item">
                                              <div class="card-img">
                                                  <img src="${base_url}/uploads/fastcon_product/${img[0]}" alt="${val.product_name}" style="max-width: inherit;">
                                              </div>
                                              
                                              <div class="card-desc">
                                                  <h4 class="fastcon-h4">${val.product_name}</h4>
                                                  ${val.discount>0?'<del class="normal-price">Rp '+convert_rupiah(val.price)+'</del>':''}
                                                  <h4 class="fastcon-h4 main-price ${val.discount>0?'cl-error':''}">Rp ${convert_rupiah((val.price-val.discount) * val.qty)}</h4>

                                                  <p class="card-desc-details"><span class="desc-title">${val.product_option1_name_en} </span> ${val.product_option1_value}</p>

                                                  ${val.product_option2_id ? '<p class="card-desc-details"><span class="desc-title">'+val.product_option2_name_en+': </span> '+val.product_option1_value+'</p>': ''}
                                              </div>
                                          </div>`

                              product_summary += `
                                    <div class="card-summary-product-item">
                                        <div class="product">
                                            <p class="fastcon-description">${val.product_name}</p>
                                            <p class="fastcon-description">${val.product_option1_name_en}: ${val.product_option1_value}</p>
                                            ${val.product_option2_id ? '<p class="fastcon-description">'+val.product_option1_name_en+': '+val.product_option1_value+'</p>':''}
                                            <p class="fastcon-description"><b>x${val.qty}</b></p>
                                        </div>
                                        <div class="price">
                                            <p>Rp ${convert_rupiah(val.qty * (val.price-val.discount))}</p>
                                        </div>
                                    </div>
                              `;
                        });

                        address_html += `
                              <p class="receiver-name">${res.order_details.nama_penerima}</p>
                              <p class="receiver-email">${res.order_details.email}</p>
                              <p class="receiver-email">${res.order_details.no_telp}</p>
                              <p class="address">${res.order_details.alamat_lengkap}, ${res.order_details.kelurahan}, ${res.order_details.kecamatan}, ${res.order_details.kabupaten}, ${res.order_details.provinsi}, ${res.order_details.kode_pos}</p>
                        `;
                  }

                  let status = '';
                  typeof(res.order_details.order_status)
                  switch (res.order_details.order_status) {
                        case '2': status = '<span class="label label-primary">Payment Received</span>'; break;
                        case '3': status = '<span class="label label-success">Order Sent</span>'; break;
                        case '4': status = '<span class="label label-danger">Cancelled</span>'; break;
                        default : status = '<span class="label label-warning">New Order</span>'; break;
                  }

                  let courier_name = '';
                  let courier_phone = '';
                  if (res.order_details.courier_name != '') {
                        courier_name = res.order_details.courier_name;
                        courier_phone = res.order_details.courier_phone;

                        $('#courier_info').text(`${courier_name} (${courier_phone})`);
                        $('#courier_info').removeClass('hide');
                  }


                  $('#order_code').text(res.order_details.order_code);
                  $('#order_status').html(status)
                  $('.cart-card-wrap').html(html);
                  $('.address-card').html(address_html);
                  $('#product_summary').html(product_summary);
                  $('#total p').text('Rp' + convert_rupiah(res.order_details.subtotal));
                  $('#tax p').text('Rp' + convert_rupiah(res.order_details.subtotal * 0.1));
                  $('#shipping_cost p').text('Rp' + convert_rupiah(res.order_details.shipping_cost));
                  $('#voucher_discount p').text('- ' + res.order_details.voucher_discount > 0 ? 'Rp' + convert_rupiah(res.voucher_discount):'');
                  $('#grand_total p b').text('Rp' + convert_rupiah(res.order_details.total));

                  $('#loading_wrap').slideUp();
                  $('.checkout-wrap').slideDown();
            });
            $('#order_details_modal').modal('show');
      });

}); // end ready function

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