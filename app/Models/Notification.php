<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'status',
        'review_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

// $table->id();
// $table->unsignedBigInteger('user_id'); // Penulis yang akan menerima notifikasi
// $table->string('title'); // Judul notifikasi
// $table->text('message'); // Isi notifikasi
// $table->string('status')->default('unread'); // unread/read
// $table->timestamps();

// $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
