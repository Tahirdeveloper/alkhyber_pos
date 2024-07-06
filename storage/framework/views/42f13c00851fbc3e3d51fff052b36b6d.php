<?php $__env->startSection('content'); ?>
<!-- Modal for setting opening balance -->
<div class="parent">
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Set Openeing Balance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group w-75 mx-auto text-center fa-2x">
            <label for="balance">Enter Amount</label>
            <input type="text" name="balance" value="0" class="form-control <?php $__errorArgs = ['balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="balance" placeholder="00">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="setBalance()" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Ended -->
  <div class="container-fluid ">
    <div class="row">
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h5><?php echo e($orders_count); ?></h5>
            <p>Orders Count</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?php echo e(route('orders.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h5 id="income"><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($income); ?></h5>
            <p>Income</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="<?php echo e(route('orders.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-secondary">
          <div class="inner">
            <h5><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($income_today, 2)); ?></h5>
            <p>Income Today</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?php echo e(route('orders.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    </div>
    <div class="row">
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-fuchsia">
          <div class="inner">
            <h5><?php echo e($customers_count); ?></h5>

            <p>Customers Count</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="<?php echo e(route('customers.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-purple">
          <div class="inner">
            <h5 id="opening_amount"><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($income-$expenses, 2); ?></h5>
            <p>Balance Credited</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer" data-toggle="modal" data-target="#exampleModal">Set Opning Balance <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <script>
        function setBalance() {
          let balanceInput = parseFloat(document.getElementById('balance').value);
          console.log(balanceInput);
          localStorage.setItem('amount', balanceInput);

        }

        function appendBalance() {
          let openingBalance = document.querySelector('#opening_amount');
          let inputBalance = parseFloat(localStorage.getItem('amount'));
          let income = parseFloat(document.getElementById('income').textContent);
          openingBalance.innerText = inputBalance + income;
        }

        appendBalance();
      </script>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h5><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format(($purchaseAmount+$expenses),2)); ?></h5>
            <p>Balance Debited</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?php echo e(route('expense.index')); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <div class="my-3 d-flex justify-content-between">
      <h3>Due Payments</h3>
      <button type="button" class="btn btn-success float-right" id="print-btn" style="margin-right: 5px;">
        <i class="fas fa-print"></i> Generate PDF
      </button>
    </div>
  </div>
    <!-- Dues Payments -->
    <div class="card">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-12 d-flex justify-content-between">

            <form action="<?php echo e(route('home')); ?>">
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
            <form>
              <div class="form-group">
                <div class="input-group input-group-lg">
                  <input id="searchInput" type="search" class="form-control form-control" name="city" placeholder="Search by city or address">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-lg btn-primary">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="invoice p-3" id="printThis">
    <!-- title row -->
    <div class="row p-3 d-none" id="inv-header" style="background:#c0eeff;">
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
            <span class="text-indigo" style="font-weight: bold !important;font: icon;font-size: 24px;">Tea
                Broker.</span>
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
<table class="table table-sm border text-center" id="dataTable">
  <thead>
    <tr class="bg-primary">
      <!-- <th>ID</th> -->
      <th>Customer Name</th>
      <th style="width: 124px !important;">Address</th>
      <th>Total</th>
      <th style="width: 100px;">Received Amount</th>
      <th>Dues/Change</th>
      <th>Status</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $order->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($payment->dues !=0): ?>
    <tr>
      <!-- <td><?php echo e($order->id); ?></td> -->
      <td id="customer"><?php echo e($order->getCustomerName()); ?></td>
      <td id="address"><?php echo e($order->getCustomerAddress()); ?></td>
      <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($payment->amount+$payment->dues + $payment->discount); ?></td>
      <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($order->formattedReceivedAmount()); ?></td>

      <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($payment->dues)); ?></td>
      <td>
        <?php if($order->receivedAmount() == 0 &&( $payment->amount + $payment->discount) > 0): ?>
        <span class="badge badge-danger text-white">Not Paid</span>
        <?php elseif(($payment->dues) > 0 && ($payment->amount)>0): ?>
        <span class="badge badge-warning text-white">Partial</span>
        <?php elseif($payment->amount > ($payment->amount + $payment->dues)): ?>
        <span class="badge badge-info text-white">Change</span>
        <?php endif; ?>
      </td>
      <td><?php echo e($order->created_at->format('Y-m-d')); ?></td>
      <td>
        <div class="btn-group">
          <button type="button" class="btn btn-info">Action</button>
          <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu w-100" role="menu">
            <a href="<?php echo e(route('orderInvoice',['c_id'=>$order->id])); ?>" class="dropdown-item">Invoice</a>

            <a class="dropdown-item" href="#" onclick="handleRefundClick(<?php echo e($order->id); ?>)">Refund</a>
            <a class="dropdown-item" href="#" onclick="handlePayClick(<?php echo e($order->id); ?>)">Pay</a>
            <a class="dropdown-item" href="#" onclick="handleDeleteClick(<?php echo e($order->id); ?>)">Delete</a>
          </div>

        </div>
      </td>
    </tr>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<script>
  $(document).ready(function() {
    $("#searchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#dataTable tbody tr").each(function() {
        var addressText = $(this).find('#address').text().toLowerCase();
        var nameText = $(this).find('#customer').text().toLowerCase();
        $(this).toggle(addressText.indexOf(value) > -1 || nameText.indexOf(value) > -1 );
      });
    });
  });
</script>
<script>
  function handlePayClick(orderId) {
    Swal.fire({
      title: "Enter the amount",
      html: '<input type="number" step="0.01" id="paymentAmount" class="swal2-input">\
      <input type="text"  id="notes" class="swal2-input my-0 my-3 w-100 mx-auto" placeholder="Payment notes">',
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Pay",
      cancelButtonText: "Cancel",
      preConfirm: () => {
        const paymentAmount = document.getElementById('paymentAmount').value;
        const notes = document.getElementById('notes').value;
        if (isNaN(paymentAmount)) {
          Swal.showValidationMessage("Please enter a valid payment amount.");
        }
        return [paymentAmount, notes];
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const [paymentAmount, notes] = result.value;
        // Make an AJAX request to update the payment
        updatePaymentAmount(orderId, paymentAmount, notes);
      }
    });
  }

  function updatePaymentAmount(orderId, amount, notes) {

    axios.post('admin/update-payment', {
        order_id: orderId,
        paymentAmount: amount,
        notes: notes,
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

  function handleRefundClick(orderId) {
    Swal.fire({
      title: "Enter the amount",
      html: '<input type="number" step="0.01" id="refundAmount" class="swal2-input">',
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Refund",
      cancelButtonText: "Cancel",
      preConfirm: () => {
        const refundAmount = document.getElementById('refundAmount').value;
        if (isNaN(refundAmount)) {
          Swal.showValidationMessage("Please enter a valid refund amount.");
        }
        return refundAmount;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const refundAmount = result.value;
        // Make an AJAX request to update the refund
        updateRefundAmount(orderId, refundAmount);
      }
    });
  }

  function updateRefundAmount(orderId, paymentAmount) {

    axios.post('admin/refund-payment', {
        order_id: orderId,
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

  function deleteOrder(orderId) {
    axios.get(`admin/order/delete/${orderId}`, {
        headers: {
          'X-CSRF-TOKEN': csrfToken
        }
      })
      .then((response) => {

        Swal.fire({
          icon: 'success',
          title: 'Order Deleted!',
          text: 'The order has been successfully deleted.',
        }).then(() => {
          window.location.reload();
        });
      })
      .catch((error) => {
        Swal.fire({
          icon: 'error',
          title: 'Delete Failed!',
          text: 'There was an error deleting the order.',
        });
      });
  }
  // print the due orders

  $("#print-btn").on('click', function(e) {
    e.preventDefault();
    $('#inv-header').removeClass('d-none');
    // $("#hide-footer").addClass('d-none');
    $(".parent").addClass('d-none');
    window.print();
    $('#inv-header').addClass('d-none');
    $(".parent").removeClass('d-none');

  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Point Of Sale\Alkhyber_POS\resources\views/home.blade.php ENDPATH**/ ?>