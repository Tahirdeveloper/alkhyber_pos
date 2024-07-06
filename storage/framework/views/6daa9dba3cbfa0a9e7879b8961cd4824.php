<?php if( $id == 1): ?>
<?php $__env->startSection('title', 'Customer List'); ?>
<?php $__env->startSection('content-header', 'Customer List'); ?>

<?php $__env->startSection('content-actions'); ?>
<a href="<?php echo e(route('customers.create')); ?>" class="btn btn-primary">Add Customer</a>
<?php $__env->stopSection(); ?>

<?php else: ?>
<?php $__env->startSection('title', 'Suppliers List'); ?>
<?php $__env->startSection('content-header', 'Suppliers List'); ?>

<?php $__env->startSection('content-actions'); ?>
<a href="<?php echo e(route('createSupplier')); ?>" class="btn btn-primary">Add Supplier</a>
<?php $__env->stopSection(); ?>

<?php endif; ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="bg-primary">
                    <th>Avatar</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <img width="50" src="<?php echo e($customer->getAvatarUrl()); ?>" class="img-circle p-0" alt="" style="max-height:45px">
                    </td>
                    <td><?php echo e($customer->first_name); ?></td>
                    <td><?php echo e($customer->last_name); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td><?php echo e($customer->phone); ?></td>
                    <td><?php echo e($customer->address); ?></td>
                    <td><?php echo e($customer->created_at); ?></td>
                    <td class="d-flex">
                        <a href="<?php echo e($id == 1 ? route('customers.edit', $customer) : route('editSupplier',['id'=>$customer->id])); ?>" class="btn-sm btn-primary  mx-1"><i class="fas fa-edit"></i></a>
                        <button class="btn-sm btn-danger btn-delete" data-url="<?php echo e($id == 1 ? route('customers.destroy', $customer) : route('customers.destroy', $customer)); ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($customers->render()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
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
                text: "Do you really want to delete this customer?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Alkhyber_POS\resources\views/customers/index.blade.php ENDPATH**/ ?>