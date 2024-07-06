<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\Payment;

class ReportConrtoller extends Controller
{
    public function index(Request $request)
    {
        $orders = new Order();
        if ($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);
        $total = $orders->map(function ($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function ($i) {
            return $i->receivedAmount();
        })->sum();

        $totalDues = $total - $receivedAmount;

        return view('report.index', compact('orders', 'total', 'receivedAmount','totalDues'));
    }

    public function expenses(Request $request)
    {
        $user = Auth::user();
        $expenses = Expense::all();
        return view('report.expenses', compact('expenses','user'));
    }

    public function profitLoss(Request $request){
        if ($request->start_date) {
            $products =Product::where('created_at', '>=', $request->start_date)->where('supplier_id','!=',0);
            $purchase = Purchase::where('created_at', '>=', $request->start_date);
            $expenses = Expense::where('created_at', '>=', $request->start_date);
            $sales = Payment::where('created_at', '>=', $request->start_date);
            $allPurchase = $purchase->sum('allTotal');
        }
        if ($request->end_date) {
            $products =Product::where('created_at', '<=', $request->end_date . ' 23:59:59')->where('supplier_id','!=',0);
            $purchase = Purchase::where('created_at', '<=', $request->end_date . ' 23:59:59');
            $expenses = Expense::where('created_at', '<=', $request->end_date . ' 23:59:59');
            $sales = Payment::where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        else{
            
            $products =Product::where('supplier_id','!=',0);;
            $purchase = Purchase::where('allTotal','!=',0);
            $expenses = Expense::all();
            $sales = Payment::all();
        }
        $allPurchase = $purchase->sum('allTotal');       
        $totalPurchasePrice = $products->pluck('purchase_price')->sum();
        $totaltax = $products->pluck('tax')->sum();
        $totalSalePrice = $sales->pluck('amount')->sum()+$sales->pluck('dues')->sum();
        $netProfit = $totalSalePrice - ($sales->pluck('discount')->sum());
        $totalExpenses = $expenses->pluck('amount')->sum();
        $totalStock = $products->pluck('quantity')->sum();

        
        return view('report.profitLoss',compact('products','purchase','expenses','sales','allPurchase','totalExpenses','netProfit','totalSalePrice','totalStock','totalPurchasePrice'));
    }
}
