<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Organizer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;


class ArticlePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user)
    {
        // Log::info('ArticlePolicy@viewAny was called', ['user' => $user]);
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Article $article)
    {
        // Log::info('ArticlePolicy@view was called', ['user' => $user, 'article' => $article]);
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user instanceof Organizer;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Article $article)
    {
        // Log::info('ArticlePolicy@update was called', ['user' => $user, 'article' => $article]);
        if ($user instanceof Organizer) {
            return $article->isCreatedBy($user)
                ? Response::allow()
                : Response::deny('You do not have right to update this article.');
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Article $article)
    {
        if ($user instanceof Organizer) {
            return $article->isCreatedBy($user)
                ? Response::allow()
                : Response::deny('You do not have right to delete this article.');
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Article $article)
    {
        if ($user instanceof Organizer) {
            return $article->isCreatedBy($user)
                ? Response::allow()
                : Response::deny('You do not have right to restore this article.');
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Article $article)
    {
        if ($user instanceof Organizer) {
            return $article->isCreatedBy($user)
                ? Response::allow()
                : Response::deny('You do not have right to permanently delete this article.');
        }
    }
}
