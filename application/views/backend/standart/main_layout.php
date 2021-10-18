<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="description" content="<?= get_option('site_description'); ?>">

  <meta name="keywords" content="<?= get_option('keywords'); ?>">

  <meta name="author" content="<?= get_option('author'); ?>">



  <title><?= get_option('site_name'); ?> | <?= $template['title']; ?></title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <link rel="icon" href="<?=BASE_ASSET?>logo/<?= get_option('site_favicon'); ?>">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/dist/css/AdminLTE.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/dist/css/skins/<?=get_option('skin')?>.min.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/iCheck/flat/blue.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/morris/morris.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/datepicker/datepicker3.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/iCheck/all.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/sweet-alert/sweetalert.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/toastr/build/toastr.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/fancy-box/source/jquery.fancybox.css?v=2.1.5" media="screen" />

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/chosen/chosen.css">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/css/custom.css?timestamp=201803311526">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>datetimepicker/jquery.datetimepicker.css"/>

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>dataTables/datatables.min.css"/>

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>dataTables/buttons/css/buttons.dataTables.min.css"/>

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>js-scroll/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" />

  <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <?= $this->cc_html->getCssFileTop(); ?>



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->



  <script src="<?= BASE_ASSET; ?>/admin-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>

  <script src="<?= BASE_ASSET; ?>dataTables/datatables.min.js"></script>

  <script src="<?= BASE_ASSET; ?>dataTables/buttons/js/dataTables.buttons.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

  <script src="<?= BASE_ASSET; ?>dataTables/buttons/js/buttons.print.min.js"></script>

  <script src="<?= BASE_ASSET; ?>dataTables/buttons/js/buttons.html5.min.js"></script>

  <script src="<?= BASE_ASSET; ?>/sweet-alert/sweetalert-dev.js"></script>

  <script src="<?= BASE_ASSET; ?>/admin-lte/plugins/input-mask/jquery.inputmask.js"></script>

  <script src="<?= BASE_ASSET; ?>/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>

  <script src="<?= BASE_ASSET; ?>/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <script src="<?= BASE_ASSET; ?>/toastr/toastr.js"></script>

  <script src="<?= BASE_ASSET; ?>/fancy-box/source/jquery.fancybox.js?v=2.1.5"></script>

  <script src="<?= BASE_ASSET; ?>/editor/dist/js/medium-editor.js"></script>

  <script src="<?= BASE_ASSET; ?>js/cc-extension.js"></script>

  <script src="<?= BASE_ASSET; ?>/js/cc-page-element.js"></script>

  <script src="<?= BASE_ASSET; ?>/datetimepicker/build/jquery.datetimepicker.full.js"></script>

  <script src="<?= BASE_ASSET; ?>/admin-lte/plugins/iCheck/icheck.min.js"></script>

  <script>

    var BASE_URL = "<?= base_url(); ?>";

    var HTTP_REFERER = "<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/' ; ?>";

    var csrf = '<?= $this->security->get_csrf_token_name(); ?>';

    var token = '<?= $this->security->get_csrf_hash(); ?>';



    $(document).ready(function(){



      toastr.options = {

        "positionClass": "toast-top-center",

      }



      var f_message = '<?= $this->session->flashdata('f_message'); ?>';

      var f_type = '<?= $this->session->flashdata('f_type'); ?>';



      if (f_message.length > 0) {

        toastr[f_type](f_message);

      }



      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

        checkboxClass: 'icheckbox_minimal-red',

        radioClass: 'iradio_minimal-red'

      });

    });

  </script>

  <?= $this->cc_html->getScriptFileTop(); ?>

</head>

<body class="sidebar-mini <?=get_option('skin')?> fixed web-body">

<div class="wrapper">



  <header class="main-header">

    <a href="<?= site_url('administrator/dashboard'); ?>" class="logo">

      <!-- <span class="logo-mini"><b>A</b>LT</span> -->

      <span class="logo-mini"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo_small'); ?>" alt="<?= get_option('site_name'); ?>"></span>

      <span class="logo-lg"><b><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" alt="<?= get_option('site_name'); ?>"></b></span>

    </a>

    <nav class="navbar navbar-static-top">



      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

        <span class="sr-only">Toggle navigation</span>

      </a>



      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">



          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <img src="<?= BASE_URL.'uploads/user/'.(!empty(get_user_data('avatar')) ? get_user_data('avatar') :'default.png'); ?>" class="user-image" alt="User Image">

              <span class="hidden-xs"><?= _ent(ucwords(clean_snake_case(get_user_data('full_name')))); ?></span>

            </a>

            <ul class="dropdown-menu">

              <li class="user-header">

                <img src="<?= BASE_URL.'uploads/user/'.(!empty(get_user_data('avatar')) ? get_user_data('avatar') :'default.png'); ?>" class="img-circle" alt="User Image">



                <p>

                  <?= _ent(ucwords(clean_snake_case($this->aauth->get_user()->full_name))); ?> 

                  <small>Last Login, <?= date('Y-M-D', strtotime(get_user_data('last_login'))); ?></small>

                </p>

              </li>

              

              <li class="user-footer">

                <div class="pull-left">

                  <a href="<?= site_url('administrator/user/profile'); ?>" class="btn btn-default btn-flat"><?= cclang('profile'); ?></a>

                </div>

                <div class="pull-right">

                  <a href="<?= site_url('administrator/auth/logout'); ?>" class="btn btn-default btn-flat"><?= cclang('sign_out'); ?></a>

                </div>

              </li>

            </ul>

          </li>

          <!-- <li class="dropdown ">

             <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

             <span class="flag-icon <?= get_current_initial_lang(); ?>"></span> <?= get_current_lang(); ?> </a>

             <ul class="dropdown-menu" role="menu">

             <?php foreach (get_langs() as $lang): ?>

                <li><a href="<?= site_url('web/switch_lang/'.$lang['folder_name']); ?>"><span class="flag-icon <?= $lang['icon_name']; ?>"></span> <?= $lang['name']; ?></a></li>

              <?php endforeach; ?>

             </ul>

          </li> -->

        </ul>

      </div>

    </nav>

  </header>

  <aside class="main-sidebar">



    <section class="sidebar" style="padding-top:0% !important">

      <ul class="sidebar-menu  sidebar-admin tree"  data-widget="tree">

        

        <?= display_menu_admin(0, 1); ?>

      </ul>

    </section>



  </aside>



  <div class="content-wrapper">

    <?php cicool()->eventListen('backend_content_top'); ?>

    <?= $template['partials']['content']; ?>

    <?php cicool()->eventListen('backend_content_bottom'); ?>

  </div>



  <footer class="main-footer">

    <div class="pull-right hidden-xs">

      <b><?= cclang('version') ?></b> <?php $ver = $this->config->load('site'); echo $this->config->item('version') ?>

    </div>

    <strong>Copyright &copy; <?=date('Y'); ?> <a href="<?=site_url()?>"><?= get_option('site_name'); ?></a>.</strong> All rights

    reserved.

  </footer>

  

  <div class="control-sidebar-bg"></div>

</div>



<?= $this->cc_html->getCssFileBottom(); ?>

<?= $this->cc_html->getScriptFileBottom(); ?>

<script>

    var AdminLTEOptions = {

      sidebarExpandOnHover: false,

       navbarMenuSlimscroll: false,

    };


    function delete_this(url) {

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
    };

    const base_url = '<?=site_url()?>';
    const base_asset = '<?=BASE_ASSET;?>';
    const csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
    const csrf_val = '<?= $this->security->get_csrf_hash(); ?>';


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js" type="text/javascript"></script>

<script src="<?= BASE_ASSET; ?>jquery-ui/jquery-ui.js"></script>

<script src="<?= BASE_ASSET; ?>jquery-switch-button/jquery.switchButton.js"></script>

<script src="<?= BASE_ASSET; ?>/js/jquery.ui.touch-punch.js"></script>

<!-- <script src="<?= BASE_ASSET; ?>/admin-lte/bootstrap/js/bootstrap.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script src="<?= BASE_ASSET; ?>/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?= BASE_ASSET; ?>/admin-lte/plugins/fastclick/fastclick.js"></script>

<script src="<?= BASE_ASSET; ?>/admin-lte/dist/js/adminlte.js"></script>

<script src="<?= BASE_ASSET; ?>js-scroll/script/jquery.jscrollpane.min.js"></script>

<script src="<?= BASE_ASSET; ?>jquery-switch-button/jquery.switchButton.js"></script>

<script src="<?= BASE_ASSET; ?>/admin-lte/dist/js/app.min.js"></script>

<script src="<?= BASE_ASSET; ?>/js/custom.js"></script>
<script src="<?= BASE_ASSET; ?>/js/fastcon.admin.js"></script>

</body>

</html>

