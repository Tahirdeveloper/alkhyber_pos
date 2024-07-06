<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $orders = Order::with(['items', 'payments'])->get();
        $customers_count = Customer::count();
        $expenses =Expense::all()->sum('amount');
        $purchaseAmount = Purchase::all()->sum('paidAmount');
        // Dues Payments Orders
        $dueOrders = new Order();
        if ($request->start_date) {
            $dueOrders = $dueOrders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $dueOrders = $dueOrders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $dueOrders = $dueOrders->with(['items', 'payments', 'customer'])->latest()->get();
        $total = $dueOrders->map(function ($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $dueOrders->map(function ($i) {
            return $i->receivedAmount();
        })->sum();

       
            return view('home', [
            'dueOrders' =>$dueOrders,
            'orders' =>$orders,
            'receivedAmount'=>$receivedAmount,
            'total'=>$total,
            'orders_count' => $orders->count(),
            'income' => $orders->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'income_today' => $orders->where('created_at', '>=', date('Y-m-d').' 00:00:00')->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'customers_count' => $customers_count,
            'expenses'         => $expenses,
            'purchaseAmount' =>$purchaseAmount
        ]);
    }
}
