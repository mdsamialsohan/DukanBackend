<?php

namespace App\Http\Controllers;
use App\Models\BalanceSheet;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function index()
    {
        $bSheet = BalanceSheet::all();// Fetch data from the CustomerList model
        return response()->json($bSheet);
    }
}
