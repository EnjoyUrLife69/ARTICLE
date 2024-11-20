<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }


//     Schema::create('comments', function (Blueprint $table) {
//     $table->id();
//     $table->unsignedBigInteger('user_id');
//     $table->uuid('article_id');
//     $table->text('content');
//     $table->timestamps();

//     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//     $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
// });

}
