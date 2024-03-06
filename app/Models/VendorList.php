<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorList extends Model
{
    use HasFactory;

    protected $table = 'vendor'; // Set the table name

    protected $primaryKey = 'VendorID';
    protected $fillable = [
        'VendorName',
        'VendorAddress',
        'Debt',
        'VendorMobile',
        'national_id',
        'profit',
        'discount'
    ];
}
