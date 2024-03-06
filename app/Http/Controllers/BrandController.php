<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $ProductBrand = Brand::all();// Fetch data from the CustomerList model
        return response()->json($ProductBrand);
    }
    public function Create(Request $request)
    {
        $validatedData = $request->validate([
            'BrandName' => 'required|string'
        ]);

        $ProductBrand = Brand::create($validatedData);
        return response()->json(['message' => 'Brand added successfully', 'product_brand' => $ProductBrand]);
    }
}
