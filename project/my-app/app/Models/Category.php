<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Menyesuaikan dengan pemanggilan di controller lama kamu
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];
}