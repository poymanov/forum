@forelse($threads as $thread)
    <article>
        <div class="thread-header">
            <div>
                <h4>
                    <a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">
                        @if(auth()->check() && $thread->hasUpdatedFor(auth()->user()))
                            <strong>{{ $thread->title }}</strong>
                        @else
                            {{ $thread->title }}
                        @endif
                    </a>
                </h4>
                <h5>
                    Posted by: <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a>
                </h5>
            </div>

            <a href="{{ route('threads.show', [$thread->channel->slug, $thread]) }}">
                {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
            </a>
        </div>

        <div class="body">{{ $thread->body }}</div>

        <div class="thread-footer">
            {{ $thread->visits() }} visits
        </div>
    </article>
    <hr>
@empty
    There is no threads yet...
@endforelse