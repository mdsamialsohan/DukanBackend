<?php

namespace App\Http\Controllers;

use App\Models\CustomerList;
use App\Models\VendorList;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendor = VendorList::all();// Fetch data from the CustomerList model
        return response()->json($vendor);
    }
    public function TotalDebt()
    {
        $vendor = VendorList::all();

        $Debt = $vendor->sum('Debt');

        return response()->json(['Debt' => $Debt]);
    }
    public function Create(Request $request)
    {
        $validatedData = $request->validate([
            'VendorName' => 'required|string',
            'VendorMobile' => 'nullable|string',
            'VendorAddress' => 'required|string',
            'Debt'=> 'required|string'
        ]);

        $vendor = VendorList::create($validatedData);
        return response()->json(['message' => 'vendor added successfully', 'vendor' => $vendor]);
    }
}
