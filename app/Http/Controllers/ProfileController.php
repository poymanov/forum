<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profile.show', [
            'profileUser' => $user,
            'activities' => $this->getActivitiesFeed($user)
        ]);
    }

    protected function getActivitiesFeed(User $user)
    {
        return $activities = $user->activities()->with('subject')->take(50)->latest()->get()->groupBy(function($activity) {
            return $activity->created_at->format('d-m-Y');
        });
    }
}
