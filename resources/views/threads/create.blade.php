@extends('layouts.app')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create thread</div>

                <div class="card-body">

                    @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <form method="POST" action="{{ route('threads.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="channel">Channel:</label>
                            <select name="channel_id" id="channel" class="form-control" required>
                                <option value="">Choose one...</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? "selected" : "" }}>
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <wysiwyg name="body"></wysiwyg>
                        </div>

                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                        </div>

                        <button type="submit" class="btn">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection