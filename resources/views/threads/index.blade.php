@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Forum Threads</div>
                <div class="card-body">
                    @include('threads.list')

                    {{ $threads->render() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if($trending)
                <div class="card card-default">
                    <div class="card-header">Trending Threads</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($trending as $item)
                                <li class="list-group-item">
                                    {{ $item->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection