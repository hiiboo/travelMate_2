<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Organizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:organizer-api'])->except(['index', 'show']);
        // $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gate::authorize('viewAny', Article::class);
        // $this->authorize('viewAny', Article::class);
        $articles = Article::with(['genres', 'translations', 'images', 'organizer'])->get();
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($organizer, ArticleRequest $request)
    {
        $organizer = Auth::guard('organizer-api')->user();

        $article = $organizer->articles()->create($request->validated());

        return response()->json([
            'data' => new ArticleResource($article),
            'message' => 'Article created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($organizer, Article $article)
    {
        $article->load(['genres', 'translations', 'images', 'organizer']);
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest$request, $organizer, Article $article)
    {
        $article->update($request->validated());

        return response()->json([
            'data' => new ArticleResource($article),
            'message' => 'Article updated successfully',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($organizer, Article $article)
    {
        $article->delete();

        return
        response()->json([
            'message' => 'Article deleted successfully',
        ]);
    }
}
