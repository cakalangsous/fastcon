
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
    function domo(){
     
       // Binding keys
       $('*').bind('keydown', 'Ctrl+s', function assets() {
          $('#btn_save').trigger('click');
           return false;
       });
    
       $('*').bind('keydown', 'Ctrl+x', function assets() {
          $('#btn_cancel').trigger('click');
           return false;
       });
    
      $('*').bind('keydown', 'Ctrl+d', function assets() {
          $('.btn_save_back').trigger('click');
           return false;
       });
        
    }
    
    jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Product Variant        <small><?= cclang('new', ['Product Variant']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/fastcon_product_variant'); ?>">Product Variant</a></li>
        <li class="active"><?= cclang('new'); ?></li>
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
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">Product Variant</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Product Variant']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_fastcon_product_variant', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_fastcon_product_variant', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="product_id" class="col-sm-2 control-label">Product 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="product_id" id="product_id" data-placeholder="Select Product" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('fastcon_product') as $row): ?>
                                    <option value="<?= $row->product_id ?>"><?= $row->product_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                        <div class="form-group ">
                            <label for="product_option1" class="col-sm-2 control-label">Product Option1 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" id="product_option1" data-placeholder="Select Product Option1" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('fastcon_product_option') as $row): ?>
                                    <option value="<?= $row->product_type_id ?>"><?= $row->product_option_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                        <div class="form-group" id="product_option_value1_wrap">
                            <label for="product_option_value1" class="col-sm-2 control-label">Product Option Value1 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8 mb-3">
                                <select  class="form-control chosen chosen-select" multiple id="product_option_value1" data-placeholder="Select Product Option Value1" multiple >
                                </select>
                                <small class="info help-block">
                                </small>

                                <button type="button" id="add_variant" class="btn btn-primary"><i class="fa fa-plus"></i> Add Variant</button>
                                <button type="button" class="btn btn-success done"><i class="fa fa-check"></i> Done</button>
                            </div>
                        </div>
                                                 
                        <div class="form-group" id="product_option2_wrap" >
                            <label for="product_option2" class="col-sm-2 control-label">Product Option2 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" id="product_option2" data-placeholder="Select Product Option2" >
                                    <option value=""></option>
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                        <div class="form-group" id="product_option_value2_wrap">
                            <label for="product_option_value2" class="col-sm-2 control-label">Product Option Value2 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" multiple id="product_option_value2" data-placeholder="Select Product Option Value2" >
                                </select>
                                <small class="info help-block">
                                </small>

                                <button type="button" id="remove_variant" class="btn btn-danger"><i class="fa fa-trash"></i> Remove Variant</button>
                                <button type="button" class="btn btn-success done"><i class="fa fa-check"></i> Done</button>
                            </div>
                        </div>

                                                 
                        <div class="form-group hidden">
                            <label for="sku" class="col-sm-2 control-label">Sku 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" id="sku" placeholder="Sku" value="<?= set_value('sku'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                        <div class="form-group p-3">
                            <div class="col-sm-12">
                                <table class="table table-stripped hide" id="variant_table">
                                    <thead>
                                        <tr>
                                            <th>Use</th>
                                            <th id="product_option1_th"></th>
                                            <th id="product_option2_th"></th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>

                                </table>
                            </div>
                        </div>
                                                
                        <div class="message"></div>
                        <div class="row-fluid col-md-7 hide" id="btn_wrap">
                           <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                            <i class="ion ion-ios-list-outline" ></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                            <i class="fa fa-undo" ></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                            <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg"> 
                            <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>
<!-- /.content -->
<!-- Page script -->
<script>
    $(document).ready(function(){

        $('#product_option2').attr('disabled', 'disabled');
        $('#product_option_value2').attr('disabled', 'disabled');

        $('#product_option_value1_wrap').hide();
        $('#product_option2_wrap').hide();
        $('#product_option_value2_wrap').hide();
        $('.done').hide();
        $('#variant_table').addClass('hide');


        $('select').change(function (e) {
            e.preventDefault();

            $('#variant_table').addClass('hide');
            $('#variant_table').slideUp(300);
        });

        $('#product_option1').change(function (e) {
            e.preventDefault();

            $('#product_option2').attr('disabled', 'disabled');
            $('#product_option_value2').attr('disabled', 'disabled');
            $('#product_option2').val('');
            $('#product_option_value2').val('');

            $('#product_option_value1_wrap').hide();
            $('#product_option2_wrap').hide();
            $('#product_option_value2').hide();
            $('#product_option_value2_wrap').hide();
            $('.done').hide();

            $('#variant_table').addClass('hide');
            $('#variant_table').slideUp(300);

            let option = $(this).val();

            $.ajax({
                url: '<?=site_url('administrator/fastcon_product_variant/get_option_value')?>',
                type: 'post',
                dataType: 'json',
                data: {[csrf_name]:csrf_val, option},
            })
            .done(function(res) {

                let html = '';
                if (res.status!==true) {
                    swal({
                        title: 'Option value not found',
                        text: 'Selected option value not found',
                        icon: 'error'
                    });

                    return;
                }
                $.each(res.data, function(index, val) {
                    html += `<option value="${val.option_value_id}">${val.option_value}</option>`;
                });

                $('#product_option_value1').html(html).trigger("chosen:updated");
                $('.chosen-container').css('width', '100%');
                $('#product_option_value1_wrap').slideDown(300);
            });
            
        });

        $('#product_option_value1').change(function (e) {
            e.preventDefault();

            let option_value = $(this).val();
            let option2 = $('#product_option2').val();

            if (option_value!='' && option2=='') {
                $('.done').show(300);
            }else {
                $('.done').first().hide(300);
            }
        });


        $('#add_variant').click(function (e) {
            e.preventDefault();


            const option1 = $('#product_option1').val();

            $('.done').first().hide();
            $('#variant_table').addClass('hide');

            $.ajax({
                url: '<?=site_url('administrator/fastcon_product_variant/get_option2')?>',
                type: 'post',
                dataType: 'json',
                data: {[csrf_name]:csrf_val, option1},
            })
            .done(function(res) {
                if (res.status!==true) {
                    swal({
                        title: 'Option not found',
                        text: 'Something went wrong! Option not found!',
                        icon: 'error'
                    });

                    return;
                }

                let html = '<option value=""></option>';

                $.each(res.data, function(index, val) {
                    html += `<option value="${val.product_type_id}">${val.product_option_name}</option>`;
                });

                $('#product_option2').html(html).trigger("chosen:updated");
                $('.chosen-container').css('width', '100%');
            });
            

            $('#product_option2').removeAttr('disabled').trigger('chosen:updated');
            $('#product_option2_wrap').slideDown(300);
        });

        $('#product_option2').change(function (e) {
            e.preventDefault();
            $('#product_option_value2').removeAttr('disabled');
            $('#variant_table').addClass('hide');
            $('#variant_table').slideUp(300);
            $('.done').hide();

            let option = $(this).val();

            $.ajax({
                url: '<?=site_url('administrator/fastcon_product_variant/get_option_value')?>',
                type: 'post',
                dataType: 'json',
                data: {[csrf_name]:csrf_val, option},
            })
            .done(function(res) {

                let html = '<option value=""></option>';
                if (res.status!==true) {
                    swal({
                        title: 'Option value not found',
                        text: 'Selected option value not found',
                        icon: 'error'
                    });

                    return;
                }
                $.each(res.data, function(index, val) {
                    html += `<option value="${val.option_value_id}">${val.option_value}</option>`;
                });

                $('#product_option_value2').html(html).trigger("chosen:updated");
                $('.chosen-container').css('width', '100%');
                $('#product_option_value2_wrap').slideDown(300);
            });
        });

        $('#product_option_value2').change(function (e) {
            e.preventDefault();

            let option_value = $(this).val();

            if (option_value!='') {
                $('.done').last().show(300);
            }else {
                $('.done').hide(300);
            }
        });



        $('#remove_variant').click(function (e) {
            e.preventDefault();

            $('#product_option2').attr('disabled', 'disabled');
            $('#product_option_value2').attr('disabled', 'disabled');

            $('#product_option2_wrap').hide(300);
            $('#product_option_value2_wrap').hide(300);
            $('#product_option2').hide(300);
            $('#product_option_value2').hide(300);
            $('.done').first().show(300);
            $('#variant_table').addClass('hide');
        });



        $('.done').click(function (e) {
            e.preventDefault();

            $(this).attr('disabled', 'disabled');
            $(this).html('<i class="fa fa-spinner"></i> Please wait...');


            let option1 = $('#product_option1').val();
            let option_value1 = $('#product_option_value1').val();
            let option_value2 = $('#product_option_value2').val();

            let send_data2 = false;
            if (option_value2) {
                send_data2 = option_value2;
            }


            let option1_text = $('#product_option1 option:selected').text();
            let option2_text = $('#product_option2 option:selected').text();

            $('#product_option1_th').text(option1_text);

            if (option2_text=='') {
                $('#product_option2_th').hide();
            }else{
                $('#product_option2_th').show();
                $('#product_option2_th').text(option2_text);
            }


            $.ajax({
                url: '<?=site_url('administrator/fastcon_product_variant/get_option_text')?>',
                type: 'post',
                dataType: 'html',
                data: {[csrf_name]:csrf_val, option_value1, option_value2:send_data2},
            })
            .done(function(res) {
                $('#variant_table tbody').html(res);

                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
            });

            $(this).html('<i class="fa fa-check"></i> Done');
            $(this).removeAttr('disabled');

            $('#variant_table').removeClass('hide');
            $('#variant_table').slideDown(300);

            $('#btn_wrap').removeClass('hide');
            $('#btn_wrap').slideDown(300)
        });








        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });


        let checkboxes = $(document);

        $('#check_all').on('ifChecked ifUnchecked', function(event) {

            console.log('asdf');
            if (event.type == 'ifChecked') {
                checkboxes.iCheck('check');
            } else {
                checkboxes.iCheck('uncheck');
            }
        });
                   
      $('#btn_cancel').click(function(){
        swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = BASE_URL + 'administrator/fastcon_product_variant';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_fastcon_product_variant = $('#form_fastcon_product_variant');
        var data_post = form_fastcon_product_variant.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/fastcon_product_variant/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function() {
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 2000);
        });
    
        return false;
      }); /*end btn save*/
      
       
 
       
    
    
    }); /*end doc ready*/
</script>