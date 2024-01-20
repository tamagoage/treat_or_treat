<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelfLife extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'treat_id',
        'shelf_life_status'
    ];

    public function treat()
    {
        return $this->belongsTo(Treat::class);
    }
}
