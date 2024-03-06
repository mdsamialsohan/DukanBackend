<?php

namespace App\Http\Controllers;

use App\Models\Product_cat;
use Illuminate\Http\Request;

class ProductCat extends Controller
{
    public function index()
    {
        $ProductCat = Product_cat::all();// Fetch data from the CustomerList model
        return response()->json($ProductCat);
    }
    public function Create(Request $request)
    {
        $validatedData = $request->validate([
            'ProductCat' => 'required|string'
        ]);

        $ProductCat = Product_cat::create($validatedData);
        return response()->json(['message' => 'Category added successfully', 'product_cat' => $ProductCat]);
    }
}
