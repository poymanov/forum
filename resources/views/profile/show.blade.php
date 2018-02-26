@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="page-header mb-4">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>

                @forelse($activities as $date => $data)
                    <div class="h2 mb-3">{{ $date }}</div>
                    @foreach($data as $activity)
                        @if(view()->exists("profile.activities.{$activity->type}"))
                            @include("profile.activities.{$activity->type}")
                        @endif
                    @endforeach
                @empty
                    <p>There is no activities yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection