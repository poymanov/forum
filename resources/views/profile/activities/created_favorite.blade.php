@component('profile.activities.activity')
    @slot('header')
        {{ $profileUser->name }} favorited <a href="{{ route('threads.show', [
            'channel' => $activity->subject->favorited->thread->channel,
            'thread' => $activity->subject->favorited->thread
        ]) }}#reply-{{ $activity->subject->favorited->id }}">reply</a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent