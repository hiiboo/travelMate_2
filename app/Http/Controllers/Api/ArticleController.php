<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Jobs\ArticleTranslationJob;

class ArticleController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:organizer-api']);
        $this->middleware(['auth:organizer-api'])->except(['index', 'show', 'showWithOrganizer']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Organizer $organizer = null)
    {
        if ($organizer) {
            $articles = $organizer->articles()->with(['genres', 'translations', 'images', 'organizer'])->get();
        } else {
            $articles = Article::with(['genres', 'translations', 'images', 'organizer'])->get();
        }
        return ArticleResource::collection($articles);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Organizer $organizer, Event $event, ArticleRequest $request)
    {
        $this->authorize('create', Article::class);
        // $organizer = Auth::guard('organizer-api')->user();

        // create article that has organizer_id and event_id
        $article = $organizer->articles()->create($request->validated() + ['event_id' => $event->id]);
        
        ArticleTranslationJob::dispatch($article);

        return response()->json([
            'data' => new ArticleResource($article),
            'message' => 'Article created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organizer $organizer = null, Event $event,  Article $article)
    {
        $article->load(['genres', 'translations', 'images', 'organizer']);
        return new ArticleResource($article);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Organizer $organizer, Event $event,  Article $article)
    {
        $this->authorize('update',$article);
        $article->update($request->validated());

        // ArticleTranslationJob::dispatch($article);
        
        return response()->json([
            'data' => new ArticleResource($article),
            'message' => 'Article updated successfully',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organizer $organizer, Event $event, Article $article)
    {
        $this->authorize('delete',$article);
        $article->delete();

        return
        response()->json([
            'message' => 'Article deleted successfully',
        ]);
    }
}
