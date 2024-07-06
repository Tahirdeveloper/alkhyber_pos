@extends('layouts.admin')

@section('title', 'Report')
@section('content-header', 'Expenses List')

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
<div class="card product-list">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="bg-secondary">
                    <th>Date</th>
                    <th>Expense For</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Account</th>
                    <th>Notes</th>
                    <th>Created By</th>                   
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                <tr>
                <td>{{ $expense->expenseDate }}</td>
                    <td>{{$expense->expenseFor}}</td>
                    <td>{{$expense->amount}}</td>
                    <td>{{$expense->paymentType}}</td>
                    <td>{{$expense->accountNo}}</td>
                    <td>{{$expense->paymentNote}}</td>
                    <td>{{$user->first_name}}</td>
                </tr>
                @endforeach
                <tr class="bg-success">
                  <th>Total Expenses</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>   
                    <th></th>                
                    <th></th>                
                </tr>
                <tr>
                  <th>Rs {{$expenses->sum('amount')}}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>   
                    <th></th>                
                    <th></th>                
                </tr>
            </tbody>
        </table>
        <hr>
    </div>
    <div class="row no-print" style="padding-right: 14px;margin-top: 25px;">
    <div class="col-12">
      <button type="button" id="print-btn" class="btn btn-success float-right" style="margin-right: 5px;margin-top:-50px">
        <i class="fas fa-download"></i> Generate PDF
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
@section('js')
<script>
  $("#print-btn").on('click', function(e) {
      e.preventDefault();
      $("#inv-header").removeClass("d-none");
      $("#inv-footer").removeClass("d-none");
      $("#hide-footer").addClass('d-none');
      window.print({
        noPrintSelector: "#hide-footer",
      });
      $("#inv-header").addClass("d-none");
      $("#inv-footer").addClass("d-none");
    });
</script>
@endsection

@endsection