<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'release_date', 'categorie_id', 'user_id', 'description', 'content', 'status', 'cover',
    ];

    public $timestamps   = true;
    public $incrementing = false;    // Non-aktifkan auto-increment
    protected $keyType   = 'string'; // Tentukan tipe ID sebagai string (UUID)

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {           // Cek apakah id kosong
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
    public function activitie()
    {
        return $this->hasMany(Activitie::class, 'articles_id', 'id');
    }
    public function comment()
    {
        return $this->hasMany(Comment::class, 'articles_id', 'id');
    }

    public function deleteImage()
    {
        $imagePath = public_path('images/articles/' . $this->cover); // Perbaiki path
        if ($this->cover && file_exists($imagePath)) {
            return unlink($imagePath);
        }
        return false;
    }

    // filter
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'article_id', 'id');
    }

    // TOTAL PENDAPATAN
    protected $appends = ['total'];
    // Harga per interaksi (dalam IDR)
    const VIEW_RATE  = 15;  // Rp15 per view
    const LIKE_RATE  = 150; // Rp150 per like
    const SHARE_RATE = 550; // Rp750 per share


    // Menghitung total pendapatan
    public function getTotalAttribute()
    {
        $viewEarnings  = $this->view_count * self::VIEW_RATE;
        $likeEarnings  = $this->like_count * self::LIKE_RATE;
        $shareEarnings = $this->share_count * self::SHARE_RATE;

        return $viewEarnings + $likeEarnings + $shareEarnings;
    }

    public function getEarningsBreakdown()
    {
        return [
            'views'  => [
                'count' => $this->view_count,
                'rate'  => self::VIEW_RATE,
                'total' => $this->view_count * self::VIEW_RATE,
            ],
            'likes'  => [
                'count' => $this->like_count,
                'rate'  => self::LIKE_RATE,
                'total' => $this->like_count * self::LIKE_RATE,
            ],
            'shares' => [
                'count' => $this->share_count,
                'rate'  => self::SHARE_RATE,
                'total' => $this->share_count * self::SHARE_RATE,
            ],
            'total'  => $this->total,
        ];
    }

}
