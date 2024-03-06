<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_cat extends Model
{
    use HasFactory;

    protected $table = 'product_cat'; // Set the table name
    protected $primaryKey = 'ProductCatID';
    protected $fillable = [
        'ProductCatID',
        'ProductCat'
    ];
    public function product()
    {
        return $this->hasMany(Product::class, 'ProductCatID');
    }
}
