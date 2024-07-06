@extends('layouts.admin')

@section('title', 'Edit Purchase')
@section('content')

<div class="">
    <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Edit Purchase</h5>
    </div>
    <div class="">
       
        @foreach($products as $product)
      
        <div class="card product-card">
            <div class="card-body">
                <form action="{{ route('purchase.update',['id'=>$product->id]) }}" method="POST" enctype="multipart/form-data" class="product-form" id="product-form-{{ $product->id }}">
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
                            <label for="supplier">Supplier</label>
                            <select name="supplier_id" class="form-control @error('supplier') is-invalid @enderror" id="supplier">
                                <option>Select</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{ old("supplier",$supplier->id) == $supplier->id ? "selected" : ""}}>{{$supplier->first_name}} {{ $supplier->last_name}}</option>
                                @endforeach
                            </select>
                            @error('supplier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="kg">KGs / Bag</label>
                            <input type="number" name="kg" step="0.2" class="form-control @error('kg') is-invalid @enderror" id="kg" placeholder="KG" value="{{ old('kg',$product->kg) }}">
                            @error('kg')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="quantity">Total Bags</label>
                            <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" id="bag" placeholder="Quantity" value="{{ old('stock', $product->stock) }}">
                            @error('quantity')
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
                            <label for="short">Shorts(kg)</label>
                            <input type="number" name="short" step="0.2" class="form-control @error('short') is-invalid @enderror" id="short" placeholder="Short" value="{{ old('short',$product->short) }}">
                            @error('short')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="netWeight">Net Weight(kg)</label>
                            <input type="text" name="netWeight" class="form-control @error('netWeight') is-invalid @enderror" id="netWeight" placeholder="Net Weight" value="{{ old('netWeight',$product->netWeight) }}">
                            @error('netWeight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
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
                        <div class="form-group col-12">
                            <label for="description">Description</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="description">{{ old('description',$product->description) }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="price">Price / Kg</label>
                            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="price" value="{{ old('price',$product->price) }}">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="kgDiscount">Discount / Kg</label>
                            <input type="text" name="kgDiscount" class="form-control @error('kgDiscount') is-invalid @enderror" id="kgDiscount" placeholder="00" value="{{ old('kgDiscount',$product->kgDiscount) }}">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-4">
                            <input type="hidden" name="allTotal" id="allTotal" class="purchase_price allTotal" value="{{old('allTotal',$purchase->allTotal) }}">
                            <label for="barcode">Paid Amount</label>
                            <input type="text" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror paid-amount" id="purchase_price" placeholder="Purchase price" value="{{ old('purchase_price',$product->purchase_price) }}">
                            @error('pur_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="price">Profit / Margin</label>
                            <input type="text" name="profit" class="form-control @error('profit') is-invalid @enderror" id="profit" placeholder="profit" value="{{ old('profit',$product->profit) }}">
                            @error('profit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="price">Tax/Expenses</label>
                            <input type="text" name="tax" class="form-control @error('Tax') is-invalid @enderror" id="tax" placeholder="Tax & Expanses" value="{{ old('tax',$product->tax) }}">
                            @error('tax')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="barcode">Sale Price</label>
                            <input type="text" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" placeholder="sale price" value="{{ old('sale_price',$product->sale_price) }}">
                            @error('sale_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="barcode">Sale Price (with out shorts)</label>
                            <input type="text" name="grossTotal" class="form-control @error('grossTotal') is-invalid @enderror" id="grossTotal" placeholder="00" value="{{ old('grossTotal',$product->grossTotal) }}" required>
                            @error('grossTotal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="totalPaidAmount" class="total_paid_amount" value="">
                    <div class="text-center">
                        <button type="submit"  class="btn btn-primary px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

        function updateCalculation(productCard) {
            var kg = parseFloat(productCard.find('#kg').val()) || 0;
            var bag = parseFloat(productCard.find('#bag').val()) || 0;
            var short = parseFloat(productCard.find('#short').val()) || 0;
            var netWeight = (kg * bag) - short;
            productCard.find('#netWeight').val(netWeight.toFixed(2));

            var price = parseFloat(productCard.find('#price').val()) || 0;
            var tax = parseFloat(productCard.find('#tax').val()) || 0;
            var profit = parseFloat(productCard.find('#profit').val()) || 0;
            var kgDiscount = parseFloat(productCard.find('#kgDiscount').val()) || 0;
            var totalDiscount = parseFloat(kgDiscount * netWeight);
            var purchasePrice = (netWeight * price) - totalDiscount;
            var salePrice = purchasePrice;
            // productCard.find('#purchase_price').val(purchasePrice.toFixed(2));
            productCard.find('#sale_price').val(salePrice.toFixed(2));

            var grossTotal = (kg * bag * price + tax + profit - totalDiscount);
            productCard.find('#grossTotal').val(grossTotal.toFixed(2));
        }

        // Update calculations for each product card on input change
        $('.product-card input').on('input', function() {
            var productCard = $(this).closest('.product-card');
            updateCalculation(productCard);
            console.log("hi");
        });

        // Initial calculation for each product card
        $('.product-card').each(function() {
            updateCalculation($(this));
        });
    });
</script>
<script>
function updateTotalPaidAmount() {
    let totalPaidAmount = 0;

    // Iterate over each form
    $('form').each(function() {
        const paidAmount = parseFloat($(this).find('.paid-amount').val()) || 0;
        totalPaidAmount += paidAmount;
    });

    $('.total_paid_amount').val(totalPaidAmount);
}
updateTotalPaidAmount();
// Listen for changes in the Paid Amount inputs
$('.paid-amount').on('input', updateTotalPaidAmount);

    function submitAllForms() {
  const forms = document.querySelectorAll('.product-form');

  forms.forEach((form) => {
    form.submit();
  });
}

</script>
@endsection