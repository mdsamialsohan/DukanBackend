<?php

namespace App\Http\Controllers;


use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    public function index()
    {
        $ProductUnit = ProductUnit::all();
        return response()->json($ProductUnit);
    }
    public function Create(Request $request)
    {
        $validatedData = $request->validate([
            'UnitName' => 'required|string',
            'Unit2KG' => 'required|integer'
        ]);

        $ProductUnit = ProductUnit::create($validatedData);
        return response()->json(['message' => 'Unit added successfully', 'product_units' => $ProductUnit]);
    }
}
