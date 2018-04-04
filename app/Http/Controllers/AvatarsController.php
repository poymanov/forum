<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        request()->validate([
            'image' => 'required|image'
        ]);

        $avatar_path = request()->file('image')->store('avatars', 'public');

        auth()->user()->update([
            'avatar_path' => $avatar_path
        ]);

        return response([], 204);
    }
}
