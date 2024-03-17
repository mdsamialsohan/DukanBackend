<?php

namespace App\Http\Controllers;

use App\Models\PurchaseMemo;
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
    public function ledger($vendorId)
    {
        $purchaseMemo = PurchaseMemo::where('VendorID', $vendorId)->with('purchaseDtls')->get();
        return response()->json(['purchaseMemos' => $purchaseMemo]);
    }
    public function VendorById($vendorId)
    {
        try {
            $vendor = VendorList::findOrFail($vendorId);
            return response()->json(['vendor' => $vendor]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }
    }
    public function UpdateVendor(Request $request, $vendorId)
    {
        $validatedData = $request->validate([
            'VendorName' => 'required|string',
            'VendorMobile' => 'required|string',
            'VendorAddress' => 'required|string',
            'Debt'=> 'required|string',
        ]);

        try {
            $vendor = VendorList::findOrFail($vendorId);

            $vendor->update($validatedData);

            return response()->json(['message' => 'Vendor updated successfully', 'vendor' => $vendor]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }
    }
}
