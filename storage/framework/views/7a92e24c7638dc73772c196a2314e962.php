

<?php $__env->startSection('title', 'Expenses List'); ?>
<?php $__env->startSection('content-header', 'Expenses List'); ?>
<?php $__env->startSection('content-actions'); ?>

<!-- Button trigger modal -->
<a href="<?php echo e(route('expense.create')); ?>"><button type="button" class="btn btn-primary">
    Add Expense
</button></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card product-list">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="bg-primary">
                    <th>Date</th>
                    <th>Expense For</th>
                    <th>Amount</th>
                    <th>Account</th>
                    <th>Notes</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <td><?php echo e($expense->expenseDate); ?></td>
                    <td><?php echo e($expense->expenseFor); ?></td>
                    <td><?php echo e($expense->amount); ?></td>
                    <td><?php echo e($expense->accountNo); ?></td>
                    <td><?php echo e($expense->paymentNote); ?></td>
                    <td><?php echo e($user->first_name); ?></td>
                    <td>
                        <a href="<?php echo e(route('expense.edit',['id'=> $expense->id])); ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-delete" data-url="<?php echo e(route('expense.destroy', ['id'=> $expense->id])); ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this product?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {
                        _method: 'DELETE',
                        _token: '<?php echo e(csrf_token()); ?>'
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                        })
                    })
                }
            })
        })
    })
</script>

<script src="<?php echo e(asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Alkhyber_POS\resources\views/expenses/index.blade.php ENDPATH**/ ?>