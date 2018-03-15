<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

        return back();
    }
}
