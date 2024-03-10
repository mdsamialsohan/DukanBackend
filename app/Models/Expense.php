<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses'; // Set the table name
    protected $primaryKey = 'ExpID';
    protected $fillable = [
        'ExpName'
    ];
    public function ExpList()
    {
        return $this->hasMany(ExpenseList::class, 'ExpID');
    }
}
