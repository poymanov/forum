<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profile.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }
}
