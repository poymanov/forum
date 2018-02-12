@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> created {{ $thread->title }}</div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    @if(auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('replies.store', ['channel' => $thread->channel->name, 'thread' => $thread->id]) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea name="body" class="form-control" rows="5" placeholder="Have something to say?"></textarea>
                    </div>

                    <button type="submit" class="btn">Post</button>
                </form>
            </div>
        </div>
    @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate this discussion</p>
    @endif

</div>
@endsection