
<?php $__env->startSection('content-header', 'Quick Purchase'); ?>
<?php $__env->startSection('title','Purchase Items'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .content-header {
        padding: 0px;
    }

    .formInput {

        display: block;
        width: 73%;
        height: calc(1.6em + 0.75rem + 2px);
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.6;
        margin: 10px auto;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;

    }
</style>
<div class="">
    <div class="">
        <div class="card text-primary" style="border-top: 3px solid;">
            <div class="card-body">
                <form action="<?php echo e(route('purchase.storePurchase')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-6" style="display: flex; align-items:center;">
                            <label for="supplier">Supplier</label>
                            <div class="w-100 mb-0">
                                <select name="supplier_id" class="formInput <?php $__errorArgs = ['supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="supplier">
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->first_name); ?>

                                        <?php echo e($supplier->last_name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group col-6" style="display: flex; align-items:center;">
                            <label for="name" style="width:92px">Purchase Date</label>
                            <input type="date" name="purchaseDate" class="formInput <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="date" placeholder="Date" style="margin-left:3px">
                            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dateInput = document.getElementById('date');
                                    const currentDate = new Date().toISOString().substr(0, 10);
                                    dateInput.value = currentDate;
                                });
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6" style="display: flex; align-items:center;">
                            <label for="warehouse">Barcode</label>
                            <input type="text" name="barcode" class="form-control <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> w-75 mx-auto" id="barcode" placeholder="barcode" value="" required>
                            <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group col-6" style="display: flex; align-items:center;">
                            <label for="category">Category</label>
                            <select name="category" class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> w-75 mx-auto" id="category" required>
                                <option>Select</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->category); ?>"><?php echo e($category->category); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <hr style="border: 1px solid;" class="m-1 text-primary">
                    <div class="row d-flex">
                        <div class="btn-group col-8" style="display: flex; align-items:center;">

                            <select name="category" class="formInput <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="add_row" style="margin-right:0px">
                                <option>Select Item</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <a href="<?php echo e(route('purchase.create')); ?>">
                            <button type="button" class="btn btn-primary my-2"><i class="fa fa-plus"></i>New</button>
                        </a>
                    </div>
                    <hr class="m-1">
                    <!-- Purchase items list -->


                    <?php echo csrf_field(); ?>
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 my-3 px-0">
                                <table id="example1" class="table table-bordered dataTable dtr-inline" aria-describedby="example1_info">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 0px;">Image</th>
                                            <th class="sorting" aria-label="Browser: activate to sort column ascending">
                                                Item Name</th>
                                            <th class="sorting" aria-label="Platform(s): activate to sort column ascending">Unit Price
                                            </th>
                                            <th class="sorting" aria-label="Engine version: activate to sort column ascending">Quantity
                                            </th>
                                            <th class="sorting" aria-label="Engine version: activate to sort column ascending">Tax</th>
                                            <th class="sorting" aria-label="Engine version: activate to sort column ascending">Profit
                                            </th>
                                            <th class="sorting" aria-label="CSS grade: activate to sort column ascending">Total</th>
                                            <th class="sorting" style="width: 0px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table1">
                                        <!-- dynamic fileds are adding here... -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row mt-5">
                            <div class="col-6" style="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="discount_to_all_input" class="col-sm-4 control-label">Discount
                                                on All</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control  text-right discount d-block" id="discount" name="discount" value="">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="purchaseNotes" class="col-sm-4 control-label">Purchase
                                                Notes</label>
                                            <div class="col-sm-12">
                                                <textarea type="text" class="form-control  text-right d-block" id="purchaseNotes" name="purchase_note" value=""></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-6" style="padding-left:66px; margin-top:-19px">
                                <p class="lead my-2 bg-secondary text-center mb-1">Purchase Summary
                                    <input type="text" name="date" id="date" class="sale_input bg-secondary" style="border: none;">
                                </p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:76%">Subtotal:</th>
                                                <td><input type="text" name="allTotal" id="subtotal" class="sale_input text-right" style="border: none;" value="00">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td><input type="text" name="discount" id="showDiscount" class="sale_input text-right" style="border: none;" value="00">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Grant Amount:</th>
                                                <td><input type="text" name="grant" id="grant" class="sale_input text-right" style="border: none;" value="00">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Due Amount:</th>
                                                <td><input type="text" name="dues" id="due" class="sale_input text-right" style="border: none;" value="00">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="col-xs-12 ">
                            <div class="">
                                <div class="box-body ">
                                    <div class=" payments_div payments_div_">
                                        <h4 class="box-title text-info">Make Payment : </h4>
                                        <div class="box box-solid bg-gray p-3">
                                            <div class="box-body">
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <label for="amount">Amount</label>
                                                            <input type="text" class="form-control paid_amt amount" id="amount" name="paidAmount" placeholder="" required>
                                                            <span id="amount_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <label for="payment_type">Payment Type</label>
                                                            <select class="form-control select2 select2-hidden-accessible" id="payment_method" name="payment_method" tabindex="-1" aria-hidden="true" required>
                                                                <option value="">-Select-</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="bank">Bank Transfer</option>
                                                                <option value="easyJazz">EasyPaisa/JazzCash</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <label for="acc_no">Account Number</label>
                                                            <input type="text" class="form-control paid_amt acc_no" id="acc_no" name="acc_no" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <label for="payment_note">Payment Note</label>
                                                            <textarea type="text" class="form-control" id="payment_note" name="payment_note" placeholder=""></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- col-md-12 -->
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <div class="col-md-3 col-md-offset-3">

                                <button type="submit" id="save" class="btn btn-block btn-success payments_modal" title="Save Data">Save</button>

                            </div>
                            <div class="col-sm-3"><a href="">
                                    <button type="reset" class="btn btn-block btn-warning" title="Go Dashboard">Clear</button>
                                </a>
                            </div>
                        </div class="d-flex text-center my-3">
                    </div>
                    <!-- Modal for each product edit -->

                    <!-- ============= -->
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).tooltip();
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>
<script>
    $(document).ready(function() {

    });
</script>
<!-- pos script -->
<script>
    var id = 1;

    function calculateTotal($row) {
        let price = parseInt($row.find('.price').val());
        let qty = parseInt($row.find('.qty').val());
        let tax = parseInt($row.find('.tax').val());
        let profit = parseInt($row.find('.profit').val());
        if (!isNaN(price) && !isNaN(qty)) {
            let total = qty * price + tax + profit;
            $row.find('.total').val(total);
        }
    }

    function calculateSubTotal() {
        $('input.price, input.qty').each(function() {
            var price = parseFloat($(this).closest('tr').find('.price').val());
            var qty = parseFloat($(this).closest('tr').find('.qty'));
            let tax = parseInt($(this).closest('tr').find('.tax').val());
            let profit = parseInt($(this).closest('tr').find('.profit').val());
            if (!isNaN(price) && !isNaN(qty)) {
                $(this).closest('tr').find('.total').val(price * qty + tax + profit);
            }
        });

        var subtotal = $('input.total').toArray().reduce(function(sum, el) {
            return sum + parseFloat(el.value || 0);
        }, 0);
        $('#subtotal').val(subtotal);
    }

    $("#add_row").on('change', function() {

        var productId = $(this).val();

        var url = '<?php echo e(route("product.getproduct")); ?>';
        // Make the Ajax call
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                productId: productId
            },
            dataType: 'json',
            success: function(response) {
                var product = response.product;
                var imageURL = "/storage/" + product.image;

                var $existingRow = $('#table1').find("#" + product.id).closest('tr');
                if ($existingRow.length > 0) {
                    var $qtyInput = $existingRow.find('.qty');
                    $qtyInput.val(parseInt($qtyInput.val()) + 1);
                    calculateTotal($existingRow);
                    calculateSubTotal();
                } else {
                    $('#table1').append('<tr class="odd">\
                <td class="dtr-control">\
                <input type="hidden" id="' + product.id + '" name="p_id[]" value="' + product.id + '">\
                <input type="hidden" id="' + product.id + '" name="kg[]" value="' + product.kg + '">\
                <img class="product-img w-100" src="' + imageURL + '" alt="">\
                <input type="hidden" class="bg-white" name="image[]" value="' + product.image +
                        '"  style="border:none;width:25px"></td>\
                <td class="sale_td" style="vertical-align:middle; display:flex ">\
                    <input type="text" name="name[]" class="sale_input" style="border: none; width:140px" placeholder="Details here..." value="' +
                        product.name +
                        '">\
                    <span href="#" title="Edit This purchase"><i class="fa-regular fa-pen-to-square" data-toggle="modal" data-target="#exampleModal' +
                        product.id + '"></i></span>\
                    <div class="modal fade" id="exampleModal' + product.id +
                        '" tabindex="-1" aria-labelledby="exampleModalLabel' + product.id + '" aria-hidden="true">\
                        <div class="modal-dialog modal-dialog-centered">\
                            <div class="modal-content">\
                    <div class="modal-header">\
                        <h5 class="modal-title" id="exampleModalLabel' + product.id +
                        '">Manage Shorts</h5>\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>\
                    </div>\
                    <div class="modal-body">\
                        <div class="row">\
                            <div class="form-group col-4">\
                                <label for="kg">KGs / Bag</label>\
                                <input type="number" name="kg[]" step="0.2" class="form-control <?php $__errorArgs = ["kg"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="' + product.kg + '" id="kg' +
                        product.id +
                        '" placeholder="KG" value=") }}">\
                            </div>\
                            <div class="form-group col-4">\
                                <label for="bag">Total Bags</label>\
                                <input type="text" name="bagQty[]" class="form-control <?php $__errorArgs = ["quantity"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="bag' +
                        product.id +
                        '" placeholder="Quantity" value="">\
                            </div>\
                            <div class="form-group col-4">\
                            <label for="price">Price / Kg</label>\
                            <input type="text" name="price[]" class="form-control <?php $__errorArgs = ["price"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price' +
                        product.id +
                        '" placeholder="00" value="' + product.price + '" >\
                        </div>\
                        </div>\
                        <div class="row">\
                            <div class="form-group col-4">\
                                <label for="short">Shorts(kg)</label>\
                                <input type="number" name="short[]" step="0.2" class="form-control <?php $__errorArgs = ["short"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="short' +
                        product.id +
                        '" placeholder="Short" value="">\
                            </div\
                        </div>\
                        <div class="form-group col-4">\
                                <label for="netWeight">Net Weight(kg)</label>\
                                <input type="text" name="netWeight[]" class="form-control <?php $__errorArgs = ["netWeight"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="netWeight' +
                        product.id +
                        '" placeholder="Net Weight" value="">\
                            </div>\
                            <div class="form-group col-4">\
                            <label for="kgDiscount">Discount / Kg</label>\
                            <input type="text" name="kgDiscount[]" class="form-control <?php $__errorArgs = ['
                        kgDiscount '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kgDiscount' +
                        product.id +
                        '" placeholder="00" value="">\
                            <?php $__errorArgs = ['
                        price '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>\
                            <span class="invalid-feedback" role="alert">\
                                <strong><?php echo e($message); ?></strong>\
                            </span>\
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>\
                        </div>\
                        <div class="form-group col-6">\
                                <label for="unit_const">Purchase Price</label>\
                                <input type="text" name="unit_cost[]" class="form-control <?php $__errorArgs = ["netWeight"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="unitCost' +
                        product.id +
                        '" placeholder="00" value="">\
                            </div>\
                            <div class="form-group col-6">\
                            <label for="barcode">Purchase Price (with out shorts)</label>\
                            <input type="text" name="grossTotal[]" class="form-control <?php $__errorArgs = ["grossTotal"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="grossTotal' +
                        product.id + '" placeholder="00" value="' + product.purchase_price + '">\
                            <?php $__errorArgs = ["grossTotal"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>\
                            <span class="invalid-feedback" role="alert">\
                                <strong><?php echo e($message); ?></strong>\
                            </span>\
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>\
                        </div>\
                    </div>\
                    <div class="modal-footer">\
                        <button type="button" id="saveChanges' + product.id +
                        '" data-dismiss="modal" class="btn btn-primary">Save changes</button>\
                    </div>\
                </div>\
            </div>\
        </div>\
                </td>\
                <td class="sale_td"><input type="text" class="price w-100 text-center sale_input" name="purchase_price[]" placeholder="Click here..." style="border: none;min-width:70px" id="purchasePrice' +
                        product.id + '" value="' + product.purchase_price + '"></td>\
                <td class="sale_td">\
                    <div class="input-group flex-lg-nowrap mx-auto">\
                    <div class="" style="cursor:pointer">\
                    <span class="btn-sm quantity-control minus-icon btn-danger"><i class="fas fa-minus"></i></span>\
                    </div>\
                    <input type="text" class="qty w-50 text-center sale_input" name="qty[]" id="qty" placeholder="Click here..." style="border: none;min-width:60px !important" value="' + product.quantity + '">\
                    <div class="" style="cursor:pointer">\
                    <span class="btn-sm btn-primary quantity-control plus-icon"><i class="fas fa-plus"></i></span>\
                     </div>\
                    </div>\
                </td>\
                <td class=""><input type="text" class="w-75 text-center tax <?php $__errorArgs = ["Tax"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tax' + product.id + '" name="tax[]" style="min-width:70px" placeholder="00" value="0"></td>\
                <td class="sale_td"><input type="text" class="w-75 text-center profit <?php $__errorArgs = ["profit"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="profit' + product.id + '" name="profit[]" style="min-width:70px" place_holder="00" value="0"></td>\
                <td class="sale_td"><input type="text" class="total w-75 text-center " id="total' + product.id + '" name="sale_price[]" style="min-width:81px" value="' + product.purchase_price + '" placeholde="00"></td>\
                <td class="text-center align-middle px-0">\
                    <a href="#" class="shop-tooltip close float-none text-danger del" data-original-title="Remove"><i class="fa-solid fa-trash-xmark"></i>X</a>\
                </td>\
            </tr>');
                }
                bsCustomFileInput.init();
                $('#kg' + product.id + ',#bag' + product.id + ',#short' + product.id + ',#kgDiscount' + product.id + ',#price' +
                    product.id + '').on('input', function() {
                    var kg = parseFloat($('#kg' + product.id + '').val()) || 0;
                    var bag = parseFloat($('#bag' + product.id + '').val()) || 0;
                    // pass the bags value to the quantity input field
                    $("#qty").val(bag);
                    var short = parseFloat($('#short' + product.id + '').val()) || 0;
                    var netWeight = (kg * bag) - short;
                    var kgDiscount = parseFloat($('#kgDiscount' + product.id + '').val()) || 0;
                    var totalDiscount = parseFloat(kgDiscount * netWeight);
                    $('#netWeight' + product.id + '').val(netWeight.toFixed(2));
                    var pricePerKg = parseFloat($('#price' + product.id + '').val()) || 0;
                    var netPrice = (netWeight * pricePerKg) - totalDiscount;
                    $("#unitCost" + product.id).val(netPrice);
                    var grossTotal = ((kg * bag * pricePerKg) - totalDiscount);
                    $("#grossTotal" + product.id).val(grossTotal.toFixed(2));

                    $("#saveChanges" + product.id).on('click', function() {
                        var purchasePrice = parseFloat($("#purchasePrice" + product.id)
                            .val());
                        $('#purchasePrice' + product.id).val(netPrice);
                        var salePrice = purchasePrice;
                        $('#total' + product.id).val(netPrice);
                        $('#total' + product.id).val(netPrice);

                        var subTotal = 0;
                        $('#table1 .total').each(function() {
                            subTotal += parseFloat($(this).val()) || 0;
                        });
                        console.log(subTotal);
                        $('#subtotal').val(subTotal.toFixed(2));
                    })
                });

                $('#price' + product.id + ', #tax' + product.id + ', #profit' + product.id + '').on(
                    'change',
                    function() {

                        var price = parseFloat($('#price' + product.id).val()) || 0;
                        var kg = parseFloat($('#kg' + product.id).val()) || 0;
                        var tax = parseFloat($('#tax' + product.id).val()) || 0;
                        var profit = parseFloat($('#profit' + product.id).val()) || 0;
                        var purchasePrice = parseFloat($("#purchasePrice" + product.id).val());
                        var salePrice = (purchasePrice);
                        $('#purchasePrice' + product.id).val(purchasePrice.toFixed(2));
                        $("#grossTotal"+product.id ).val(salePrice);
                        $('#total' + product.id).val(salePrice.toFixed(2));
                        var currentTotal = parseFloat($("#total" + product.id).val());
                        $("#total" + product.id).val(currentTotal);
                        calculateSubTotal()
                    });
                $('input.price, input.qty').trigger('change');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
            }
        });
        $(document).on('change', 'input.qty,input.price', function() {
            var $row = $(this).closest('tr');
            calculateTotal($row);

            var subtotal = 0;
            $('input.total').each(function() {
                subtotal += parseFloat($(this).val() || 0);
            });
            $('#subtotal').val(subtotal);

        });

    });

    $(document).on('click', '.quantity-control', function() {
        var inputField = $(this).parent().siblings('.qty');
        var currentValue = parseInt(inputField.val());
        if ($(this).hasClass('plus-icon')) {
            inputField.val(currentValue + 1);
            $("#bag").val(inputField.val());
        } else if ($(this).hasClass('minus-icon') && currentValue > 1) {
            inputField.val(currentValue - 1);
            $("#bag").val(inputField.val());

        }
        calculateTotal(inputField.closest('tr'));
        calculateSubTotal();
    });

    let subTotal = 0;
    $(document).on('change', '#add_row', function() {
        // let $row = $(this).closest('tr');
        let $row = $(".price .qty").closest('tr');
        $row.data('price', parseInt($row.find('.price').val()));
        $row.data('qty', parseInt($row.find('.qty').val()));
        calculateTotal($row);

    });

    $('#add_row').on('change', function() {
        calculateSubTotal();
    });
    // add event listeners to update amounts when price, qty or total change


    $("table").on("click", ".del", function() {
        // Remove the parent TR tag completely from DOM.
        $(this).closest("tr").remove();
    });

    function submitForm(formId) {
        document.getElementById(formId).submit();
    }

    function calculateAmounts() {
        let inputDiscount = parseFloat($('#discount').val());
        let subTotal = parseFloat($("#subtotal").val());
        let showDiscount = parseFloat($('#showDiscount').val());
        let grantAmount = parseFloat($('#grant').val());
        let DueAmount = subTotal - (showDiscount + grantAmount);
        $("#due").val(DueAmount);
        let paidAmount = showDiscount + grantAmount;
    }
    $("#discount").on('blur', function() {
        var discount = $('#discount').val()
        $('#showDiscount').val(parseFloat(discount));
        calculateAmounts();
    });

    $("#amount").on('change', function(e) {
        $('#grant').val(parseFloat($('#amount').val()));
        calculateAmounts();
    });

    // Create a new date object
    var currentDate = new Date();
    // Extract the day, month, and year from the date object
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1; // Note: January is 0
    var year = currentDate.getFullYear();

    // Create a formatted date string
    var formattedDate = year + '-' + month + '-' + day;

    // Use the formatted date string in your code
    $("#date").val(formattedDate);
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Point Of Sale\POS\resources\views/purchase/quickPurchase.blade.php ENDPATH**/ ?>