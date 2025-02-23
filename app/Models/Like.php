<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'article_id'];

    protected $keyType   = 'string'; // Karena UUID bertipe string
    public $incrementing = false;    // Matikan auto-increment untuk UUID

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID untuk id
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

}
