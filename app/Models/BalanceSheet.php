<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasFactory;
    protected $table = 'balance_sheet'; // Set the table name
    protected $fillable = [
        'TotalDue',
        'TotalProductPrice',
        'TotalDebt',
        'TotalAccount',
        'TotalUserCash',
        'created_at',
    ];
}
