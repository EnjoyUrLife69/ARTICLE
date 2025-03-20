<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'type',
        'path',
        'order',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
