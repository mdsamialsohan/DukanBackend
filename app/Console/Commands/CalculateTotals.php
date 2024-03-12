<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\BalanceSheet;
use App\Models\CustomerList;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorList;
use Illuminate\Console\Command;

class CalculateTotals extends Command
{
    protected $signature = 'totals:calculate';
    protected $description = 'Calculate and save totals';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Product = Product::all();// Fetch data from the CustomerList model
        $totalProductPrice = $Product->sum(function ($product) {
            return $product->ProductUnit * $product->Rate;
        });

        $customers = CustomerList::all();
        $totalDue = $customers->sum('due');

        $vendor = VendorList::all();
        $totalDebt = $vendor->sum('Debt');

        $Accounts = Account::all();
        $totalAccounts = $Accounts->sum('Balance');

        $User = User::all();
        $totalCash = $User->sum('Cash');

        BalanceSheet::create([
            'TotalDue' => $totalDue,
            'TotalProductPrice' => $totalProductPrice,
            'TotalDebt' => $totalDebt,
            'TotalAccount' => $totalAccounts,
            'TotalUserCash' => $totalCash,
        ]);

        $this->info('Totals calculated and saved successfully.');
    }
}
