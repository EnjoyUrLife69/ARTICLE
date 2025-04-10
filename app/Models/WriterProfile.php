<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WriterProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bio',
        'previous_work',
        'motivation',
        'status',
    ];

    /**
     * Get the user that owns the writer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
