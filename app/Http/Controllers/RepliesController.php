<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channel, Thread $thread)
    {
        if (Gate::denies('create', new Reply)) {
            return response(
                'You are posting too frequently. Please take a break', 429
            );
        }

        try {
            request()->validate(['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => Auth::id()
            ]);
        } catch (\Exception $e) {
            return response('You can\'t add a reply', 422);
        }

        return $reply->load('owner');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        request()->validate(['body' => 'required|spamfree']);

        $reply->update(request(['body']));
    }
}
