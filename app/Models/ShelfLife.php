<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelfLife extends Model
{
    use HasFactory;

    protected $fillable = [
        'treat_id',
        'shelf_life',
        'shelf_life_status'
    ];
}
