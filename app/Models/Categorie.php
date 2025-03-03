<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = true;
    public $incrementing = false; // Non-aktifkan auto-increment
    protected $keyType = 'string'; // Tentukan tipe ID sebagai string (UUID)

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) { // Cek apakah id kosong
                $model->id = (string) Str::uuid(); // Generate UUID sebagai id
            }
        });
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'categorie_id', 'id');
    }
}
