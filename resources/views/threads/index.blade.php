@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @forelse($threads as $thread)
                        <article>
                            <div class="thread-header">
                                <h4><a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">{{ $thread->title }}</a></h4>

                                <a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">
                                    {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                                </a>
                            </div>

                            <div class="body">{{ $thread->body }}</div>
                        </article>
                        <hr>
                    @empty
                        There is no threads yet...
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection