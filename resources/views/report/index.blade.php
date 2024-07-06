@extends('layouts.admin')

@section('title', 'Reports')
@section('content-header', 'Sales Report')
@section('content-actions')
@endsection

@section('content')
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
    <!-- <small class="float-right">Date: {{ now()->format('m/d/Y') }}</small> -->
    <!-- /.col -->
  </div>
  <hr>
<div class="card">
    <div class="card-body">
        <div class="row mb-3" id="hide-footer">
            <div class="col-md-5">
                <form action="{{route('report.index')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
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
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{ $order->getCustomerName() }}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}</td>

                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
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
                        <th>Rs {{$total}}</th>
                        <th>Rs {{$receivedAmount}}</th>
                        <th>Rs {{$totalDues}}</th>
                        <th></th>
                    </tr>
            </tbody>
        </table><hr>
        {{ $orders->render() }}
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
@section('js')
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
@endsection
@endsection