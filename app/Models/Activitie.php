<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activitie extends Model
{
    protected $table = 'activities';
    protected $fillable = [
        'user_id',
        'action',
        'article_id',
        'details',
        'img',
        'categorie_name',
        'description'
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
