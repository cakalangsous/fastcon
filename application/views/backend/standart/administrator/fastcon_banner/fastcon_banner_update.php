
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
        Banner        <small>Edit Banner</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/fastcon_banner'); ?>">Banner</a></li>
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
                            <h3 class="widget-user-username">Banner</h3>
                            <h5 class="widget-user-desc">Edit Banner</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/fastcon_banner/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_fastcon_banner', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_fastcon_banner', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="bg_img" class="col-sm-2 control-label">Bg Img 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_banner_bg_img_galery"></div>
                                <input class="data_file data_file_uuid" name="fastcon_banner_bg_img_uuid" id="fastcon_banner_bg_img_uuid" type="hidden" value="<?= set_value('fastcon_banner_bg_img_uuid'); ?>">
                                <input class="data_file" name="fastcon_banner_bg_img_name" id="fastcon_banner_bg_img_name" type="hidden" value="<?= set_value('fastcon_banner_bg_img_name', $fastcon_banner->bg_img); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> JPG,PNG,JPEG.</small>
                                <small class="info help-block">
                                <b>Recommended Size</b> 1024 x 1024.</small>
                            </div>
                        </div>
                                                  
                                                <div class="form-group ">
                            <label for="fg_img" class="col-sm-2 control-label">Fg Img 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_banner_fg_img_galery"></div>
                                <input class="data_file data_file_uuid" name="fastcon_banner_fg_img_uuid" id="fastcon_banner_fg_img_uuid" type="hidden" value="<?= set_value('fastcon_banner_fg_img_uuid'); ?>">
                                <input class="data_file" name="fastcon_banner_fg_img_name" id="fastcon_banner_fg_img_name" type="hidden" value="<?= set_value('fastcon_banner_fg_img_name', $fastcon_banner->fg_img); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> PNG.</small>
                                <small class="info help-block">
                                <b>Recommended Size</b> 450 x 380.</small>
                            </div>
                        </div>
                                                  
                                                <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label">Title 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title', $fastcon_banner->title); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="title_en" class="col-sm-2 control-label">Title En 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title_en" id="title_en" placeholder="Title En" value="<?= set_value('title_en', $fastcon_banner->title_en); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="caption" class="col-sm-2 control-label">Caption 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="caption" name="caption" rows="5" class="textarea"><?= set_value('caption', $fastcon_banner->caption); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="caption_en" class="col-sm-2 control-label">Caption En 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="caption_en" name="caption_en" rows="5" class="textarea"><?= set_value('caption_en', $fastcon_banner->caption_en); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="primary_btn" class="col-sm-2 control-label">Primary Btn 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="primary_btn" id="primary_btn" placeholder="Primary Btn" value="<?= set_value('primary_btn', $fastcon_banner->primary_btn); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="primary_btn_en" class="col-sm-2 control-label">Primary Btn En 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="primary_btn_en" id="primary_btn_en" placeholder="Primary Btn En" value="<?= set_value('primary_btn_en', $fastcon_banner->primary_btn_en); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="primary_btn_link" class="col-sm-2 control-label">Primary Btn Link 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="primary_btn_link" id="primary_btn_link" placeholder="Primary Btn Link" value="<?= set_value('primary_btn_link', $fastcon_banner->primary_btn_link); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="secondary_btn" class="col-sm-2 control-label">Secondary Btn 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="secondary_btn" id="secondary_btn" placeholder="Secondary Btn" value="<?= set_value('secondary_btn', $fastcon_banner->secondary_btn); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="secondary_btn_en" class="col-sm-2 control-label">Secondary Btn En 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="secondary_btn_en" id="secondary_btn_en" placeholder="Secondary Btn En" value="<?= set_value('secondary_btn_en', $fastcon_banner->secondary_btn_en); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="secondary_btn_link" class="col-sm-2 control-label">Secondary Btn Link 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="secondary_btn_link" id="secondary_btn_link" placeholder="Secondary Btn Link" value="<?= set_value('secondary_btn_link', $fastcon_banner->secondary_btn_link); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
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
              window.location.href = BASE_URL + 'administrator/fastcon_banner';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_fastcon_banner = $('#form_fastcon_banner');
        var data_post = form_fastcon_banner.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_fastcon_banner.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#fastcon_banner_image_galery').find('li').attr('qq-file-id');
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

       $('#fastcon_banner_bg_img_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_banner/upload_bg_img_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/fastcon_banner/delete_bg_img_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/fastcon_banner/get_bg_img_file/<?= $fastcon_banner->id; ?>',
             refreshOnRequest:true
           },
          multiple : false,
          validation: {
              allowedExtensions: ["jpg","png","jpeg"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#fastcon_banner_bg_img_galery').fineUploader('getUuid', id);
                   $('#fastcon_banner_bg_img_uuid').val(uuid);
                   $('#fastcon_banner_bg_img_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#fastcon_banner_bg_img_uuid').val();
                  $.get(BASE_URL + '/administrator/fastcon_banner/delete_bg_img_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#fastcon_banner_bg_img_uuid').val('');
                  $('#fastcon_banner_bg_img_name').val('');
                }
              }
          }
      }); /*end bg_img galey*/
                            var params = {};
       params[csrf] = token;

       $('#fastcon_banner_fg_img_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_banner/upload_fg_img_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/fastcon_banner/delete_fg_img_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/fastcon_banner/get_fg_img_file/<?= $fastcon_banner->id; ?>',
             refreshOnRequest:true
           },
          multiple : false,
          validation: {
              allowedExtensions: ["png"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#fastcon_banner_fg_img_galery').fineUploader('getUuid', id);
                   $('#fastcon_banner_fg_img_uuid').val(uuid);
                   $('#fastcon_banner_fg_img_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#fastcon_banner_fg_img_uuid').val();
                  $.get(BASE_URL + '/administrator/fastcon_banner/delete_fg_img_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#fastcon_banner_fg_img_uuid').val('');
                  $('#fastcon_banner_fg_img_name').val('');
                }
              }
          }
      }); /*end fg_img galey*/
              
       
           
    
    }); /*end doc ready*/
</script>