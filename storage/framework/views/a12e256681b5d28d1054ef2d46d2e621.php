


<?php $__env->startSection('title', 'Purchase Invoice'); ?>
<?php $__env->startSection('content-header', 'Purchase Invoice'); ?>
<?php $__env->startSection('css'); ?>
<style>
  .bg-gradient-primary {
    background: #376597 linear-gradient(180deg, #053466, #63a8f2) repeat-x !important;
    border-radius: 20%;
    height: 115px;
  }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="invoice p-3" id="printThis">
  <!-- title row -->
  <div class="row">
    <div class="col-4 col-4 text-right d-flex justify-content-start">
      <span>
        <h5 class="bg-purple text-center px-2">0346-9333232</h5>
        <h5 class="bg-purple text-center px-2">0331-9333232</h5>
      </span>
      <h5 class="text-danger mt-3 mx-3">M Akbar</h5>
    </div>
    <div class="col-4 text-center pt-2">
      <span class="text-danger" style="font-weight: 900 !important;font: icon;font-size: 24px;">
        Al-khyber Tea Company</span> <br><span class="text-danger" style="font-weight: 900 !important;font: icon;font-size: 24px;">&</span><br>
      <span class="text-indigo" style="font-weight: bold !important;font: icon;font-size: 24px;">Tea Broker.</span>
    </div>
    <div class="col-4 text-right d-flex justify-content-end">
      <h5 class="text-danger mt-3 mx-3">Zahid Khan</h5>
      <span>
        <h5 class="bg-purple text-center px-3">0332-0958770</h5>
        <h5 class="bg-purple text-center px-3">0344-9168030</h5>
      </span>
    </div>
    <!-- <small class="float-right">Date: <?php echo e(now()->format('m/d/Y')); ?></small> -->
    <!-- /.col -->
  </div>
  <hr>
  <!-- info row -->

  <div class="row invoice-info text-center">
    <div class="col-sm-4 invoice-col">
      From
      <address>
        <strong>Al-khyber Tea Company</strong><br>
        795 Folsom Ave, Suite 600<br>
        Phone: (804) 123-5432<br>
        Email: info@almasaeedstudio.com
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      To
      <address>
        <strong><?php echo e($products[0]->first_name); ?> <?php echo e($products[0]->last_name); ?></strong><br>
        <ul class="m-0 p-0 list-unstyled">
          <li><?php echo e($products[0]->address); ?></li>
        </ul>
        Phone: <?php echo e($products[0]->phone); ?><br>
        Email: <?php echo e($products[0]->email); ?>

      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b><?php echo e($products[0]->invoice_number); ?></b>
      <br>
      <b>Purchase Date:</b><?php echo e($products[0]->purchaseDate); ?><br>
      <b>Account:</b> <?php echo e($products[0]->acc_no); ?>

    </div>
    <!-- /.col -->
  </div>
  <hr>
  <!-- /.row -->

  <!-- Table row -->
  <div class="row">
    <div class="col-12 table-responsive my-4">
      <table class="table table-sm" style="border-style:dashed">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Supplier</th>
            <th>Qty</th>
            <th>Kgs/Bag</th>
            <th>Shorts(kg)</th>
            <th>Tax</th>
            <th>Price/Kg</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($product->name); ?></td>
            <td><?php echo e($product->first_name); ?> <?php echo e($product->last_name); ?></td>
            <td><?php echo e($product->quantity); ?></td>
            <td><?php echo e($product->kg); ?></td>
            <td><?php echo e($product->short >0 ? $product->short :0); ?></td>
            <td>Rs <?php echo e($product->tax>0?$product->tax : 0); ?></td>
            <td>Rs <?php echo e($product->price); ?></td>
            <td>Rs <?php echo e($product->quantity>0 ? number_format($product->purchase_price,2): 00); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row mt-4">
    <div class="col-6" style='font-size:10px'>
      <div class="form-group">
        <h4 class="box-title">Payments Information : </h4>
        <table class="table table-hover table-sm border" style="width:100%" id="">
          <thead>
            <tr class="bg-primary text-center">
              <th>Payment#</th>
              <th>Paid Amount</th>
              <th>Date</th>
              <th>Payment Notes</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $paidDues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="text-center text-bold" id="payment_row_466">
              <td><?php echo e($payment->id); ?></td>
              <td>Rs <?php echo e($payment->paid_amount); ?></td>
              <td><?php echo e($payment->created_at); ?></td>
              <td class=""><?php echo e($payment->note); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-6">

      <div class="table-responsive w-75" style="margin-left:111px">
        <table class="table" id="dataTable">
          <tbody>
            <tr>
              <th style="width:50%">Total:</th>
              <td><?php echo e($products[0]->allTotal); ?></td>
            </tr>
            <tr>
              <th>Discount</th>
              <td class="">Rs <?php echo e($products[0]->discount); ?></td>
            </tr>
            <tr>
              <th>Paid Amount</th>
              <td>Rs <?php echo e($products[0]->paidAmount); ?></td> 
            </tr>
            <tr>
              <th>Dues</th>
              <td>Rs <span id="dues"><?php echo e($products[0]->dues); ?></span></td>
            </tr>
            <tr>
              <th>Payment Type</th>
              <td><?php echo e($products[0]->payment_method); ?></td>
            </tr>
            <tr>
              <th>Account Number</th>
              <td class=""><?php echo e($products[0]->acc_no); ?></td>
            </tr>
           
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row no-print" style="padding-right: 53px;">
    <div class="col-12">
      <button type="button" class="btn btn-primary float-right" id="print-btn" style="margin-right: 5px;">
        <i class="fas fa-print"></i> Generate PDF
      </button>
    </div>
  </div>
</div>
<!-- INvoice footer -->
<div class="invoice p-3 mb-3 d-none bg-primary" id="inv-footer">
  <div class="row">
    <div class="col-4 col-4 text-right d-flex justify-content-start">
      <span>
        <h5 class="bg-purple text-center px-2"></h5>
      </span>
    </div>
    <div class="col-4 text-center pt-2">
      <span class="text-white" style="">
        Developed</span><span class="text-danger" style=""> By</span>
      <a class="text-white" href="https://codessol.com">Codes Solution</a>
    </div>
    <div class="col-4 text-right d-flex justify-content-end">
      <span>
        <!-- <h5 class="bg-purple text-center px-3">0344-9268030</h5> -->
      </span>
    </div>
  </div>
  <!-- Inovice Footer End -->
</div>
<?php $__env->startSection('js'); ?>


<script>
  // invoice number
  document.getElementById('generateInvoiceBtn').addEventListener('click', function() {
    // Generate a random invoice number (you can customize this as needed)
    const invoiceNumber = generateRandomInvoiceNumber();

    // Update the invoice number field with the generated value
    document.getElementById('invoiceNumber').value = invoiceNumber;
  });

  function generateRandomInvoiceNumber() {
    const randomDigits = Math.floor(Math.random() * 10000); // Generate a random 4-digit number
    const timestamp = Date.now(); // Get the current timestamp
    return `INV-${randomDigits}-${timestamp}`;
  }
</script>
<script>
  $("#print-btn").on('click', function(e) {
    e.preventDefault();
    $('#inv-footer').removeClass('d-none');
    $("#hide-footer").addClass('d-none');
    window.print({
      noPrintSelector: "#hide-footer",
    });
    $('#inv-footer').addClass('d-none');
  });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Alkhyber_POS\resources\views/purchase/invoice.blade.php ENDPATH**/ ?>