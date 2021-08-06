
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
      Projects      <small><?= cclang('detail', ['Projects']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/fastcon_projects'); ?>">Projects</a></li>
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
                     <h3 class="widget-user-username">Projects</h3>
                     <h5 class="widget-user-desc">Detail Projects</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_fastcon_projects" id="form_fastcon_projects" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Category </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->category_name); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> Images </label>
                        <div class="col-sm-8">
                             <?php if (!empty($fastcon_projects->images)): ?>
                             <?php foreach (explode(',', $fastcon_projects->images) as $filename): ?>
                               <?php if (is_image($fastcon_projects->images)): ?>
                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/fastcon_projects/' . $filename; ?>">
                                  <img src="<?= BASE_URL . 'uploads/fastcon_projects/' . $filename; ?>" class="image-responsive" alt="image fastcon_projects" title="images fastcon_projects" width="40px">
                                </a>
                                <?php else: ?>
                                <label>
                                  <a href="<?= BASE_URL . 'administrator/file/download/fastcon_projects/' . $filename; ?>">
                                   <img src="<?= get_icon_file($filename); ?>" class="image-responsive" alt="image fastcon_projects" title="images <?= $filename; ?>" width="40px"> 
                                 <?= $filename ?>
                               </a>
                               </label>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </div>
                    </div>
                                       
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Title </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->title); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Title En </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->title_en); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Slug </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->slug); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Short Desc </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->short_desc); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Short Desc En </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->short_desc_en); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Content </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->content); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Content En </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->content_en); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Featured </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->featured); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Created At </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_projects->created_at); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('fastcon_projects_update', function() use ($fastcon_projects){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit fastcon_projects (Ctrl+e)" href="<?= site_url('administrator/fastcon_projects/edit/'.$fastcon_projects->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Fastcon Projects']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/fastcon_projects/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Fastcon Projects']); ?></a>
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
