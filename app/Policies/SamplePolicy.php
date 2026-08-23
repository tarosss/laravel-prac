<?php

namespace App\Policies;

use App\Classes\Article;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\Response;

class SamplePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function check(Customer $customer, Article $article, array $add)
    {
        Log::info('cha');
        if ($customer->id === $article->authorId) {
            return Response::allow();
        }

        if (in_array($article->authorId, $add)) {
            return Response::allow();
        }
        return Response::denyAsNotFound('You must be an administrator.');
    }
}
