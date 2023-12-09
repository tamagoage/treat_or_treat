<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'treat_id',
        'is_rejected',
    ];
}
