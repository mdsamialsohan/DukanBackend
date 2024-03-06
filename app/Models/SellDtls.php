<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellDtls extends Model
{
    use HasFactory;
    protected $table = 'sell_dtls';
    protected $fillable = [
        'ProductID',
        'SellMemoID',
        'Quantity',
        'Rate',
        'SubTotal'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
    public function sellMemo()
    {
        return $this->belongsTo(SellMemo::class, 'SellMemoID');
    }
}
