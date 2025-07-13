<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'style',
        'color',
        'size',
        'color_name',
        'piece_price',
    ];
}
