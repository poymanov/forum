<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateReplyRequest;

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

    public function store($channel, Thread $thread, CreateReplyRequest $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => Auth::id()
        ]);

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
