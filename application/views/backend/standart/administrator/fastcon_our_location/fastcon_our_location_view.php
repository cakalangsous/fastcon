
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+e', function assets() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
       return false;
   });
    
}


jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Our Location      <small><?= cclang('detail', ['Our Location']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/fastcon_our_location'); ?>">Our Location</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
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
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Our Location</h3>
                     <h5 class="widget-user-desc">Detail Our Location</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_fastcon_our_location" id="form_fastcon_our_location" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_our_location->id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> Image </label>
                        <div class="col-sm-8">
                             <?php if (is_image($fastcon_our_location->image)): ?>
                              <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/fastcon_our_location/' . $fastcon_our_location->image; ?>">
                                <img src="<?= BASE_URL . 'uploads/fastcon_our_location/' . $fastcon_our_location->image; ?>" class="image-responsive" alt="image fastcon_our_location" title="image fastcon_our_location" width="40px">
                              </a>
                              <?php else: ?>
                              <label>
                                <a href="<?= BASE_URL . 'administrator/file/download/fastcon_our_location/' . $fastcon_our_location->image; ?>">
                                 <img src="<?= get_icon_file($fastcon_our_location->image); ?>" class="image-responsive" alt="image fastcon_our_location" title="image <?= $fastcon_our_location->image; ?>" width="40px"> 
                               <?= $fastcon_our_location->image ?>
                               </a>
                               </label>
                              <?php endif; ?>
                        </div>
                    </div>
                                      
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('fastcon_our_location_update', function() use ($fastcon_our_location){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit fastcon_our_location (Ctrl+e)" href="<?= site_url('administrator/fastcon_our_location/edit/'.$fastcon_our_location->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Fastcon Our Location']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/fastcon_our_location/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Fastcon Our Location']); ?></a>
                     </div>
                    
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->

      </div>
   </div>
</section>
<!-- /.content -->
