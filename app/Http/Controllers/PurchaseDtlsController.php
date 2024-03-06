<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\PurchaseDtls;
use App\Models\PurchaseMemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseDtlsController extends Controller
{
    public function index()
    {
        $Product = PurchaseMemo::all();// Fetch data from the CustomerList model
        return response()->json($Product);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'Date' => 'required|date',
            'VendorID' => 'required|exists:vendor,VendorID',
            'products' => 'required|array',
            'products.*.productID' => 'required|exists:products,ProductID',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.rate' => 'required|numeric|min:0',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create a new PurchaseMemo
            $purchaseMemo = PurchaseMemo::create([
                'Date' => $request->input('Date'),
                'VendorID' => $request->input('VendorID'),
                'Debt' => 0,
                'TotalBill' => 0,
                'PrevDebt' => 0,
                'Paid' => 0,
            ]);
            $totalBill = 0;

            // Iterate through the products and update Product, MemoDtls, and calculate totalBill
            foreach ($request->input('products') as $productData) {
                $productID = $productData['productID'];
                $quantity = $productData['quantity'];
                $rate = $productData['rate'];

                // Update Product quantity
                $product = Product::find($productID);
                $product->ProductUnit += $quantity;

                $product->save();

                DB::enableQueryLog();
                PurchaseDtls::create([
                    'ProductID' => $productID,
                    'Quantity' => $quantity,
                    'Rate' => $rate,
                    'SubTotal' => $quantity * $rate,
                    'PurMemoID' => $purchaseMemo->PurMemoID,
                ]);

                $queries = DB::getQueryLog();

                DB::commit();dd($queries);
            }
        }catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to add purchase'], 500);
        }
    }
}
