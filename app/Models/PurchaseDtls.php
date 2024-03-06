<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDtls extends Model
{
    use HasFactory;

    protected $table = 'purchase_dtls';
    protected $fillable = [
        'ProductID',
        'PurMemoID',
        'Quantity',
        'Rate',
        'SubTotal'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
    public function purchaseMemo()
    {
        return $this->belongsTo(PurchaseMemo::class, 'PurMemoID');
    }
}
