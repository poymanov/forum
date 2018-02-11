@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create thread</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('threads.store') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" type="text" name="title" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea id="body" name="body" class="form-control" rows="8"></textarea>
                        </div>

                        <button type="submit" class="btn">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection