<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the article list.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('news_view');
    }

    /**
     * Determine whether the user can view the article.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Article $article
     * @return mixed
     */
    public function view(User $user, Article $article)
    {
        return $user->hasPermission('news_view');
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('news_post');
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Article $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->hasPermission('news_edit');
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Article $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->hasPermission('news_delete');
    }
}
