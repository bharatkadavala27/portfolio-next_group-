<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
  <?php echo $__env->yieldPushContent('styles'); ?>


  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name', 'NeXT-SOLUTION')); ?> Admin</title>

  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link href="<?php echo e(asset('admin/css/font-awesome.css')); ?>" rel="stylesheet">

  <!-- Ico-font -->
  <link href="<?php echo e(asset('admin/css/vendors/icofont.css')); ?>" rel="stylesheet">

  <!-- Themify icon-->
  <link href="<?php echo e(asset('admin/css/vendors/themify.css')); ?>" rel="stylesheet">

  <!-- Flag icon -->
  <link href="<?php echo e(asset('admin/css/vendors/flag-icon.css')); ?>" rel="stylesheet">

  <!-- Feather icon -->
  <link href="<?php echo e(asset('admin/css/vendors/feather-icon.css')); ?>" rel="stylesheet">

  <!-- Plugins CSS Start -->
  <link href="<?php echo e(asset('admin/css/vendors/scrollbar.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/css/vendors/datatables.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/css/vendors/animate.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/css/vendors/chartist.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('admin/css/vendors/date-picker.css')); ?>" rel="stylesheet">
  <!-- Plugins CSS End -->

  <!-- Bootstrap CSS -->
  <link href="<?php echo e(asset('admin/css/vendors/bootstrap.css')); ?>" rel="stylesheet">

  <!-- App CSS -->
  <link href="<?php echo e(asset('admin/css/style.css')); ?>" rel="stylesheet">

  <!-- Color Scheme -->
  <link id="color" href="<?php echo e(asset('admin/css/color-1.css')); ?>" rel="stylesheet" media="screen">

  <!-- Responsive CSS -->
  <link href="<?php echo e(asset('admin/css/responsive.css')); ?>" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?php echo e(asset('admin/css/custom.css')); ?>" rel="stylesheet">

  <!-- jQuery Confirm -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body onload="startTime()">
  <div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
      <defs></defs>
      <filter id="goo">
        <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
      </filter>
    </svg>
  </div>

  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php echo $__env->make('layouts.inc.admin.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="page-body-wrapper">
      <?php echo $__env->make('layouts.inc.admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="page-body">
        <?php echo $__env->yieldContent('content'); ?>
      </div>
    </div>
  </div>

  <!-- Latest jQuery -->
  <script src="<?php echo e(asset('admin/js/jquery-3.5.1.min.js')); ?>"></script>

  <!-- Bootstrap JS -->
  <script src="<?php echo e(asset('admin/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script>

  <!-- Feather Icon JS -->
  <script src="<?php echo e(asset('admin/js/icons/feather-icon/feather.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/icons/feather-icon/feather-icon.js')); ?>"></script>

  <!-- Scrollbar JS -->
  <script src="<?php echo e(asset('admin/js/scrollbar/simplebar.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/scrollbar/custom.js')); ?>"></script>

  <!-- Sidebar JS -->
  <script src="<?php echo e(asset('admin/js/config.js')); ?>"></script>
  <!-- Plugins JS Start -->
  <script src="<?php echo e(asset('admin/js/sidebar-menu.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>

  <script src="<?php echo e(asset('admin/js/chart/chartist/chartist.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/chart/chartist/chartist-plugin-tooltip.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/chart/knob/knob.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/chart/knob/knob-chart.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/chart/apex-chart/apex-chart.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/chart/apex-chart/stock-prices.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/notify/bootstrap-notify.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/dashboard/default.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/notify/index.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/datepicker/date-picker/datepicker.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/datepicker/date-picker/datepicker.en.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/datepicker/date-picker/datepicker.custom.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/typeahead/handlebars.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/typeahead/typeahead.bundle.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/typeahead/typeahead.custom.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/typeahead-search/handlebars.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/typeahead-search/typeahead-custom.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/js/product-list-custom.js')); ?>"></script>

  <script src="<?php echo e(asset('admin/js/tooltip-init.js')); ?>"></script>
  <!-- Plugins JS End -->

  <!-- Theme JS -->
  <script src="<?php echo e(asset('admin/js/script.js')); ?>"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

  <?php echo $__env->yieldContent('scripts'); ?>
  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


  <?php echo $__env->yieldPushContent('script'); ?>

</body>

</html><?php /**PATH D:\2026 -BK\NEXT SOLUTION\FEBRUARY\28-02-2026\next-solutions new\resources\views/layouts/admin.blade.php ENDPATH**/ ?>