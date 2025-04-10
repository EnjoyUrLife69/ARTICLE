<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    public function article()
    {
        return $this->hasMany(Article::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function activitie()
    {
        return $this->hasMany(Activitie::class, 'user_id', 'id');
    }
    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
    public function earning()
    {
        return $this->hasMany(Earning::class);
    }
    public function AricleEarning()
    {
        return $this->hasMany(ArticleEarning::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/images/users/' . $this->image))) {
            return asset('storage/images/users/' . $this->image);
        }

        // fallback ke default yang ada di public/assets/img/avatars
        return asset('assets/img/avatars/default.jpg');
    }

    public function deleteImage()
    {
        $imagePath = public_path('images/users/' . $this->image); // Perbaiki path
        if ($this->image && file_exists($imagePath)) {
            return unlink($imagePath);
        }
        return false;
    }

    public function writerProfile()
    {
        return $this->hasOne(WriterProfile::class);
    }
}
