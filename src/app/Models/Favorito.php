<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'favoritavel_type',
        'favoritavel_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritavel()
    {
        return $this->morphTo();
    }
}
