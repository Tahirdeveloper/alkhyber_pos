<?php

namespace App\Http\Controllers;
use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('role',"supplier")->latest()->paginate(10);
        $id = 2;
        return view('customers.index',compact('customers','id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id = 2;
        return view('customers.create',compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        $avatar_path = '';

        if ($request->hasFile('avatar')) {
            $avatar_path = $request->file('avatar')->store('customers', 'public');
        }

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role'  =>$request->role,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'avatar' => $avatar_path,
            'user_id' => $request->user()->id,
        ]);

        if (!$customer) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while creating supplier.');
        }
        return redirect()->route('supplier.index')->with('success', 'Success, Supplier have been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($c_id)
    {
        $customer = Customer::find($c_id);
        $id=2;
        return view('customers.edit', compact('customer','id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $c_id)
    {
       
        $customer = Customer::find($c_id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->role = $request->role;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($customer->avatar) {
                Storage::delete($customer->avatar);
            }
            // Store avatar
            $avatar_path = $request->file('avatar')->store('customers', 'public');
            // Save to Database
            $customer->avatar = $avatar_path;
        }

        if (!$customer->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating supplier.');
        }
        $id = 2;
        return redirect()->route('customers.index')->with('supplier_id', $id)->with('success', 'Success, Supplier have been updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer=Customer::find($id);
        if ($customer->avatar) {
            Storage::delete($customer->avatar);
        }

        $customer->delete();

       return response()->json([
           'success' => true
       ]);
    }
}
