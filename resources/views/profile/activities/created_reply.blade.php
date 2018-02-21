@component('profile.activities.activity')
    @slot('header')
        {{ $profileUser->name }} replied to thread
        <a href="{{ route('threads.show', [
            'channel' => $activity->subject->thread->channel,
            'subject' => $activity->subject->thread
        ]) }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent