<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function ExpIndex()
    {
        $Exp = Expense::all();
        return response()->json($Exp);
    }
    public function ExpListIndex()
    {
        $ExpList = ExpenseList::with('Exp')->get();
        return response()->json($ExpList);
    }
    public function ExpStore(Request $request)
    {
        $validatedData = $request->validate([
            'ExpName' => 'required|string',
        ]);

        $Exp = Expense::create($validatedData);

        return response()->json(['message' => 'Expense added successfully', 'expense' => $Exp]);
    }
    public function ExpListStore(Request $request)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'ExpID' => 'required|exists:expenses,ExpID',
            'Date' => 'required|date',
            'Amount' => 'required|numeric|min:0',
            'Ref' => 'nullable|string',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            $ExpList = ExpenseList::create($validatedData);
            $newCashBalance = $user->Cash - $request->input('Amount');
            $user->update(['Cash' => $newCashBalance]);
            DB::commit();
            return response()->json(['message' => 'Expense Amount added successfully', 'expense' => $ExpList]);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();
            return response()->json(['error' => 'Failed to add Expense'], 500);
        }
    }
    public function TotalExpByDate($date)
    {
        // Filter SellMemo records for a specific date
        $Exp = ExpenseList::with('Exp')
            ->whereDate('Date', $date)->get();

        // Calculate the total of TotalBill for the filtered records
        $totalBill = $Exp->sum('Amount');

        return response()->json(['total_exp' => $totalBill,'exp' =>$Exp]);
    }

}
