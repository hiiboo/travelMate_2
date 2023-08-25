<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['genres', 'translations', 'images', 'organizer'])->get();
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = Article::create([
            $request->validate(
                [
                    'title' => 'required|string',
                    'content' => 'required|string',
                    'status' => 'required|string',
                ]
            )
        ]);

        return $article;
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['genres', 'translations', 'images', 'organizer']);
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $article->update(
            $request->validate(
                [
                    'title' => 'required|string',
                    'content' => 'required|string',
                    'status' => 'sometimes|string',
                ]
            )
        );

        return $article;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return
        response(status: 204);
    }
}
