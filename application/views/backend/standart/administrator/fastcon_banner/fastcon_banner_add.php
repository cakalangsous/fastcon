
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
        Banner        <small><?= cclang('new', ['Banner']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/fastcon_banner'); ?>">Banner</a></li>
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
                            <h3 class="widget-user-username">Banner</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Banner']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_fastcon_banner', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_fastcon_banner', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="bg_img" class="col-sm-2 control-label">Bg Img 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_banner_bg_img_galery"></div>
                                <input class="data_file" name="fastcon_banner_bg_img_uuid" id="fastcon_banner_bg_img_uuid" type="hidden" value="<?= set_value('fastcon_banner_bg_img_uuid'); ?>">
                                <input class="data_file" name="fastcon_banner_bg_img_name" id="fastcon_banner_bg_img_name" type="hidden" value="<?= set_value('fastcon_banner_bg_img_name'); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> JPG,PNG,JPEG.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="fg_img" class="col-sm-2 control-label">Fg Img 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="fastcon_banner_fg_img_galery"></div>
                                <input class="data_file" name="fastcon_banner_fg_img_uuid" id="fastcon_banner_fg_img_uuid" type="hidden" value="<?= set_value('fastcon_banner_fg_img_uuid'); ?>">
                                <input class="data_file" name="fastcon_banner_fg_img_name" id="fastcon_banner_fg_img_name" type="hidden" value="<?= set_value('fastcon_banner_fg_img_name'); ?>">
                                <small class="info help-block">
                                <b>Extension file must</b> PNG.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label">Title 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="title_en" class="col-sm-2 control-label">Title En 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title_en" id="title_en" placeholder="Title En" value="<?= set_value('title_en'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="caption" class="col-sm-2 control-label">Caption 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="caption" name="caption" rows="5" class="textarea"><?= set_value('caption'); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="caption_en" class="col-sm-2 control-label">Caption En 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="caption_en" name="caption_en" rows="5" class="textarea"><?= set_value('caption_en'); ?></textarea>
                                <small class="info help-block">
                                </small>
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
<!-- Page script -->
<script>
    $(document).ready(function(){
                   
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
          url: BASE_URL + '/administrator/fastcon_banner/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id_bg_img = $('#fastcon_banner_bg_img_galery').find('li').attr('qq-file-id');
            var id_fg_img = $('#fastcon_banner_fg_img_galery').find('li').attr('qq-file-id');
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            if (typeof id_bg_img !== 'undefined') {
                    $('#fastcon_banner_bg_img_galery').fineUploader('deleteFile', id_bg_img);
                }
            if (typeof id_fg_img !== 'undefined') {
                    $('#fastcon_banner_fg_img_galery').fineUploader('deleteFile', id_fg_img);
                }
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
      
              var params = {};
       params[csrf] = token;

       $('#fastcon_banner_bg_img_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_banner/upload_bg_img_file',
              params : params
          },
          deleteFile: {
              enabled: true, 
              endpoint: BASE_URL + '/administrator/fastcon_banner/delete_bg_img_file',
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
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
      }); /*end bg_img galery*/
                     var params = {};
       params[csrf] = token;

       $('#fastcon_banner_fg_img_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/fastcon_banner/upload_fg_img_file',
              params : params
          },
          deleteFile: {
              enabled: true, 
              endpoint: BASE_URL + '/administrator/fastcon_banner/delete_fg_img_file',
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
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
      }); /*end fg_img galery*/
              
 
       
    
    
    }); /*end doc ready*/
</script>