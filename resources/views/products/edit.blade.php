@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

<div class="">
    <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
    </div>
    <div class="">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                            <div class="form-group col-4">
                                <label for="name">Item Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name',$product->name) }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="category">Category</label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror" id="category">
                                    <option>Select</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{ old("category",$category->category) == $category->category ? "selected" : ""}}>{{$category->category}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="barcode">Barcode</label>
                                <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" id="barcode" placeholder="barcode" value="{{ old('barcode',$product->barcode) }}">
                                @error('barcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="price">KGs / Bag</label>
                                <input type="number" name="kg" step="0.2" class="form-control @error('kg') is-invalid @enderror" id="kg" placeholder="KG" value="{{ old('kg',$product->kg) }}">
                                @error('kg')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="quantity">Total Bags</label>
                                <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" id="quantity" placeholder="Quantity" value="{{ old('stock', $product->stock) }}">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                    <option value="1" {{ old('status') === 1 ? 'selected' : ''}}>Instock</option>
                                    <option value="0" {{ old('status') === 0 ? 'selected' : ''}}>Out of stock</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="description">{{ old('description',$product->description) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="image">Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                                <small class="text-success">Max Width/Height: 1000px * 1000px & Size: 2MB</small>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-4">
                                <label for="price">Price/Kg</label>
                                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Price" value="{{ old('price',$product->price) }}">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="barcode">Purchase Price</label>
                                <input type="text" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" id="pur_price" placeholder="Purchase price" value="{{ old('purchase_price',$product->purchase_price) }}">
                                @error('pur_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <hr>
                        <!-- <div class="row">
                            <div class="form-group col-4">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Price" value="{{ old('price',$product->price) }}">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="price">Tax/Expenses</label>
                                <input type="text" name="tax" class="form-control @error('Tax') is-invalid @enderror" id="Tax/Expenses" placeholder="Tax & Expanses" value="{{ old('tax',$product->tax) }}">
                                @error('tax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="barcode">Purchase Price</label>
                                <input type="text" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" id="pur_price" placeholder="Purchase price" value="{{ old('purchase_price',$product->purchase_price) }}">
                                @error('pur_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="price">Profit / Margin</label>
                                <input type="text" name="profit" class="form-control @error('profit') is-invalid @enderror" id="profit" placeholder="profit" value="{{ old('profit',$product->profit) }}">
                                @error('profit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="barcode">Sale Price</label>
                                <input type="text" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" placeholder="sale price" value="{{ old('sale_price',$product->sale_price) }}">
                                @error('sale_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> -->
                        <hr>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
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