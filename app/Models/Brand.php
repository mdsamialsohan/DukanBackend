<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'product_brands'; // Set the table name
    protected $primaryKey = 'BrandID';
    protected $fillable = [
        'BrandID',
        'BrandName'
    ];
    public function product()
    {
        return $this->hasMany(Product::class, 'BrandID');
    }
}
