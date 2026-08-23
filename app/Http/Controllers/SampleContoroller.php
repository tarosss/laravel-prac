<?php

namespace App\Http\Controllers;

use App\Classes\Article;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class SampleContoroller extends Controller
{
    //
    // use AuthorizesRequests;

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

    public function logout()
    {
        Auth::logout();
    }

    public function check(Request $request)
    {
        // VarDumper::dump(auth()->user());
        $article = new Article(2);
        // Gate::authorize('check', [$article, [1, 3]]);
        var_dump(auth()->user()->can('check', [$article, [1, 3, 2]]));
        echo '認証成功してます';
    }

    public function test()
    {
        echo '表示されました';
    }
}
