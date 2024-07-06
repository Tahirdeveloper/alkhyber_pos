@extends('layouts.admin')

@section('title', 'Sales')
@section('content-header', 'Sales List')
@section('content-actions')
<a href="{{route('cart.index')}}" class="btn btn-primary">Open POS</a>
@endsection

@section('content')
<div class="card">
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
            <form action="{{route('orders.index')}}">
            <div class="col-md-8">
                    <div class="d-flex">
                        <div class="mx-3">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="mx-3">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
                        </div>
                        <div class="mx-3">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>


        </div>
        <table class="table" id="dataTable">
            <thead>
                <tr class="bg-primary">
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Total(Rs)</th>
                    <th>Discount(Rs)</th>
                    <th>Received Amount(Rs)</th>
                    <th>Dues/Change(Rs)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                @foreach ($order->payments as $payment)

                <tr>
                    <td>{{$order->id}}</td>
                    <td id="customer">{{ $order->getCustomerName() }}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$payment->amount + $payment->dues + $payment->discount}}</td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($payment->discount)}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$payment->amount}}</td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($payment->dues)}}</td>
                    <td>
                        @if($payment->amount == 0 && ($order->amount + $order->dues) > 0)
                        <span class="badge badge-danger text-white">Not Paid</span>
                        @elseif(($payment->amount+$payment->discount) < ($payment->amount + $payment->dues + $payment->discount))
                            <span class="badge badge-warning text-white">Partial</span>
                            @elseif(($payment->amount+$payment->discount) == $payment->amount+$payment->dues+$payment->discount)
                            <span class="badge badge-success">Paid</span>
                            @elseif(($payment->amount+$payment->discount) > $payment->amount+$payment->dues+$payment->discount)
                            <span class="badge badge-info text-white">Change</span>
                            @endif
                    </td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info">Action</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu w-100" role="menu">
                                <a href="{{ route('orderInvoice',['c_id'=>$order->id]) }}" class="dropdown-item">Invoice</a>

                                <!-- <a class="dropdown-item" href="#">Pay</a> -->
                                <a class="dropdown-item" href="#" onclick="handleRefundClick({{ $order->id }})">Refund</a>
                                <a class="dropdown-item" href="#" onclick="handlePayClick({{ $order->id }})">Pay</a>
                                <a class="dropdown-item" href="#" onclick="handleDeleteClick({{ $order->id }})">Delete</a>

                            </div>

                        </div>
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
        {{ $orders->render() }}
    </div>
</div>
@section('js')
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#dataTable tbody tr").each(function() {
                var addressText = $(this).find('#customer').text().toLowerCase();
                $(this).toggle(addressText.indexOf(value) > -1);
            });
        });
    });
</script>
<script>
    var csrfToken = '{{ csrf_token() }}';
</script>
<script>
    function handlePayClick(orderId) {
        Swal.fire({
            title: "Enter the amount",
            html: '<input type="number" step="0.01" id="paymentAmount" class="swal2-input" placeholder="00">\
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
                const [paymentAmount,notes] = result.value;
                // Make an AJAX request to update the payment
                updatePaymentAmount(orderId, paymentAmount,notes);
            }
        });
    }

    function updatePaymentAmount(orderId, amount,notes) {
        axios.post('update-payment', {
                order_id: orderId,
                paymentAmount: amount,
                notes: notes,
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: `Amount: ${amount} paid successfully.`,
                });
                window.location.reload();
            })
            .catch((error) => {
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

        axios.post('refund-payment', {
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
        axios.get(`order/delete/${orderId}`, {
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
</script>
@endsection
@endsection