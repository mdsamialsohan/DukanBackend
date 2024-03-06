<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellMemo extends Model
{
    use HasFactory;
    protected $table = 'sell_memos'; // Set the table name
    protected $primaryKey = 'SellMemoID';
    protected $fillable = [
        'Date',
        'c_id',
        'PrevDue',
        'TotalBill',
        'Paid',
        'Due'
    ];
    public function sellDtls()
    {
        return $this->hasMany(SellDtls::class, 'SellMemoID');
    }
    public function customer()
    {
        return $this->belongsTo(CustomerList::class, 'c_id', 'c_id');
    }
}
