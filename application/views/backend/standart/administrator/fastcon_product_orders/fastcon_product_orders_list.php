<link rel="stylesheet" href="<?= BASE_ASSET; ?>fastcon/css/custom/custom.css">

<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Fastcon_product_orders/add';
       return false;
   });

   $('*').bind('keydown', 'Ctrl+f', function assets() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {

       $('#reset').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Transactions<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Transactions</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
      
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header ">
                     <div class="row pull-right" id="fastcon_product_ordersBtn">
                                             </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Transactions</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Transactions']); ?>  <i class="label bg-yellow"><?= $fastcon_product_orders_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>
                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable" id="fastcon_product_orders">
                     <thead>
                        <tr class="">
                           <th>Order Code</th>
                           <th>Order Status</th>
                           <th>Action</th>
                           <th>Payer Name</th>
                           <th>Payer Email</th>
                           <th>No Telp</th>
                           <th>Courier Name</th>
                           <th>Courier Phone</th>
                           <th>Created</th>
                           <!-- <th width="250">Action</th> -->
                        </tr>
                     </thead>
                     <tbody id="tbody_fastcon_product_orders">
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>
         <!--/box -->
      </div>
   </div>

   <div class="modal fade" id="courier_modal" tabindex="-1" role="dialog" aria-labelledby="courier_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Send this order?</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">This action can't be cancelled and will update the order status to "Sent".</h5>
                    <h5 class="modal-title">Please enter the courier info below to update the order status.</h5>
                </div>
                <?=form_open('', ['id' => 'courier_info_form', 'method' => 'POST']);?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="courier_name">Courier Name</label>
                            <input type="text" class="form-control" id="courier_name" name="courier_name" placeholder="Enter courier name">
                            <small class="form-text text-danger" id="courier_name_error"></small>
                        </div>

                        <div class="form-group">
                            <label for="courier_name">Courier Phone</label>
                            <input type="number" class="form-control" id="courier_phone" name="courier_phone" placeholder="Enter courier phone">
                            <small class="form-text text-danger" id="courier_phone_error"></small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_courier_info" class="btn btn-success">Send order</button>
                    </div>
                <?=form_close();?>
            </div>
        </div>
    </div>


    <div class="modal fade" id="order_details_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="padding-bottom: 3rem;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Order Details</h4>
                </div>
                <div class="modal-body container" style="margin-bottom: 2rem;">
                    <div id="loading_wrap" style="display: flex; justify-content: center; align-items: center; padding: 3rem 0;">
                        <span class="loading">
                            <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg" style="margin-right: 1rem;"> 
                            <i>Please wait...</i>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom: 3rem;">
                            <h3 class="fastcon-h3" id="order_code"></h3>
                            <h4 class="fastcon-h4" id="order_status"></h4>
                            <h4 class="fastcon-h4 hide" id="courier_info"></h4>
                        </div>
                    </div>
                    <div class="row checkout-wrap">
                        <div class="col-lg-5">
                            <h4 class="fastcon-h4 cl-primary-900 text-uppercase">ORDER ITEMS</h4>
                            <div class="cart-card-wrap"></div>
                        </div>
                        <div class="col-lg-7">
                            <h3 class="fastcon-h3">CHECKOUT INFO</h3>
                            <div class="address-wrap">
                                <div class="address-card"></div>
                            </div>

                            <div class="card-summary">
                                <h4 class="fastcon-h4 cl-primary-900 text-center text-uppercase">ORDER SUMMARY</h4>

                                <div id="product_summary"></div>

                                <div class="line"></div>

                                <div class="card-summary-product-item mb-0">
                                    <div class="product">
                                        <p class="fastcon-description">Subtotal</p>
                                    </div>
                                    <div class="price" id="total">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="card-summary-product-item mb-0">
                                    <div class="product">
                                        <p class="fastcon-description">Tax (10%)</p>
                                    </div>
                                    <div class="price" id="tax">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="card-summary-product-item mb-0">
                                    <div class="product">
                                        <p class="fastcon-description">Delivery Cost</p>
                                    </div>
                                    <div class="price" id="shipping_cost">
                                        <p>-</p>
                                    </div>
                                </div>

                                <div class="card-summary-product-item">
                                    <div class="product">
                                        <p class="fastcon-description">Voucher</p>
                                    </div>
                                    <div class="price" id="voucher_discount">
                                        <p class="cl-error"></p>
                                    </div>
                                </div>
                                <div class="line"></div>

                                <div class="card-summary-product-item">
                                    <div class="product">
                                        <p class="fastcon-description"><b>Total</b></p>
                                    </div>
                                    <div class="price" id="grand_total">
                                        <p><b></b></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
  $(document).ready(function(){

    var table = $('#fastcon_product_orders').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
              "url": "<?= base_url('administrator/fastcon_product_orders/data_ajax');?>",
              "type": "GET"
          },
        language: {
          processing: '<span class="loading"><img src="<?= BASE_ASSET; ?>img/loading-spin-primary.svg"><i style="margin-left:5px;">Loading Data</i></span>',
        },
        dom: 'Blfrtip',
        buttons: 
        [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'colvis',
                text: 'Show / Hide',
                className: 'btn btn-flat btn-success mr-3 text-white'
            }
        ]
    });

    table.buttons().container().appendTo( $('#fastcon_product_ordersBtn') );
   
    $('.remove-data').click(function(){

      var url = $(this).attr('data-href');

      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_fastcon_product_orders').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/fastcon_product_orders/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end appliy click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

  }); /*end doc ready*/
</script>