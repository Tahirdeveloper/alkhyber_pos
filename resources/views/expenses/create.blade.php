@extends('layouts.admin')
@section('title', 'Add Expenses')
@section('content')
<div class="container">
    <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">List Expenses</h5>
    </div>
    <div class="">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('expense.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="form-group col-4">
                            <label for="expenseFor">Expense For</label>
                            <input type="text" name="expenseFor" class="form-control @error('expenseFor') is-invalid @enderror" id="expenseFor" placeholder="expenseFor" value="{{ old('expenseFor') }}">
                            @error('expenseFor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <div class="">
                                <label for="payment_type">Payment Type</label>
                                <select class="form-control select2 select2-hidden-accessible" id="payment_type" name="paymentType" tabindex="-1" aria-hidden="true">
                                    <option value="">-Select-</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank">Bank Transfer</option>
                                    <option value="easyJazz">EasyPaisa/JazzCash</option>
                                </select>
                            </div>
                            @error('paymentType')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="accountNo">Account</label>
                            <input type="text" name="accountNo" class="form-control @error('accountNo') is-invalid @enderror" id="accountNo" placeholder="accountNo" value="{{ old('accountNo') }}">
                            @error('accountNo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="00" value="{{ old('amount') }}">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <div class="form-group">
                                <label for="purchaseNote" class="px-3 control-label">payment Note</label>
                                <div class="col-sm-12">
                                    <textarea type="text" class="form-control  text-right d-block" id="purchaseNote" name="paymentNote" value=""></textarea>
                                </div>
                            </div>
                            @error('purchaseNote')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                        <label for="name" style="width:92px">Date</label>
                            <input type="date" name="expenseDate" class="form-control @error('expenseDate') is-invalid @enderror" id="expenseDate" style="margin-left:3px">
                            @error('expenseDate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dateInput = document.getElementById('expenseDate');
                                    const currentDate = new Date().toISOString().substr(0, 10);
                                    dateInput.value = currentDate;
                                });
                            </script>
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="submit" class="btn btn-success px-5">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')

@endsection