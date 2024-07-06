@extends('layouts.admin')

@if($id == 1)
@section('title', 'Add Customer')
@section('content-header', 'Add Customer')
@else
@section('title', 'Add Supplier')
@section('content-header', 'Add Supplier')
@endif
@section('content')

<div class="card shadow">
    <div class="card-body p-5">

        <form action="{{$id==1? route('customers.store') : route('supplier.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-6">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                    @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">

                <div class="form-group col-6">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address" value="{{ old('address') }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label for="avatar">Avatar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="avatar" id="avatar">
                        <label class="custom-file-label" for="avatar">Choose file</label>
                    </div>
                    @error('avatar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>
            <input type="hidden" name="role" value="{{ $id == 1 ? 'customer' : 'supplier' }}">
            <div class="text-center mt-4">
                <button class="btn btn-success" type="submit">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection