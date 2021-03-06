
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
      Distributor Province      <small><?= cclang('detail', ['Distributor Province']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/fastcon_distributor_province'); ?>">Distributor Province</a></li>
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
                     <h3 class="widget-user-username">Distributor Province</h3>
                     <h5 class="widget-user-desc">Detail Distributor Province</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_fastcon_distributor_province" id="form_fastcon_distributor_province" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Province Id </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_distributor_province->province_id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Province Name </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_distributor_province->province_name); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Province Name En </label>

                        <div class="col-sm-8">
                           <?= _ent($fastcon_distributor_province->province_name_en); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('fastcon_distributor_province_update', function() use ($fastcon_distributor_province){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit fastcon_distributor_province (Ctrl+e)" href="<?= site_url('administrator/fastcon_distributor_province/edit/'.$fastcon_distributor_province->province_id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Fastcon Distributor Province']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/fastcon_distributor_province/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Fastcon Distributor Province']); ?></a>
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
