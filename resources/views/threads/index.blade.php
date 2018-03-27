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
            <div class="card card-default mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <form action="/threads/search" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
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