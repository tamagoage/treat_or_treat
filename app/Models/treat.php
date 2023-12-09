<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class treat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'shelflife_id',
        'image',
        'name',
        'made_date',
        'pickup_deadline',
        'url',
    ];
}
