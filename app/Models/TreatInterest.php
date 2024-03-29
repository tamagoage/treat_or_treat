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
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function treat()
    {
        return $this->belongsTo(Treat::class);
    }
}
