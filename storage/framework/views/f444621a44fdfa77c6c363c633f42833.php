<?php $__env->startSection('title', 'Purchase Items'); ?>
<?php $__env->startSection('content-header', 'Purchase List'); ?>
<?php $__env->startSection('content-actions'); ?>

<!-- Button trigger modal -->
<a href="<?php echo e(route('purchase.create')); ?>"><button type="button" class="btn btn-primary">
        <span style="font-size: 20px;font-weight: bold;">+</span> Purchase Item
    </button></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card product-list">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <input id="searchInput" type="search" class="form-control form-control" name="city" placeholder="Search by city or address">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form action="<?php echo e(route('purchase.index')); ?>">
                <div class="col-md-8">
                    <div class="d-flex">
                        <div class="mx-3">
                            <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>" />
                        </div>
                        <div class="mx-3">
                            <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>" />
                        </div>
                        <div class="mx-3">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>


        </div>

        <table class="table table-sm" id="dataTable">
            <thead>
                <tr class="bg-primary">
                    <th>Invoice#</th>
                    <th>Supplier</th>
                    <th>Purchase Date</th>
                    <th>Discount</th>
                    <th>Dues</th>
                    <th>Paid Amount</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($product->supplier_id && $product->supplier_id !== 0): ?>
                <tr>
                    <?php if(!session('error')): ?>
                    <td><img class="product-img" src="<?php echo e(Storage::url($product->image)); ?>" alt="">
                        <?php echo e($product->invoice_number); ?>

                    </td>
                    <td id="supplier"><?php echo e($supplier->first_name); ?> <?php echo e($supplier->last_name); ?></td>
                    <td><?php echo e($product->purchaseDate); ?></td>
                    <td><?php echo e($product->discount); ?></td>
                    <td><?php echo e($product->dues); ?></td>
                    <td><?php echo e($product->paidAmount); ?></td>
                    <td><?php echo e($product->allTotal); ?></td>
                    <?php
                    $paidAmount = $product->paidAmount;
                    $discount = $product->discount;
                    $allTotal = $product->allTotal;
                    $totalAmount = $paidAmount + $discount;
                    ?>

                    <!-- Determine the status -->
                    <?php
                    if ($totalAmount < $allTotal) { $status='Partial' ; } elseif ($totalAmount==$allTotal) { $status='Paid' ; } elseif ($totalAmount> $allTotal) {
                        $status = 'Change';
                        } elseif ($totalAmount == 0) {
                        $status = 'Unpaid';
                        } else {
                        $status = 'Unknown';
                        }
                        ?>
                        <td>
                            <span class="right badge badge-<?php echo e($status === 'Paid' ? 'success' : ($status === 'Partial' ? 'warning' : ($status=='Unpaid' ? 'danger':'primary') )); ?>">
                                <?php echo e($status); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info">Action</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu mx-n5" role="menu" style="left:-40 !important">
                                    <a href="<?php echo e(route('purchase.edit',['id'=>$product->id])); ?>" class="dropdown-item">Edit</a>
                                    <a href="<?php echo e(route('purchase.invoice',['id'=>$product->id])); ?>" class="dropdown-item">Invoice</a>
                                    <a class="dropdown-item" href="#" onclick="handleRefundClick(<?php echo e($product->id); ?>)">Refund</a>
                                    <a class="dropdown-item" href="#" onclick="handlePayClick(<?php echo e($product->id); ?>)">Pay</a>
                                    <a class="dropdown-item" href="#" onclick="handleDeleteClick(<?php echo e($product->id); ?>)">Delete</a>

                                </div>

                            </div>
                        </td>
                        <?php endif; ?>
                </tr>

                <?php endif; ?>
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
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#dataTable tbody tr").each(function() {
                var addressText = $(this).find('#supplier').text().toLowerCase();
                $(this).toggle(addressText.indexOf(value) > -1);
            });
        });
    });
</script>
<script>
    function handlePayClick(id) {
        Swal.fire({
            title: "Enter the amount",
            html: '<input type="number" step="0.01" id="paymentAmount" class="swal2-input" placeholder="00">\
                 <input type="text"  id="notes" class="swal2-input my-0 py-0" placeholder="Payment notes">',
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Pay",
            cancelButtonText: "Cancel",
            preConfirm: () => {
                const paymentAmount = parseFloat(document.getElementById('paymentAmount').value);
                const notes = document.getElementById('notes').value;
                if (isNaN(paymentAmount)) {
                    Swal.showValidationMessage("Please enter a valid payment amount.");
                    return false;
                }
                return [paymentAmount, notes];
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const [paymentAmount, notes] = result.value;
                // Make an AJAX request to update the payment
                updatePaymentAmount(id, paymentAmount, notes);
            }
        });
    }

    function updatePaymentAmount(id, amount, notes) {
        axios.post('updatePurchase', {
                id: id,
                paymentAmount: amount,
                notes: notes
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then((response) => {
                // Handle the response if necessary
                console.log(response.data);
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: `Amount: ${amount} paid successfully.`,
                });
                window.location.reload();
            })
            .catch((error) => {
                // Handle the error if necessary
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed!',
                    text: 'There was an error paying the payment.',
                });
            });
    }

    function updateRefundAmount(id, paymentAmount) {

        axios.post('refundPurchase', {
                id: id,
                paymentAmount: paymentAmount,
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then((response) => {
                // Handle the response if necessary
                console.log(response.data);
                Swal.fire({
                    icon: 'success',
                    title: 'Refund Successful!',
                    text: `Amount: ${paymentAmount} refund successfully.`,
                });
                window.location.reload();
            })
            .catch((error) => {
                // Handle the error if necessary
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Refund Failed!',
                    text: 'There was an error refunding the payment.',
                });
            });
    }

    function handleDeleteClick(orderId) {
        Swal.fire({
            title: "Delete",
            text: "Are you sure you want to delete this order?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to delete the order
                deleteOrder(orderId);
            }
        });
    }

    function deleteOrder(id) {
        axios.delete(`purchase/delete/${id}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then((response) => {

                Swal.fire({
                    icon: 'success',
                    title: 'Purchase Deleted!',
                    text: 'The purchase has been successfully deleted.',
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Delete Failed!',
                    text: 'There was an error deleting the purchase.',
                });
            });
    }
</script>

<script src="<?php echo e(asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Point Of Sale\POS\resources\views/purchase/index.blade.php ENDPATH**/ ?>