@extends('layouts.admin')

@section('title', 'Categories')
@section('content-header', 'Edit Categories')
@section('content-actions')
<a href="{{route('cart.index')}}" class="btn btn-primary">Open POS</a>
@endsection

@section('content')

<div class="modal-body">
    <div class="">
        <div class="card-body bg-white shadow">
            <form action="{{ route('category.update',['option'=>$category->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="form-group mx-auto col-6">
                        <label for="name">Category Name</label>
                        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" id="category" placeholder="Add Category" value="{{$category->category}}">
                        @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection