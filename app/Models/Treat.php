<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'shelf_life_id',
        'image',
        'name',
        'made_date',
        'pickup_deadline',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guest_users()
    {
        return $this->hasMany(GuestUser::class);
    }

    public function shelf_life()
    {
        return $this->hasOne(ShelfLife::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function treat_interests()
    {
        return $this->hasMany(TreatInterest::class);
    }
}
