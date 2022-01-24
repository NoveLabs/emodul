<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
 
class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
 
    public function callback(Request $request)
    {
        try {
            $oauthUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // jika user masih login lempar ke home
        if (Auth::check()) {
            return redirect('/login');
        }
        $user = User::where('google_id', $oauthUser->id)->first();
        if ($user) {
            
            Auth::loginUsingId($user->id);
            return view('siswa.index');

        } else {
            return view('auth.register_google', compact('oauthUser'));
        }

    }
}