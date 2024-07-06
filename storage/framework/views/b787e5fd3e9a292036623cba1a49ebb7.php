<?php $__env->startSection('title', 'Open POS'); ?>
<?php $__env->startSection('collapse', 'sidebar-collapse'); ?>
<?php $__env->startSection('css'); ?>
<style>
    .swal2-html-container {
        overflow: hidden !important;
        font-size: 15px !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="cart"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
    function paymentMethod() {
        var tDetails = document.getElementById("t_details");
        var method = document.getElementById("paymentMethod").value;
        var label = document.getElementById("label");
        if (method === "Cash") {
            tDetails.classList.add("d-none");
        } else {
            tDetails.classList.remove("d-none");
        }
    }

    function calculate() {
        let discount = parseFloat($("#discount").val());
        let amount = parseFloat($("#amount").val());

        let newAmount = Math.max(amount - discount, 0);

        newAmount = Math.round(newAmount * 100) / 100;

        $("#amount").val(newAmount.toFixed(2));
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Point Of Sale\POS\resources\views/cart/index.blade.php ENDPATH**/ ?>