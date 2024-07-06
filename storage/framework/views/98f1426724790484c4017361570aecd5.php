<?php if(Session::has('error')): ?>
<div class="alert alert-danger">
    <?php echo e(Session::get('error')); ?>

</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\Alkhyber_POS\resources\views/layouts/partials/alert/error.blade.php ENDPATH**/ ?>