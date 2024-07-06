<?php $__env->startSection('title', 'Product List'); ?>
<?php $__env->startSection('content-header', 'Product List'); ?>
<?php $__env->startSection('content-actions'); ?>

<!-- Button trigger modal -->
<a href="<?php echo e(route('products.create')); ?>"><button type="button" class="btn btn-primary">
    Add Product
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
                    <th>Image</th>
                    <th>Name</th>
                    <!-- <th>Purchase Price</th>
                    <th>Expenses</th>
                    <th>Profit</th>
                    <th>Sale Price</th> -->
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><img class="product-img" src="<?php echo e(Storage::url($product->image)); ?>" alt=""></td>
                    <td><?php echo e($product->name); ?></td>
                    <!-- <td><?php echo e($product->purchase_price); ?></td>
                    <td><?php echo e($product->tax); ?></td>
                    <td><?php echo e($product->profit); ?></td>
                    <td><?php echo e($product->sale_price); ?></td> -->
                    <td><?php echo e($product->quantity); ?></td>
                    <td>
                        <span class="right badge badge-<?php echo e($product->status ? 'success' : 'danger'); ?>"><?php echo e($product->status ? 'Instock' : 'Out Stock'); ?></span>
                    </td>
                    <td><?php echo e($product->created_at->format('Y-m-d')); ?></td>
                    <td>
                        <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-delete" data-url="<?php echo e(route('products.destroy', $product)); ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($products->render()); ?>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Alkhyber_POS\resources\views/products/index.blade.php ENDPATH**/ ?>