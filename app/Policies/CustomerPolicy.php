<?php

namespace App\Policies;

use App\Models\User;
use App\Classes\Article;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerPolicy
{
  public function update(Customer $customer, Article $article): bool
  {
    Log::info('auth customer');
    return $customer->id === $article->authorId;
  }
}
