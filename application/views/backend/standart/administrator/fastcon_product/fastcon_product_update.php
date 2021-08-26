
<!-- Fine Uploader Gallery CSS file
    ====================================================================== -->
<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<!-- Fine Uploader jQuery JS file
    ====================================================================== -->
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
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
        Product        <small>Edit Product</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/fastcon_product'); ?>">Product</a></li>
        <li class="active">Edit</li>
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
                            <h3 class="widget-user-username">Product</h3>
                            <h5 class="widget-user-desc">Edit Product</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/fastcon_product/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_fastcon_product', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_fastcon_product', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="product_category" class="col-sm-2 control-label">Product Category 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="product_category" id="product_category" data-placeholder="Select Product Category" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('fastcon_product_category') as $row): ?>
                                    <option <?=  $row->category_id ==  $fastcon_product->product_category ? 'selected' : ''; ?> value="<?= $row->category_id ?>"><?= $row->category_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="product_name" class="col-sm-2 control-label">Product Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?= set_value('product_name', $fastcon_product->product_name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="product_slug" class="col-sm-2 control-label">Product Slug 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="product_slug" id="product_slug" placeholder="Product Slug" value="<?= set_value('product_slug', $fastcon_product->product_slug); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="product_images" class="col-sm-2 control-label">Product Images 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_product_product_images_galery"></div>
                                <div id="fastcon_product_product_images_galery_listed">
                                <?php foreach ((array) explode(',', $fastcon_product->product_images) as $idx => $filename): ?>
                                    <input type="hidden" class="listed_file_uuid" name="fastcon_product_product_images_uuid[<?= $idx ?>]" value="" /><input type="hidden" class="listed_file_name" name="fastcon_product_product_images_name[<?= $idx ?>]" value="<?= $filename; ?>" />
                                <?php endforeach; ?>
                                </div>
                                <small class="info help-block">
                                <b>Extension file must</b> JPG,JPEG,PNG.</small>
                                <small class="info help-block">
                                <b>Recommended Size</b> 350 x 350.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="product_desc" class="col-sm-2 control-label">Product Desc 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="product_desc" name="product_desc" rows="10" cols="80"> <?= set_value('product_desc', $fastcon_product->product_desc); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="spec" class="col-sm-2 control-label">Spec 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_product_spec_galery"></div>
                                <input class="data_file data_file_uuid" name="fastcon_product_spec_uuid" id="fastcon_product_spec_uuid" type="hidden" value="<?= set_value('fastcon_product_spec_uuid'); ?>">
                                <input class="data_file" name="fastcon_product_spec_name" id="fastcon_product_spec_name" type="hidden" value="<?= set_value('fastcon_product_spec_name', $fastcon_product->spec); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> JPG,JPEG,PNG.</small>
                                <small class="info help-block">
                                <b>Recommended Size</b> 900 x 300.</small>
                            </div>
                        </div>
                                                  
                                                <div class="form-group ">
                            <label for="cara_pasang" class="col-sm-2 control-label">Cara Pasang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_product_cara_pasang_galery"></div>
                                <input class="data_file data_file_uuid" name="fastcon_product_cara_pasang_uuid" id="fastcon_product_cara_pasang_uuid" type="hidden" value="<?= set_value('fastcon_product_cara_pasang_uuid'); ?>">
                                <input class="data_file" name="fastcon_product_cara_pasang_name" id="fastcon_product_cara_pasang_name" type="hidden" value="<?= set_value('fastcon_product_cara_pasang_name', $fastcon_product->cara_pasang); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> JPG,JPEG,PNG.</small>
                                <small class="info help-block">
                                <b>Recommended Size</b> 900 x 300.</small>
                            </div>
                        </div>
                                                  
                                                <div class="form-group ">
                            <label for="certificate" class="col-sm-2 control-label">Certificate 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_product_certificate_galery"></div>
                                <input class="data_file data_file_uuid" name="fastcon_product_certificate_uuid" id="fastcon_product_certificate_uuid" type="hidden" value="<?= set_value('fastcon_product_certificate_uuid'); ?>">
                                <input class="data_file" name="fastcon_product_certificate_name" id="fastcon_product_certificate_name" type="hidden" value="<?= set_value('fastcon_product_certificate_name', $fastcon_product->certificate); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> JPG,JPEG,PNG.</small>
                                <small class="info help-block">
                                <b>Recommended Size</b> 900 x 300.</small>
                            </div>
                        </div>
                                                 
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
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
<script src="<?= BASE_ASSET; ?>ckeditor/ckeditor.js"></script>
<!-- Page script -->
<script>
    $(document).ready(function(){
      
      CKEDITOR.replace('product_desc'); 
      var product_desc = CKEDITOR.instances.product_desc;
                   
      $('#btn_cancel').click(function(){
        swal({
            title: "Are you sure?",
            text: "the data that you have created will be in the exhaust!",
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
              window.location.href = BASE_URL + 'administrator/fastcon_product';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
        $('#product_desc').val(product_desc.getData());
                    
        var form_fastcon_product = $('#form_fastcon_product');
        var data_post = form_fastcon_product.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_fastcon_product.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#fastcon_product_image_galery').find('li').attr('qq-file-id');
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            $('.data_file_uuid').val('');
    
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
      
                     var params = {};
       params[csrf] = token;

       $('#fastcon_product_spec_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_product/upload_spec_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/fastcon_product/delete_spec_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/fastcon_product/get_spec_file/<?= $fastcon_product->product_id; ?>',
             refreshOnRequest:true
           },
          multiple : false,
          validation: {
              allowedExtensions: ["jpg","jpeg","png"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#fastcon_product_spec_galery').fineUploader('getUuid', id);
                   $('#fastcon_product_spec_uuid').val(uuid);
                   $('#fastcon_product_spec_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#fastcon_product_spec_uuid').val();
                  $.get(BASE_URL + '/administrator/fastcon_product/delete_spec_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#fastcon_product_spec_uuid').val('');
                  $('#fastcon_product_spec_name').val('');
                }
              }
          }
      }); /*end spec galey*/
                            var params = {};
       params[csrf] = token;

       $('#fastcon_product_cara_pasang_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_product/upload_cara_pasang_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/fastcon_product/delete_cara_pasang_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/fastcon_product/get_cara_pasang_file/<?= $fastcon_product->product_id; ?>',
             refreshOnRequest:true
           },
          multiple : false,
          validation: {
              allowedExtensions: ["jpg","jpeg","png"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#fastcon_product_cara_pasang_galery').fineUploader('getUuid', id);
                   $('#fastcon_product_cara_pasang_uuid').val(uuid);
                   $('#fastcon_product_cara_pasang_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#fastcon_product_cara_pasang_uuid').val();
                  $.get(BASE_URL + '/administrator/fastcon_product/delete_cara_pasang_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#fastcon_product_cara_pasang_uuid').val('');
                  $('#fastcon_product_cara_pasang_name').val('');
                }
              }
          }
      }); /*end cara_pasang galey*/
                            var params = {};
       params[csrf] = token;

       $('#fastcon_product_certificate_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_product/upload_certificate_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/fastcon_product/delete_certificate_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/fastcon_product/get_certificate_file/<?= $fastcon_product->product_id; ?>',
             refreshOnRequest:true
           },
          multiple : false,
          validation: {
              allowedExtensions: ["jpg","jpeg","png"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#fastcon_product_certificate_galery').fineUploader('getUuid', id);
                   $('#fastcon_product_certificate_uuid').val(uuid);
                   $('#fastcon_product_certificate_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#fastcon_product_certificate_uuid').val();
                  $.get(BASE_URL + '/administrator/fastcon_product/delete_certificate_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#fastcon_product_certificate_uuid').val('');
                  $('#fastcon_product_certificate_name').val('');
                }
              }
          }
      }); /*end certificate galey*/
              
       
              var params = {};
       params[csrf] = token;

       $('#fastcon_product_product_images_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_product/upload_product_images_file',
              params : params
          },
          deleteFile: {
              enabled: true, 
              endpoint: BASE_URL + '/administrator/fastcon_product/delete_product_images_file',
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/fastcon_product/get_product_images_file/<?= $fastcon_product->product_id; ?>',
             refreshOnRequest:true
           },
          validation: {
              allowedExtensions: ["jpg","jpeg","png"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#fastcon_product_product_images_galery').fineUploader('getUuid', id);
                   $('#fastcon_product_product_images_galery_listed').append('<input type="hidden" class="listed_file_uuid" name="fastcon_product_product_images_uuid['+id+']" value="'+uuid+'" /><input type="hidden" class="listed_file_name" name="fastcon_product_product_images_name['+id+']" value="'+xhr.uploadName+'" />');
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#fastcon_product_product_images_galery_listed').find('.listed_file_uuid[name="fastcon_product_product_images_uuid['+id+']"]').remove();
                  $('#fastcon_product_product_images_galery_listed').find('.listed_file_name[name="fastcon_product_product_images_name['+id+']"]').remove();
                }
              }
          }
      }); /*end product_images galery*/
                  
    
    }); /*end doc ready*/
</script>