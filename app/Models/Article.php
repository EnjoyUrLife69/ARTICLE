<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    // Pada model Article
    protected $fillable = [
        'title', 'release_date', 'categorie_id', 'user_id', 'description', 'content', 'status', 'cover',
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

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function deleteImage()
    {
        $imagePath = public_path('images/articles/' . $this->cover); // Perbaiki path
        if ($this->cover && file_exists($imagePath)) {
            return unlink($imagePath);
        }
        return false;
    }

}
