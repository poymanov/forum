@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="page-header mb-4">
                    <h1>
                        {{ $profileUser->name }}
                        <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                <div class="card card-default">
                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="thread-header">
                                    <h4><a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">{{ $thread->title }}</a></h4>
                                    <span>
                                        {{ $thread->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="body">{{ $thread->body }}</div>
                            </article>
                            <hr>
                        @endforeach

                        {{ $threads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection