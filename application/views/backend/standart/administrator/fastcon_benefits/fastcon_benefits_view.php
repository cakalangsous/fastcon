
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
      Benefits      <small><?= cclang('detail', ['Benefits']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/fastcon_benefits'); ?>">Benefits</a></li>
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
                     <h3 class="widget-user-username">Benefits</h3>
                     <h5 class="widget-user-desc">Detail Benefits</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_fastcon_benefits" id="form_fastcon_benefits" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_benefits->id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> Image </label>
                        <div class="col-sm-8">
                             <?php if (is_image($fastcon_benefits->image)): ?>
                              <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/fastcon_benefits/' . $fastcon_benefits->image; ?>">
                                <img src="<?= BASE_URL . 'uploads/fastcon_benefits/' . $fastcon_benefits->image; ?>" class="image-responsive" alt="image fastcon_benefits" title="image fastcon_benefits" width="40px">
                              </a>
                              <?php else: ?>
                              <label>
                                <a href="<?= BASE_URL . 'administrator/file/download/fastcon_benefits/' . $fastcon_benefits->image; ?>">
                                 <img src="<?= get_icon_file($fastcon_benefits->image); ?>" class="image-responsive" alt="image fastcon_benefits" title="image <?= $fastcon_benefits->image; ?>" width="40px"> 
                               <?= $fastcon_benefits->image ?>
                               </a>
                               </label>
                              <?php endif; ?>
                        </div>
                    </div>
                                       
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Title </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_benefits->title); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Title En </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_benefits->title_en); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Caption </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_benefits->caption); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Caption En </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_benefits->caption_en); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('fastcon_benefits_update', function() use ($fastcon_benefits){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit fastcon_benefits (Ctrl+e)" href="<?= site_url('administrator/fastcon_benefits/edit/'.$fastcon_benefits->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Fastcon Benefits']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/fastcon_benefits/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Fastcon Benefits']); ?></a>
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