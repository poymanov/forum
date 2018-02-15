@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default mb-4">
                <div class="card-header show-thread-header">
                    <div>
                        <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> created {{ $thread->title }}
                    </div>

                    @can('update', $thread)
                        <div>
                            <form method="post" action="{{ route('threads.delete', ['channel' => $thread->channel->name, 'thread' => $thread->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>

            <div class="replies">
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}
            </div>

            <div class="create-reply">
                @if(auth()->check())
                    <form method="POST" action="{{ route('replies.store', ['channel' => $thread->channel->name, 'thread' => $thread->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="5" placeholder="Have something to say?"></textarea>
                        </div>

                        <button type="submit" class="btn">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate this discussion</p>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-default mb-4">
                <div class="card-body">
                    A thread was published {{ $thread->created_at->diffForHumans() }} by
                    <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }}
                    {{ str_plural('comment', $thread->replies_count) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection