<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Option;
use App\Models\PaidDues;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Purchase::query();

            if ($request->start_date) {
                $query->where('created_at', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
            }

            if ($request->search) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            }

            if (request()->wantsJson()) {
                $products_data = Product::with(['customer', 'purchase'])
                    ->where('supplier_id', '!=', 0)->get();
                return ProductResource::collection($products_data);
            }
            $products = $query->where('allTotal', '!=', 0)
                ->latest()
                ->paginate(10);

            if (!$products->isEmpty()) {
                $supplier = Customer::findOrFail($products->first()->supplier_id);
            } else {
                return redirect()->back()->with('error', "No record found!");
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', "Erroe occured!");
        }


        return view('purchase.index', compact('supplier'))->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Option::all();
        $suppliers = Customer::where('role', 'supplier')->get();
        if ($suppliers->isEmpty()) {
            return redirect()->route('createSupplier');
        }
        return view('purchase.create', compact('categories', 'suppliers'));
    }

    public function quickPurchase()
    {
        $products = Product::where('supplier_id', 0)->get();
        $categories = Option::all();
        $suppliers = Customer::where('role', 'supplier')->get();
        if ($suppliers->isEmpty()) {
            return redirect()->route('createSupplier');
        }
        return view('purchase.quickPurchase', compact('categories', 'suppliers', 'products'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {

        $validation = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        }
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }
        try {
            DB::beginTransaction();
            $invoiceNumber = 'INV-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            $purchaseData = $request->only(['invoice_number', 'purchaseDate', 'discount', 'paidAmount', 'purchaseNotes', 'dues', 'payment_type', 'acc_no', 'payment_note', 'supplier_id']);
            $purchaseData['invoice_number'] = $invoiceNumber;
            $purchaseData['allTotal'] = $request->input('allTotal');
            $purchaseData['paidAmount'] = $request->input('purchase_price');
            $purchaseData['dues'] = $purchaseData['allTotal'] - $purchaseData['paidAmount'];
            $purchase = Purchase::create($purchaseData);
            PaidDues::create([
                'paid_amount' => $purchase->paidAmount,
                'note' => $request->description,
                'purchase_id' =>$purchase->id,
            ]);
            Product::create([
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'category' => $request->category,
                'kg' => $request->kg,
                'quantity' => $request->quantity,
                'stock'     => $request->quantity,
                'short' => $request->short,
                'netWeight' => $request->netWeight,
                'kgDiscount' => $request->kgDiscount,
                'description' => $request->description,
                'image' => $image_path,
                'barcode' => $request->barcode,
                'price' => $request->price,
                'tax' => $request->tax,
                'purchase_price' => $request->purchase_price,
                'profit' => $request->profit,
                'sale_price' => $request->sale_price,
                'grossTotal' => $request->grossTotal,
                'purchase_id' => $purchase->id,

            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Sorry, there a problem while creating product.');
        }
        return redirect()->route('purchase.index')->with('success', 'Success, you product have been created.');
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
    public function edit($id)
    {
        $products = DB::table('products')->where('purchase_id', $id)->get();
        $purchase = Purchase::with('products')->where('id', $id)->first();

        $categories = Option::all();
        $suppliers = Customer::where("role", "supplier")->get();

        return view('purchase.edit', compact('categories', 'suppliers', 'products', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->supplier_id = $request->supplier_id;
        $product->description = $request->description;
        $product->barcode = $request->barcode;
        $product->category = $request->category;
        $product->kg = $request->kg;
        $product->short = $request->short;
        $product->netWeight = $request->netWeight;
        $product->price = $request->price;
        $product->purchase_price = $request->purchase_price;
        $product->profit = $request->profit;
        $product->tax = $request->tax;
        $product->sale_price = $request->sale_price;
        $product->grossTotal = $request->grossTotal;
        $product->quantity = $request->quantity;
        $product->stock = $request->quantity;

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
       
        
        if ($product->save()) {
            $purchase = Purchase::find($product->purchase_id);
           $allTotal =  $request->input('allTotal');
           $paidAmount = $request->input('totalPaidAmount');
            $purchase->allTotal = intval($allTotal);
            $purchase->paidAmount =  intval($paidAmount);
            $purchase->dues = intval($allTotal) -  intval($paidAmount);
             $purchase->save();
             
             $paidDues = PaidDues::where('purchase_id',$purchase->id)->first();
           
           $paidDues->paid_amount = $purchase->paidAmount;
           $paidDues->note = $request->description;
           $paidDues->save();

            return redirect()->route('purchase.index')->with('success', 'Success, your product have been updated.');
        }
        return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating product.');
    }

    public function storePurchase(Request $request)
    {
        $validation = Validator::make($request->only('supplier_id'), [
            'supplier_id' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            // try {
                // DB::beginTransaction();
                $invoiceNumber = 'INV-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $purchaseData = $request->only(['purchaseDate', 'discount', 'allTotal', 'paidAmount', 'purchase_note', 'dues', 'payment_method', 'acc_no', 'payment_note', 'supplier_id']);
                $purchaseData['invoice_number'] = $invoiceNumber;
                $purchase = Purchase::create($purchaseData);
                 PaidDues::create([
                    'paid_amount' => $request->paidAmount,
                    'note' => $request->payment_note,
                    'purchase_id' =>$purchase->id
                ]);
                $productsData = $request->only(['name', 'supplier_id', 'kg', 'short', 'netWeight', 'kgDiscount', 'barcode', 'category', 'qty','stock','purchase_note', 'image', 'price', 'tax', 'purchase_price', 'profit', 'sale_price', 'grossTotal']);
                $count = count($productsData['name']);
                for ($i = 0; $i < $count; $i++) {
                    $productData = [
                        'name' => $productsData['name'][$i],
                        'supplier_id' => $request->supplier_id,
                        'kg' => $productsData['kg'][$i],
                        'short' => $productsData['short'][$i],
                        'netWeight' => $productsData['netWeight'][$i],
                        'barcode' => $productsData['barcode'][$i],
                        'quantity' => $productsData['qty'][$i],
                        'stock'     => $productsData['qty'][$i],
                        'description' => $request->purchaseNote,
                        'image' => $productsData['image'][$i],
                        'price' => $productsData['price'][$i],
                        'tax' => $productsData['tax'][$i],
                        'purchase_price' => $productsData['sale_price'][$i],
                        'profit' => $productsData['profit'][$i],
                        'sale_price' => $productsData['sale_price'][$i],
                        'grossTotal' => $productsData['grossTotal'][$i],
                        'purchase_id' => $purchase->id,
                    ];
                    Product::create($productData);
                }
                // DB::commit();
                return redirect()->route('purchase.index')->with('success', 'Success, Products purchased successfully!');
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return redirect()->back()->with('error', 'An error occurred while processing the request.');
            // }
        }
    }

    // jquery ajax call =========================================
    public function updatePayment(Request $request)
    {
        try {
            $purchaseId = $request->input('id');
            $paymentAmount = (float)$request->input('paymentAmount');
            $notes = $request->input('notes');
            $purchase = Purchase::where('id', $purchaseId)->first();
            $purchase->paidAmount += $paymentAmount;
            $purchase->dues -= $paymentAmount;
            if( $purchase->save()){
                $paidDues = new PaidDues();
                $paidDues->paid_amount = $paymentAmount;
                $paidDues->note = $notes;
                $paidDues->purchase_id = $purchaseId;

                $paidDues->save();
                return response()->json(['message' => 'Payment updated successfully']);
            }
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());

            return response()->json(['error' => 'There was a controller error updating the payment'], 500);
        }
    }

    public function refundPayment(Request $request)
    {
        try {
            $purchaseId = $request->input('id');
            $paymentAmount = $request->input('paymentAmount');
            $purchase = Purchase::where('id', $purchaseId)->first();
            $purchase->paidAmount -= $paymentAmount;
            $purchase->dues += $paymentAmount;
            $purchase->save();
            return response()->json(['message' => 'Payment updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());

            return response()->json(['error' => 'There was a controller error updating the payment'], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->delete();
            return response()->json(['message' => 'Purchase deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting purchase: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error deleting the purchase'], 500);
        }
    }

    public function showInvoice(Request $request)
    {
        $purchase_id = $request->id;
      
        $products = DB::table('products')
            ->join('purchases', 'products.purchase_id', '=', 'purchases.id')
            ->join('customers', 'purchases.supplier_id', '=', 'customers.id')->where('products.purchase_id', '=', $purchase_id)
            ->select('products.*', 'purchases.*', 'customers.*')->get();
        $paidDues = PaidDues::where('purchase_id',$purchase_id)->get();
        return view('purchase.invoice', compact('products','paidDues'));
    }
}
