<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;

    protected $table = 'product_units'; // Set the table name
    protected $primaryKey = 'UnitID';
    protected $fillable = [
        'UnitID',
        'UnitName',
        'Unit2KG'
    ];
    public function product()
    {
        return $this->hasMany(Product::class, 'UnitID');
    }
}
