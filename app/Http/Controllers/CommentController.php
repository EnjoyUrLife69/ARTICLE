<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000', // Validasi content komentar
            'article_id' => 'required|uuid|exists:articles,id', // Validasi artikel
        ]);

        // Menyimpan komentar baru
        $comment = new Comment();
        $comment->user_id = auth()->user()->id; // Menyimpan ID user yang sedang login
        $comment->article_id = $validatedData['article_id']; // ID artikel
        $comment->content = $validatedData['content']; // Isi komentar
        $comment->save(); // Menyimpan ke database

        // Mengarahkan pengguna kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Your comment has been posted!')
                 ->withFragment('commentList');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}