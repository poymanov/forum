<div class="card card-default mb-4">
    <div class="card-header">

        <div class="reply-header">
            <div><a href="{{ route('profile.show', $reply->owner) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}</div>
            <div>
                <form method="post" action="/replies/{{ $reply->id }}/favorites">
                    {{ csrf_field() }}
                    <button class="btn" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>