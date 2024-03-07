<?php

namespace App\Http\Controllers;

use App\Models\CustomerList;
use App\Models\SellMemo;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = CustomerList::all(); // Fetch data from the CustomerList model
        return response()->json($customers);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'address' => 'required|string',
            'due'=> 'required|string',
            'national_id' => 'nullable|string',
        ]);

        $customer = CustomerList::create($validatedData);

        return response()->json(['message' => 'Customer added successfully', 'customer' => $customer]);
    }
    public function TotalDue()
    {
        $customers = CustomerList::all();

        $due = $customers->sum('due');

        return response()->json(['due' => $due]);
    }
    public function ledger($customerId)
    {
        $sellMemos = SellMemo::where('c_id', $customerId)->with('sellDtls')->get();
        return response()->json(['sellMemos' => $sellMemos]);
    }
}
