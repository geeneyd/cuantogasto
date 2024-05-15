<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'user_id',
        'category_id',
    ];

    // Definimos la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definimos la relación con el modelo Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
