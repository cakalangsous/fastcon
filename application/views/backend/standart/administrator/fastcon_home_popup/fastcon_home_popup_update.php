
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
        Popup        <small>Edit Popup</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/fastcon_home_popup'); ?>">Popup</a></li>
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
                            <h3 class="widget-user-username">Popup</h3>
                            <h5 class="widget-user-desc">Edit Popup</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/fastcon_home_popup/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_fastcon_home_popup', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_fastcon_home_popup', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="popup_title" class="col-sm-2 control-label">Popup Title 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="popup_title" id="popup_title" placeholder="Popup Title" value="<?= set_value('popup_title', $fastcon_home_popup->popup_title); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="popup_title_en" class="col-sm-2 control-label">Popup Title En 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="popup_title_en" id="popup_title_en" placeholder="Popup Title En" value="<?= set_value('popup_title_en', $fastcon_home_popup->popup_title_en); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="body" class="col-sm-2 control-label">Body 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="body" name="body" rows="10" cols="80"> <?= set_value('body', $fastcon_home_popup->body); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="body_en" class="col-sm-2 control-label">Body En 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="body_en" name="body_en" rows="10" cols="80"> <?= set_value('body_en', $fastcon_home_popup->body_en); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="btn_primary_text" class="col-sm-2 control-label">Btn Primary Text 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="btn_primary_text" id="btn_primary_text" placeholder="Btn Primary Text" value="<?= set_value('btn_primary_text', $fastcon_home_popup->btn_primary_text); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="btn_primary_text_en" class="col-sm-2 control-label">Btn Primary Text En 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="btn_primary_text_en" id="btn_primary_text_en" placeholder="Btn Primary Text En" value="<?= set_value('btn_primary_text_en', $fastcon_home_popup->btn_primary_text_en); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="btn_primary_link" class="col-sm-2 control-label">Btn Primary Link 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="btn_primary_link" id="btn_primary_link" placeholder="Btn Primary Link" value="<?= set_value('btn_primary_link', $fastcon_home_popup->btn_primary_link); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="btn_secondary_text" class="col-sm-2 control-label">Btn Secondary Text 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="btn_secondary_text" id="btn_secondary_text" placeholder="Btn Secondary Text" value="<?= set_value('btn_secondary_text', $fastcon_home_popup->btn_secondary_text); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="btn_secondary_text_en" class="col-sm-2 control-label">Btn Secondary Text En 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="btn_secondary_text_en" id="btn_secondary_text_en" placeholder="Btn Secondary Text En" value="<?= set_value('btn_secondary_text_en', $fastcon_home_popup->btn_secondary_text_en); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="btn_secondary_link" class="col-sm-2 control-label">Btn Secondary Link 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="btn_secondary_link" id="btn_secondary_link" placeholder="Btn Secondary Link" value="<?= set_value('btn_secondary_link', $fastcon_home_popup->btn_secondary_link); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="active" class="col-sm-2 control-label">Active 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-6">
                                <div class="col-md-2 padding-left-0">
                                    <label>
                                        <input type="radio" class="flat-red" name="active" id="active"  value="yes" <?= $fastcon_home_popup->active == "yes" ? "checked" : ""; ?>>
                                        Yes
                                    </label>
                                </div>
                                <div class="col-md-14">
                                    <label>
                                        <input type="radio" class="flat-red" name="active" id="active"  value="no" <?= $fastcon_home_popup->active == "no" ? "checked" : ""; ?>>
                                        No
                                    </label>
                                </div>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            
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
      
      CKEDITOR.replace('body'); 
      var body = CKEDITOR.instances.body;
            CKEDITOR.replace('body_en'); 
      var body_en = CKEDITOR.instances.body_en;
                   
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
              window.location.href = BASE_URL + 'administrator/fastcon_home_popup';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
        $('#body').val(body.getData());
                $('#body_en').val(body_en.getData());
                    
        var form_fastcon_home_popup = $('#form_fastcon_home_popup');
        var data_post = form_fastcon_home_popup.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_fastcon_home_popup.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#fastcon_home_popup_image_galery').find('li').attr('qq-file-id');
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
      
       
       
           
    
    }); /*end doc ready*/
</script>