@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('content-header', 'Manage Category')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->category}}</td>
                    <td>
                        <a href="{{ route('categories.edit',['id'=>$category->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('category.destroy',['option'=>$category->id]) }}" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection