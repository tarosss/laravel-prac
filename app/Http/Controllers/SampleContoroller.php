<?php

namespace App\Http\Controllers;

use App\Classes\Article;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

    public function showSession()
    {
        // session(['sample4' => 3]);
        // VarDumper::dump(session()->all());
        // session()->save();
        header('Location: /a');
        Log::info('headerのあと');
    }

    public function cacheFlexible()
    {
        Cache::tags(['sample'])->remember('fefegveionv', 100, function () {
            return 'a';
        });
        return response('ok');
    }

    public function context(Request $request)
    {

        var_dump($request->all());
        Log::info('ログ');
    }

    public function http(Request $request)
    {
        return Http::dd()->get('https://readouble.com/laravel/12.x/ja/http-client.html');
    }
}
