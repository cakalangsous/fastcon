
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
        Contact Settings        <small>Edit Contact Settings</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/fastcon_contact_settings'); ?>">Contact Settings</a></li>
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
                            <h3 class="widget-user-username">Contact Settings</h3>
                            <h5 class="widget-user-desc">Edit Contact Settings</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/fastcon_contact_settings/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_fastcon_contact_settings', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_fastcon_contact_settings', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="setting_item" class="col-sm-2 control-label">Setting Item 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <!-- <input type="text" class="form-control" name="setting_item" id="setting_item" placeholder="Setting Item" value="<?= set_value('setting_item', $fastcon_contact_settings->setting_item); ?>"> -->
                                <h5><?=$fastcon_contact_settings->setting_item?></h5>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="setting_value" class="col-sm-2 control-label">Setting Value 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="setting_value" name="setting_value" rows="10" cols="80"> <?= set_value('setting_value', $fastcon_contact_settings->setting_value); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        
                        <?php if ($fastcon_contact_settings->setting_item!='maps'): ?>                        
                            <div class="form-group ">
                                <label for="phone" class="col-sm-2 control-label">Phone 
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?= set_value('phone', $fastcon_contact_settings->phone); ?>">
                                    <?php if ($fastcon_contact_settings->setting_item=='whatsapp'): ?>
                                        <small class="info help-block">
                                        <b>Use extension numbers starting with "+62" ex: +628212345679 </b></small>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endif ?>                         
                                                
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
      
      CKEDITOR.replace('setting_value'); 
      var setting_value = CKEDITOR.instances.setting_value;
                   
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
              window.location.href = BASE_URL + 'administrator/fastcon_contact_settings';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
        $('#setting_value').val(setting_value.getData());
                    
        var form_fastcon_contact_settings = $('#form_fastcon_contact_settings');
        var data_post = form_fastcon_contact_settings.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_fastcon_contact_settings.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#fastcon_contact_settings_image_galery').find('li').attr('qq-file-id');
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