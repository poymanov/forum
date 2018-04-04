<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $search = request('name');

        return User::where('name', 'like', "$search%")->pluck('name');
    }

    public function confirm()
    {
        $user = User::where(['confirmation_token' => request('token')])->first();

        if (! $user) {
            return redirect('/threads')->with('flash', 'Invalid token');
        }

        $user->confirm();

        return redirect('/threads')->with('flash', 'Your account was confirmed');
    }
}
