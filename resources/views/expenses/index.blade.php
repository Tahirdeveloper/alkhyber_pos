@extends('layouts.admin')

@section('title', 'Expenses List')
@section('content-header', 'Expenses List')
@section('content-actions')

<!-- Button trigger modal -->
<a href="{{route('expense.create')}}"><button type="button" class="btn btn-primary">
    Add Expense
</button></a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="bg-primary">
                    <th>Date</th>
                    <th>Expense For</th>
                    <th>Amount</th>
                    <th>Account</th>
                    <th>Notes</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                <tr>
                <td>{{ $expense->expenseDate }}</td>
                    <td>{{$expense->expenseFor}}</td>
                    <td>{{$expense->amount}}</td>
                    <td>{{$expense->accountNo}}</td>
                    <td>{{$expense->paymentNote}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>
                        <a href="{{ route('expense.edit',['id'=> $expense->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-delete" data-url="{{route('expense.destroy', ['id'=> $expense->id])}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
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
                text: "Do you really want to delete this product?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
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

<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection


@endsection