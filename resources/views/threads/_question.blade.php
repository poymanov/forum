<div class="card card-default mb-4" v-if="! editing">
    <div class="card-header show-thread-header">
        <div>
            <img
                src="{{ $thread->creator->avatar_path }}"
                alt="{{ $thread->creator->name }}"
                width="25"
                height="25"
                class="mr-1"
                >
            <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }} ({{ $thread->creator->reputation }} XP)</a> created <span v-text="title"></span>
        </div>
    </div>

    <div class="card-body" v-html="body"></div>

    <div class="card-footer">
        <button class="btn btn-default" @click="editing = true">Update</button>
    </div>
</div>

<div class="card card-default mb-4" v-else>
    <div class="card-header show-thread-header">
        <input type="text" class="form-control" name="title" v-model="form.title">
    </div>

    <div class="card-body">
        <wysiwyg v-model="form.body"></wysiwyg>
    </div>

    <div class="card-footer d-flex">
        <button class="btn btn-primary mr-2" @click="update">Update</button>
        <button class="btn btn-default" @click="resetForm">Cancel</button>

        @can('update', $thread)
            <div class="ml-auto">
                <form method="post" action="{{ route('threads.delete', ['channel' => $thread->channel->name, 'thread' => $thread->slug]) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</div>