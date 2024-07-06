<?php $__env->startSection('title', 'Reports'); ?>
<?php $__env->startSection('content-header', 'Sales Report'); ?>
<?php $__env->startSection('content-actions'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row d-none" id="inv-header">
    <div class="col-4 col-4 text-right d-flex justify-content-start">
      <span>
        <h5 class="bg-purple text-center px-2">0346-9333232</h5>
        <h5 class="bg-purple text-center px-2">0331-9333232</h5>
      </span>
      <h5 class="text-danger mt-3 mx-3">M Akbar</h5>
    </div>
    <div class="col-4 text-center pt-2">
        <span class="text-danger" style="font-weight: 900 !important;font: icon;font-size: 24px;">
          Al-khyber Tea Store</span> <br><span class="text-danger" style="font-weight: 900 !important;font: icon;font-size: 24px;">&</span><br>
        <span class="text-indigo" style="font-weight: bold !important;font: icon;font-size: 24px;">Tea Broker.</span>
    </div>
    <div class="col-4 text-right d-flex justify-content-end">
      <h5 class="text-danger mt-3 mx-3">Zahid Khan</h5>
      <span>
      <h5 class="bg-purple text-center px-3">0332-0958770</h5>
      <h5 class="bg-purple text-center px-3">0344-9268030</h5>
      </span>
    </div>
    <!-- <small class="float-right">Date: <?php echo e(now()->format('m/d/Y')); ?></small> -->
    <!-- /.col -->
  </div>
  <hr>
<div class="card">
    <div class="card-body">
        <div class="row mb-3" id="hide-footer">
            <div class="col-md-5">
                <form action="<?php echo e(route('report.index')); ?>">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr class="bg-gradient-secondary">
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Received Amount</th>
                    <th>Dues/Change</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td><?php echo e($order->getCustomerName()); ?></td>
                    <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($order->formattedTotal()); ?></td>
                    <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($order->formattedReceivedAmount()); ?></td>
                    <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($order->total() - $order->receivedAmount(), 2)); ?></td>

                    <td><?php echo e($order->created_at->format('Y-m-d')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-success">
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <th>Received Amount</th>
                        <th>Dues/Change</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Rs <?php echo e($total); ?></th>
                        <th>Rs <?php echo e($receivedAmount); ?></th>
                        <th>Rs <?php echo e($totalDues); ?></th>
                        <th></th>
                    </tr>
            </tbody>
        </table><hr>
        <?php echo e($orders->render()); ?>

        <div class="row no-print" style="padding-right: 53px;">
        <div class="col-12">
          <button type="button" id="print-btn" class="btn btn-primary float-right" style="margin-right: 5px;margin-top:-50px">
            <i class="fas fa-download"></i> Generate PDF
          </button>
        </div>
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
  $("#print-btn").on('click', function(e) {
      e.preventDefault();
      $("#inv-header").removeClass('d-none');
      $("#inv-footer").removeClass('d-none');
      $("#hide-footer").addClass('d-none');
      window.print({
        noPrintSelector: "#hide-footer",
      });
      $("#inv-header").addClass('d-none');
      $("#inv-footer").addClass('d-none');

    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Point Of Sale\POS\resources\views/report/index.blade.php ENDPATH**/ ?>