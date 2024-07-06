<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Option;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = new Product();
        if ($request->search) {
            $products = $products->where('name', 'LIKE', "%{$request->search}%");
        }
        $products = $products->where('supplier_id',0)->latest()->paginate(10);

        if (request()->wantsJson()) {
            return ProductResource::collection($products);
        }
        return view('products.index')->with('products', $products);
    }

    public function getProduct(Request $request) {
        $productId=$request->productId;
        $product = Product::find($productId);
    
        if ($product) {
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function create()
    {
        $categories = Option::all();
        // $suppliers = Customer::where("role","supplier")->get();
        // if(!$suppliers->isEmpty())
        // {
        //     return view('products.create',compact('categories','suppliers'));
        // }
        return view('products.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }
        $purchase = new Purchase();
            $purchase->discount="00";
            $purchase->allTotal="00";
            $purchase->paidAmount="00";
            $purchase->purchase_note="null";
            $purchase->dues="00";
            $purchase->payment_method="null";
            $purchase->acc_no="000";
            $purchase->payment_note="null";
            $purchase->supplier_id=Auth::user()->id;

            if($purchase->save())
            {
                $purchaseId = $purchase->id;
           
        $product = Product::create([
            'name' => $request->name,
            'supplier_id' => 0,
            'category' => $request->category,
            'kg' => $request->kg,
            'quantity' => $request->quantity,
            'stock'     => $request->quantity,
            'short' =>0,
            'netWeight' =>0,
            'kgDiscount' => 0,
            'description' => $request->description,
            'image' => $image_path,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'tax' => $request->tax,
            'purchase_price' => $request->purchase_price,
            'profit' => $request->profit,
            'sale_price' => $request->sale_price,
            'grossTotal' =>00,
            'purchase_id' => $purchase->id

        ]);
    }
        if (!$product) {
            return redirect()->back()->with('error', 'Sorry, there a problem while creating product.');
        }
        return redirect()->route('products.index')->with('success', 'Success, you product have been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Option::all();
        $suppliers = Customer::where("role","supplier")->get();
        return view('products.edit',compact('categories','suppliers'))->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->stock = $request->quantity;
        $product->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete($product->image);
            }
            // Store image
            $image_path = $request->file('image')->store('products', 'public');
            // Save to Database
            $product->image = $image_path;
        }

        if (!$product->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating product.');
        }
        return redirect()->route('products.index')->with('success', 'Success, your product have been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
