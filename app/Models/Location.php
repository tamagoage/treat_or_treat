<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fileable = [
        'treat_id',
        'location',
    ];

    public function treat()
    {
        return $this->belongsTo(Treat::class);
    }
}
