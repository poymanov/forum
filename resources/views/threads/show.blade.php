@extends('layouts.app')

@section('head')
    <link href="{{ asset('/css/vendor/jquery.atwho.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <thread-view inline-template :thread="{{ $thread }}" v-cloak>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('threads._question')

                    <div class="replies">
                        <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-default mb-4">
                        <div class="card-body">
                            <p>
                                A thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> and currently has <span v-text="repliesCount"></span>
                            </p>
                            <subscription-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscription-button>

                            <button class="btn btn-default" v-if="authorize('isAdmin')" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'">Lock</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection