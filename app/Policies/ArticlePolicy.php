<?php

namespace App\Policies;

use App\Models\User;
use App\Classes\Article;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class ArticlePolicy
{
    public function update(Customer $user, Article $article): bool
    {
        Log::info('auth');
        return $user->id === $article->authorId;
    }
}
