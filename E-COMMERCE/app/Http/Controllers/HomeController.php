<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
   public function home () {
    $products = Product::all()->take(4);
    $comments = Comment::where('rating', 5)->take(3)->get();

    return view('home', compact(['products', 'comments']));
}

    public function  redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callbackGoogle()
    {
        $user_google = Socialite::driver('google')->user();


        $user = User::updateOrCreate([
            'provider_id' => $user_google->id,
        ], [
            'name' => $user_google->name,
            'email' => $user_google->email,
            'provider' => 'google',
            'provider_id' => $user_google->id,
            'image' => $user_google->avatar,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
