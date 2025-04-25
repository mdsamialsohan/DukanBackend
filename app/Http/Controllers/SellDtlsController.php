<?php

namespace App\Http\Controllers;

use App\Models\CustomerList;
use App\Models\Product;
use App\Models\SellDtls;
use App\Models\SellMemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellDtlsController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        // Validate the incoming request data
        $request->validate([
            'Date' => 'required|date',
            'c_id' => 'required|exists:customer_list,c_id',
            'Pay' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.productID' => 'required|exists:products,ProductID',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.rate' => 'required|numeric|min:0',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new PurchaseMemo

            $sellMemo = SellMemo::create([
                'Date' => $request->input('Date'),
                'c_id' => $request->input('c_id'),
                'Due' => 0,
                'TotalBill' => 0,
                'PrevDue' => 0,
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
                $product->ProductUnit -= $quantity;
                $product->save();


                // Create MemoDtls
                SellDtls::create([
                    'ProductID' => $productID,
                    'Quantity' => $quantity,
                    'Rate' => $rate,
                    'SubTotal' => $quantity * $rate,
                    'SellMemoID' => $sellMemo->SellMemoID,
                ]);

                // Calculate totalBill
                $totalBill += $quantity * $rate;
            }

            // Update totalBill in PurchaseMemo
            $sellMemo->update(['TotalBill' => $totalBill]);

            // Update Vendor debt

            $customer = CustomerList::find($request->input('c_id'));

            $sellMemo->update(['PrevDue' => $customer->due]);
            $customer->due += $totalBill; // Assuming totalBill is the amount of the purchase
            $customer->due -= $request->input('Pay');
            $newCashBalance = $user->Cash + $request->input('Pay');
            $customer->save();
            $sellMemo->update(['Due' => $customer->due]);

            // Update the user's cash balance in the database
            $user->update(['Cash' => $newCashBalance]);
            // Commit the database transaction
            DB::commit();

            return response()->json(['message' => 'Sell successfully added', 'memoId' => $sellMemo->SellMemoID], 201);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to add Sell'], 500);
        }
    }
    public function Due(Request $request)
    {
        $user = auth()->user();
        // Validate the incoming request data
        $request->validate([
            'Date' => 'required|date',
            'c_id' => 'required|exists:customer_list,c_id',
            'Pay' => 'required|numeric',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create a new PurchaseMemo
            $sellMemo = SellMemo::create([
                'Date' => $request->input('Date'),
                'c_id' => $request->input('c_id'),
                'Due' => 0,
                'TotalBill' => 0,
                'PrevDue' => 0,
                'Paid' => $request->input('Pay'),
            ]);

            // Update Vendor debt
            $customer = CustomerList::find($request->input('c_id'));
            $sellMemo->update(['PrevDue' => $customer->due]);
            $customer->due -= $request->input('Pay');
            $newCashBalance = $user->Cash + $request->input('Pay');
            $customer->save();
            $user->update(['Cash' => $newCashBalance]);
            $sellMemo->update(['Due' => $customer->due]);
            // Commit the database transaction
            DB::commit();
            $this->sms_send($customer->mobile, $request->input('Pay').'টাকা জমা হয়ে বর্তমান হিসাব:'. $customer->due.'টাকা । - মেসার্স মোঃ রজব আলী' );

            return response()->json(['message' => 'Due paid successfully'], 201);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to add debt'], 500);
        }
    }
    function sms_send($numbers, $message) {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "45TfstQ0tcyju6uapWEz";
        $senderid = "8809617614525";
        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $numbers,
            "message" => $message
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    public function getSellMemoDetails($sellMemoID)
    {
        // Fetch detailed information about the Sell Memo with SellDtls
        $sellMemo = SellMemo::with(['customer', 'sellDtls', 'sellDtls.product','sellDtls.product.brand', 'sellDtls.product.category', 'sellDtls.product.unit'])
            ->find($sellMemoID);

        if (!$sellMemo) {
            return response()->json(['error' => 'Sell Memo not found'], 404);
        }

        return response()->json(['sellMemo' => $sellMemo]);
    }
    public function getSellMemo($Date)
    {
        $sellMemo = SellMemo::with(['customer', 'sellDtls', 'sellDtls.product','sellDtls.product.brand', 'sellDtls.product.category', 'sellDtls.product.unit'])
            ->whereDate('Date', $Date)
            ->where('Paid', '=', 0)
            ->get();

        if (!$sellMemo) {
            return response()->json(['error' => 'Sell Memo not found'], 404);
        }

        return response()->json(['sellMemo' => $sellMemo]);
    }
    public function getSellPaid($Date)
    {
        $sellMemo = SellMemo::with(['customer'])
            ->whereDate('Date', $Date)
            ->where('Paid', '!=', 0)
            ->get();

        if (!$sellMemo) {
            return response()->json(['error' => 'Sell Memo not found'], 404);
        }

        return response()->json(['sellMemo' => $sellMemo]);
    }
    public function TotalBillByDate($date)
    {
        // Filter SellMemo records for a specific date
        $sellMemos = SellMemo::whereDate('Date', $date)->get();

        // Calculate the total of TotalBill for the filtered records
        $totalBill = $sellMemos->sum('TotalBill');

        return response()->json(['total_bill' => $totalBill]);
    }
    public function TotalPayByDate($date)
    {
        // Filter SellMemo records for a specific date
        $sellMemos = SellMemo::whereDate('Date', $date)->get();

        // Calculate the total of TotalBill for the filtered records
        $Paid = $sellMemos->sum('Paid');

        return response()->json(['Paid' => $Paid]);
    }
    public function soldProductsByDate($Date)
    {
        $soldProducts = SellDtls::whereHas('sellMemo', function ($query) use ($Date) {
            $query->where('Date', $Date);
        })
            ->with(['product.brand', 'product.category', 'product.unit'])
            ->select('ProductID', DB::raw('SUM(Quantity) as totalQuantity'))
            ->groupBy('ProductID')
            ->get();

        return response()->json(['soldProducts' => $soldProducts]);
    }
    public function SoldProductAPI()
    {
        $soldProducts = SellDtls::all()
            ->with(['sellMemo.Date','product.brand.BrandName', 'product.category.ProductCat', 'product.unit.UnitName','Quantity'])
            ->get();
        return response()->json(['soldProduct' => $soldProducts]);
    }

}
