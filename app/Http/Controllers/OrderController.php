<?php
namespace App\Http\Controllers;
use App\Http\Requests\OrderStoreRequest;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\OrderDues;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
        return view('orders.index', compact('orders'));
    }

    public function store(OrderStoreRequest $request)
    {
        $orderId = '#' . str_pad(mt_rand(1, 999999), 5, '0', STR_PAD_LEFT);

        $existingOrder = Order::where('customer_id', $request->customer_id)->first();

        if ($existingOrder) {

            $invoiceNumber = $existingOrder->invoice_number;
        } else {
            $invoiceNumber = 'INV-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }
        $order = Order::create([
            'invoice_number' => $invoiceNumber,
            'order_id' => $orderId,
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        $shorts = $request->input('shorts');
        $prices = $request->input('prices');

        $kgPrices = $request->input('kgPrices');
        $kgs =  $request->input('kgs');
        
        $kgsArray = explode(',', $kgs);
        foreach ($cart as $item) {
            if ($prices != null) {
                $orderItem = new OrderItem([
                    'quantity' => $item->pivot->quantity,
                    'product_id' => $item->id,
                    'kgs' => array_shift($kgsArray),
                    'shorts' => array_shift($shorts),
                    'kg_price' => array_shift($kgPrices),
                    'price' => array_shift($prices),
                ]);
            }
            $order->items()->save($orderItem);

             $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $amount = $request->amount;
        $totalAmount = $request->totalAmount;
        $grossTotal = $request->grossTotal;
        $discount = $request->discount;
        $paid = $amount + $discount;
        $dues = $grossTotal - $paid;
        $order->payments()->create([
            'amount' => $amount,
            'discount' => $request->discount,
            'dues' => $dues,
            'paymentMethod' => $request->paymentMethod,
            'tid' => $request->tid,
            'date' => $request->date,
            'additionalNotes' => $request->additionalNotes,
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);
        $paidDues = new OrderDues();
        $paidDues->paid_amount = $amount;
        $paidDues->note = $request->additionalNotes;
        $paidDues->order_id = $order->id;
        $paidDues->save();
        return 'success';
    }


    public function updatePayment(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $notes = $request->input('notes');
            $paymentAmount = $request->input('paymentAmount');
            $order = Payment::where('order_id', $orderId)->first();
            $order->amount += $paymentAmount;
            $order->dues -= $paymentAmount;
            if( $order->save()){
                $paidDues = new OrderDues();
                $paidDues->paid_amount = $paymentAmount;
                $paidDues->note = $notes;
                $paidDues->order_id = $orderId;
                $paidDues->save();
                return response()->json(['message' => 'Payment updated successfully']);
            }
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());

            return response()->json(['error' => 'There was a controller error updating the payment'. $e->getMessage()], 500);
        }
    }

    public function refundPayment(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $paymentAmount = $request->input('paymentAmount');
            $order = Payment::where('order_id', $orderId)->first();
            $order->amount -= $paymentAmount;
            $order->dues += $paymentAmount;
            $order->save();
            return response()->json(['message' => 'Payment updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());

            return response()->json(['error' => 'There was a controller error updating the payment'], 500);
        }
    }
    public function deleteOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json(['message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error deleting the order'], 500);
        }
    }

    public function showInvoice(Request $request)
    {
        $id = $request->c_id;
        $invoice = Order::where('id', $id)->first();
        if ($invoice->customer_id != null) {
            $payment = Payment::where('order_id', $id)->first();
            $orders = OrderItem::where('order_id', $id)->get();
            $products = Product::where('id', $orders[0]->product_id)->get();
            $customer = Customer::where('id', $payment->customer_id)->first();
            $paidDues = OrderDues::where('order_id',$id)->get();
            return view('orders.invoice', compact('customer', 'orders', 'invoice', 'payment', 'products','paidDues'));
        }
        return redirect()->back()->with('error', 'Invoice could not be generated for walkin customer');
    }
}
