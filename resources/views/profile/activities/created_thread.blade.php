@component('profile.activities.activity')
    @slot('header')
        {{ $profileUser->name }} created thread
        <a href="{{ route('threads.show', [
            'channel' => $activity->subject,
            'subject' => $activity->subject
        ]) }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

