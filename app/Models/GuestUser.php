<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'treat_id',
        'session_id',
        'nickname',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function treat()
    {
        return $this->belongsTo(Treat::class);
    }
}
