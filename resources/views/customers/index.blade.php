@extends('layouts.admin')
@if( $id == 1)
@section('title', 'Customer List')
@section('content-header', 'Customer List')

@section('content-actions')
<a href="{{route('customers.create')}}" class="btn btn-primary">Add Customer</a>
@endsection

@else
@section('title', 'Suppliers List')
@section('content-header', 'Suppliers List')

@section('content-actions')
<a href="{{route('createSupplier')}}" class="btn btn-primary">Add Supplier</a>
@endsection

@endif

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="bg-primary">
                    <th>Avatar</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>
                        <img width="50" src="{{$customer->getAvatarUrl()}}" class="img-circle p-0" alt="" style="max-height:45px">
                    </td>
                    <td>{{$customer->first_name}}</td>
                    <td>{{$customer->last_name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->address}}</td>
                    <td>{{$customer->created_at}}</td>
                    <td class="d-flex">
                        <a href="{{ $id == 1 ? route('customers.edit', $customer) : route('editSupplier',['id'=>$customer->id]) }}" class="btn-sm btn-primary  mx-1"><i class="fas fa-edit"></i></a>
                        <button class="btn-sm btn-danger btn-delete" data-url="{{$id == 1 ? route('customers.destroy', $customer) : route('customers.destroy', $customer)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $customers->render() }}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this customer?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {
                        _method: 'DELETE',
                        _token: '{{csrf_token()}}'
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                        })
                    })
                }
            })
        })
    })
</script>
@endsection