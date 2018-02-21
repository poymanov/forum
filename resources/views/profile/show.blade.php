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

                @foreach($activities as $date => $data)
                    <div class="h2 mb-3">{{ $date }}</div>
                    @foreach($data as $activity)
                        @include("profile.activities.{$activity->type}")
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection