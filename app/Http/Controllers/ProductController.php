<?php

namespace App\Http\Controllers;

use App\Models\CustomerList;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $Product = Product::all();// Fetch data from the CustomerList model
        return response()->json($Product);
    }
    public function Create(Request $request)
    {
        $validatedData = $request->validate([
            'BrandID' => 'required|exists:product_brands,BrandID',
            'ProductCatID' => 'required|exists:product_cat,ProductCatID',
            'UnitID' => 'required|exists:product_units,UnitID',
            'ProductUnit'=> 'integer|min:0',
            'ExpPerUnit' => 'nullable|numeric|min:0',
            'Rate' => 'required|numeric|min:0',
        ]);

        $Product = Product::create($validatedData);

        return response()->json(['message' => 'Customer added successfully', 'product' => $Product]);
    }
}
