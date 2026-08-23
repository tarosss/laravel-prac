<?php

namespace App\Http\Controllers;

use App\Classes\Article;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class SampleContoroller extends Controller
{
    //
    use AuthorizesRequests;
    public function policy()
    {

        echo 'policy';
        $article = new Article(1);
        $this->authorize('update', $article);
    }

    public function customers()
    {
        var_dump(Customer::all()->toArray());
    }

    public function login()
    {
        Auth::login(Customer::first());
    }

    public function check()
    {
        // VarDumper::dump(auth()->user());
        $article = new Article(2);
        $this->authorize('update', $article);
        echo '認証成功してます';
    }
}
