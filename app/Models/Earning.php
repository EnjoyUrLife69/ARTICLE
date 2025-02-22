<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_views', 'total_likes', 'total_shares', 'total_earnings'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
