<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::all();

        return response()->json([
            'success' => true,
            'articles' => $articles
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validation des données
        $validateData = $request->validate([
            'title' => 'required|string|max:225',
            'content' => 'required',
            'published' => 'boolean',
        ]);

//Enregistrement de l'article en base ou création d'un article

$article = Article::create($validateData);

//retour de la création de l'article
return response()->json([
    'success' => true,
    'message' => 'Article créé avec succès',
    'article' => $article
], 201); 
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
        return response()->json([
            'success' => true,
            'article' => $article
            
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
        $validateData = $request->validate([
            'title' => 'required|string|max:225',
            'content' => 'required',
            'published' => 'boolean',
        ]);

        $article->update($validateData);

        return response()->json([
            'success' => true,
            'message' => 'Article modifié avec succès',
            'article' => $article
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article supprimé avec succès',
            'article' => $article
        ]);
    }
}
