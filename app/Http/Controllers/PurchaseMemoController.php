<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseDtls;
use App\Models\PurchaseMemo;
use App\Models\VendorList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseMemoController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        // Validate the incoming request data
        $request->validate([
            'Date' => 'required|date',
            'VendorID' => 'required|exists:vendor,VendorID',
            'Pay' =>'required|numeric|min:0',
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
                'Paid' => $request->input('Pay'),
            ]);
            $totalBill = 0;

            // Iterate through the products and update Product, MemoDtls, and calculate totalBill
            foreach ($request->input('products') as $productData) {
                $productID = $productData['productID'];
                $quantity = $productData['quantity'];
                $rate = $productData['rate'];

                // Update Product quantity
                $product = Product::find($productID);
                $product->Rate  = (($product->Rate*$product->ProductUnit)+($quantity*$rate))/($product->ProductUnit+$quantity);
                $product->ProductUnit += $quantity;
                $product->save();



                // Create MemoDtls
                PurchaseDtls::create([
                    'ProductID' => $productID,
                    'Quantity' => $quantity,
                    'Rate' => $rate,
                    'SubTotal' => $quantity * $rate,
                    'PurMemoID' => $purchaseMemo->PurMemoID,
                ]);

                // Calculate totalBill
                $totalBill += $quantity * $rate;
            }

            // Update totalBill in PurchaseMemo
            $purchaseMemo->update(['TotalBill' => $totalBill]);

            // Update Vendor debt
            $vendor = VendorList::find($request->input('VendorID'));
            $purchaseMemo->update(['PrevDebt' => $vendor->Debt]);
            $vendor->Debt += $totalBill; // Assuming totalBill is the amount of the purchase
            $vendor->Debt -= $request->input('Pay');
            $newCashBalance = $user->Cash - $request->input('Pay');
            $vendor->save();
            $purchaseMemo->update(['Debt' => $vendor->Debt]);
            $user->update(['Cash' => $newCashBalance]);
            // Commit the database transaction
            DB::commit();

            return response()->json(['message' => 'Purchase successfully added'], 201);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to add purchase'], 500);
        }
    }
    public function Debt(Request $request)
    {
        $user = auth()->user();
        // Validate the incoming request data
        $request->validate([
            'Date' => 'required|date',
            'VendorID' => 'required|exists:vendor,VendorID',
            'Pay' =>'required|numeric',
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
                'Paid' => $request->input('Pay'),
            ]);
            // Update Vendor debt
            $vendor = VendorList::find($request->input('VendorID'));
            $purchaseMemo->update(['PrevDebt' => $vendor->Debt]);
            $vendor->Debt -= $request->input('Pay');
            $newCashBalance = $user->Cash - $request->input('Pay');
            $vendor->save();
            $user->update(['Cash' => $newCashBalance]);
            $purchaseMemo->update(['Debt' => $vendor->Debt]);
            // Commit the database transaction
            DB::commit();

            return response()->json(['message' => 'Debt paid successfully'], 201);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to add debt'], 500);
        }
    }
    public function getPurMemoDetails($PurchaseMemoID)
    {
        $purMemo = PurchaseMemo::with(['Vendor', 'purchaseDtls', 'purchaseDtls.product','purchaseDtls.product.brand', 'purchaseDtls.product.category', 'purchaseDtls.product.unit'])
            ->find($PurchaseMemoID);

        if (!$purMemo) {
            return response()->json(['error' => 'purchase Memo not found'], 404);
        }

        return response()->json(['purMemo' => $purMemo]);
    }
    public function getPurMemo($Date)
    {
        $purMemo = PurchaseMemo::with(['Vendor', 'purchaseDtls', 'purchaseDtls.product','purchaseDtls.product.brand', 'purchaseDtls.product.category', 'purchaseDtls.product.unit'])
            ->whereDate('Date', $Date)
            ->get();

        if (!$purMemo) {
            return response()->json(['error' => 'Purchase Memo not found'], 404);
        }

        return response()->json(['purMemo' => $purMemo]);
    }
    public function getPurPaid($Date)
    {
        $purMemo = PurchaseMemo::with(['Vendor'])
            ->whereDate('Date', $Date)
            ->where('Paid', '>', 0)
            ->get();

        if (!$purMemo) {
            return response()->json(['error' => 'Purchase Memo not found'], 404);
        }

        return response()->json(['purMemo' => $purMemo]);
    }
}
