<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card card-default mb-4">
        <div class="card-header">

            <div class="reply-header">
                <div><a href="{{ route('profile.show', $reply->owner) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}</div>
                <div>
                    @if(auth()->check())
                        <favorite :reply="{{ $reply }}"></favorite>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body" v-if="editing === true">
            <p>
                <textarea name="edit-reply" rows="5" class="form-control" v-model="body"></textarea>
            </p>

            <button class="btn btn-primary" @click="update">Update</button>
            <button class="btn btn-link" @click="editing = false">Cancel</button>
        </div>

        <div class="card-body" v-else-if="editing === false" v-text="body"></div>

        @can('update', $reply)
            <div class="card-footer d-flex">
                <button class="btn btn-primary mr-2" @click="editing = true">Edit</button>
                <button class="btn btn-danger" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>