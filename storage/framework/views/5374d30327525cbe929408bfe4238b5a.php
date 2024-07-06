<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/tea_logo.jpg')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
    <script>
        var csrfToken = '<?php echo e(csrf_token()); ?>';
    </script>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('plugins/jquery-ui-dist/jquery-ui.min.js')); ?>"></script>
    <!-- <script src="<?php echo e(asset('plugins/jquery/dist/jquery.min.js')); ?>"></script> -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldContent('css'); ?>
    <script>
        window.APP = <?php echo json_encode([
                            'currency_symbol' => config('settings.currency_symbol'),
                            'warning_quantity' => config('settings.warning_quantity')
                        ]) ?>
    </script>
    <style>
        .table th, .table td{
            vertical-align: middle !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini <?php echo $__env->yieldContent('collapse'); ?>">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php echo $__env->make('layouts.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $__env->yieldContent('content-header'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <?php echo $__env->yieldContent('content-actions'); ?>
                        </div><!-- /.col -->
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?php echo $__env->make('layouts.partials.alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('layouts.partials.alert.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </section>

        </div>
        <!-- /.content-wrapper -->
        <?php echo $__env->make('layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.min.js"></script>
      <script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

      <?php echo $__env->yieldContent('js'); ?>
</body>

</html><?php /**PATH E:\Point Of Sale\Alkhyber_POS\resources\views/layouts/admin.blade.php ENDPATH**/ ?>