<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseMemo extends Model
{
    use HasFactory;
    protected $table = 'purchase_memos'; // Set the table name
    protected $primaryKey = 'PurMemoID';
    protected $fillable = [
        'Date',
        'VendorID',
        'PrevDebt',
        'TotalBill',
        'Paid',
        'Debt'
    ];
    public function purchaseDtls()
    {
        return $this->hasMany(PurchaseDtls::class, 'PurMemoID');
    }
}
