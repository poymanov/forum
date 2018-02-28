@extends('layouts.app')

@section('content')
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}" v-cloak>
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
                        <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-default mb-4">
                        <div class="card-body">
                            A thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> and currently has <span v-text="repliesCount"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection