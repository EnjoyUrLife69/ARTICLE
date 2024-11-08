<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:categorie-list|categorie-create|categorie-edit|categorie-delete', ['only' => ['index','show']]);
         $this->middleware('permission:categorie-create', ['only' => ['create','store']]);
         $this->middleware('permission:categorie-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:categorie-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Categorie::select('categories.*')
            ->leftJoin('articles', 'articles.categorie_id', '=', 'categories.id') // sesuaikan nama kolom dengan struktur tabel
            ->selectRaw('COUNT(articles.id) as articles_count')
            ->groupBy('categories.id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        Categorie::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $categories = Categories::find($id);
        return view('categories.show', compact('categories'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Categories::find($id);

        return view('categories.edit', compact('categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $categories = Categorie::FindOrFail($id);
        $categories->name = $request->name;
        $categories->description = $request->description;

        $categories->save();

        return redirect()->route('categories.index')->with('success', 'Data updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categories = Categorie::findOrFail($id);
        $categories->delete();

        return redirect()->route('categories.index')->with('success', 'Data deleted successfully.');
    }
}
