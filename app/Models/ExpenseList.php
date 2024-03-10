<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseList extends Model
{
    use HasFactory;
    protected $table = 'expense_lists'; // Set the table name
    protected $primaryKey = 'ExpListID';
    protected $fillable = [
        'ExpID',
        'Date',
        'Amount',
        'Ref',
    ];
    public function Exp()
    {
        return $this->belongsTo(Expense::class, 'ExpID');
    }
}

