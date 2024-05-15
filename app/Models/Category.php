<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'type',
        'user_id',
    ];

    // Definimos la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
