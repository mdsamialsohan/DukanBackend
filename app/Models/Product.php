<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'ProductID';
    protected $fillable = [
        'BrandID',
        'ProductCatID',
        'UnitID',
        'ProductUnit',
        'ExpPerUnit',
        'Rate'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'BrandID');
    }
    public function category()
    {
        return $this->belongsTo(Product_cat::class, 'ProductCatID');
    }
    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'UnitID');
    }
}
