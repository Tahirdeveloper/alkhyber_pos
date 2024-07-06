<?php if(Session::has('error')): ?>
<div class="alert alert-danger">
    <?php echo e(Session::get('error')); ?>

</div>
<?php endif; ?><?php /**PATH E:\Point Of Sale\POS\resources\views/layouts/partials/alert/error.blade.php ENDPATH**/ ?>