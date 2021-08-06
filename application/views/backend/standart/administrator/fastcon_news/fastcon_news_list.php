
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Fastcon_news/add';
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
      News<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">News</li>
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
                     <div class="row pull-right" id="fastcon_newsBtn">
                        <?php is_allowed('fastcon_news_add', function(){?>
                        <a class="btn btn-flat btn-success btn_add_new mr-3" id="btn_add_new" title="<?= cclang('add_new_button', ['Fastcon News']); ?>  (Ctrl+a)" href="<?=  site_url('administrator/fastcon_news/add'); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_new_button', ['Fastcon News']); ?></a>
                        <?php }) ?>
                                             </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">News</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['News']); ?>  <i class="label bg-yellow"><?= $fastcon_news_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>
                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable" id="fastcon_news">
                     <thead>
                        <tr class="">
                           <th>Image</th>
                           <th>Title</th>
                           <th>Title En</th>
                           <th>Slug</th>
                           <th>Content</th>
                           <th>Content En</th>
                           <th>Created At</th>
                           <th width="250">Action</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_fastcon_news">
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>
         <!--/box -->
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
  $(document).ready(function(){

    var table = $('#fastcon_news').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
              "url": "<?= base_url('administrator/fastcon_news/data_ajax');?>",
              "type": "GET"
          },
        language: {
          processing: '<span class="loading"><img src="<?= BASE_ASSET; ?>img/loading-spin-primary.svg"><i style="margin-left:5px;">Loading Data</i></span>',
        },
        dom: 'Blfrtip',
        buttons: 
        [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                className: 'btn btn-flat btn-success mr-3 text-white'
            },
            {
                extend: 'colvis',
                text: 'Show / Hide',
                className: 'btn btn-flat btn-success mr-3 text-white'
            }
        ]
    });

    table.buttons().container().appendTo( $('#fastcon_newsBtn') );
   
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
      var serialize_bulk = $('#form_fastcon_news').serialize();

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
               document.location.href = BASE_URL + '/administrator/fastcon_news/delete?' + serialize_bulk;      
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