
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Extension/add';
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
      Extension<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Extension</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
 
   <div class="row" >
      
      <div class="col-md-12">
         <div class="">

            <?php foreach($extensions as $extension): 
            list($cicool, $regid) = explode('/', $extension->path);
            $logo = BASE_ASSET . 'img/icon-80x80.png';
            debug($extension);
            ?>
            <div class="col-md-6 nopadding" style="padding-left: 0px;">
              <div class="box-extension  clearfix">
              <div class="extension-body">
                <div class="col-md-3">
                  <img src="<?= empty($extension->icon) ? $logo :  $extension->icon  ?>" width="90" height="90">
                </div>
                <div class="col-md-6">
                  <div class="extension-title"><a target="blank" href="<?= ('https://github.com/'.$extension->path) ?>"><?= $extension->name ?></a></div>
                  <p><?= $extension->description ?></p>
                  <i>by : <a href="#">Muhamad Ridwan</a></i>
                  <br>
                  <br>
                </div>
                  <div class="col-md-3">
                    <?php 
                    if (in_array($regid, $extension_installed)) {
                      $classUpdate = '';
                      $classInstall = 'style="display:none"';
                    } 
                    else {
                      $classInstall = '';
                      $classUpdate = 'style="display:none"';
                    }?>
                    <a  href="" data-href="<?= site_url('administrator/extension/update?ex='.$extension->path) ?>" class="btn btn-sm btn-default btn-flat pull-right btn-update-extension" <?= $classUpdate ?> >Update Now</a>
                    <a href="" data-href="<?= site_url('administrator/extension/install?ex='.$extension->path) ?>" class="  btn btn-sm btn-default btn-flat pull-right btn-install-extension" <?= $classInstall ?>>Install Now</a>
                    <a href="<?= site_url('administrator/extension/activation?ex='.$regid) ?>" class="  btn btn-sm btn-primary btn-flat pull-right btn-active-extension" <?= $classInstall ?> style="display: none;">Activate</a>
                  </div>
                  <div class="row-fluid">
                    <div class="col-md-12" style="padding: 0px !important">
                      <center>
                        <div class="hide progress-download-extension" style="width: 0%; height: 2px; background: #FF1B1B"></div>
                      </center>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
            </div>
            <?php endforeach ?>


         </div>
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
  $(document).ready(function(){

    $('.btn-install-extension, .btn-update-extension ').click(function(event) {
      event.preventDefault();
      $(this).btnSpinner();

      var btn = $(this);
      var targetUrl = $(this).data('href');

      btn.parentsUntil('.box-extension').find('.progress-download-extension').show();

      btn.parentsUntil('.box-extension').find('.progress-download-extension').animate({
        width: '100%'},
        800, rollOutLoading);

      function rollOutLoading() {
        btn.parentsUntil('.box-extension').find('.progress-download-extension').animate({
          width: '0%'},
          700, rolloverLoading);
      }

      function rolloverLoading() {
        btn.parentsUntil('.box-extension').find('.progress-download-extension').animate({
          width: '100%'},
          800, rollOutLoading);
      }


      $.ajax({
        url: targetUrl,
        dataType: 'JSON',
      })
      .done(function(res) {
        if (res.success) {
          toastr['success']('Success', res.message )
          btn.hide();
          if (btn.hasClass('btn-install-extension')) {
            btn.parentsUntil('.box-extension').find('.btn-active-extension').show();
          } else {
            btn.parentsUntil('.box-extension').find('.btn-update-extension').show();
          }
        } else {
          toastr['warning']('Warning', res.message )
        }
      })
      .fail(function() {
        toastr['warning']('Warning', 'Extension can\'t installed' )
      })
      .always(function() {
        btn.btnSpinner('hide');
        btn.parentsUntil('.box-extension').find('.progress-download-extension').hide();
      });
      
    });

      
   
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
      var serialize_bulk = $('#form_extension').serialize();

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
               document.location.href = BASE_URL + '/administrator/extension/delete?' + serialize_bulk;      
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