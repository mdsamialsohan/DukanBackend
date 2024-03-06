<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerList extends Model
{
    use HasFactory;

    protected $table = 'customer_list'; // Set the table name
    protected $primaryKey = 'c_id';
    protected $fillable = [
        'c_id',
        'name',
        'mobile',
        'address',
        'due',
        'national_id',
        'profit',
        'discount'
    ];
    public function sellMemos()
    {
        return $this->hasMany(SellMemo::class, 'c_id', 'c_id');
    }
}
