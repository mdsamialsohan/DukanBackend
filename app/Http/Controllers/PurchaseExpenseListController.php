<?php

namespace App\Http\Controllers;

use App\Models\PurchaseExpenseList;
use Illuminate\Http\Request;

class PurchaseExpenseListController extends Controller
{
    public function index()
    {
        $ProductExpList = PurchaseExpenseList::all();
        return response()->json($ProductExpList);
    }
    public function Create(Request $request)
    {
        $validatedData = $request->validate([
            'PurExpName' => 'required|string'
        ]);

        $ProductExpList = PurchaseExpenseList::create($validatedData);
        return response()->json(['message' => 'Expense List added successfully', 'purchase_expense_lists' => $ProductExpList]);
    }
}
