@extends('layouts.app')

@section('content')
    <div class="container">
        <ais-index
            app-id="{{ config('scout.algolia.id') }}"
            api-key="{{ config('scout.algolia.key') }}"
            index-name="threads"
            query="{{ request('q') }}"
        >
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Search results</div>

                        <div class="card-body">
                            <ais-results>
                                <template slot-scope="{ result }">
                                    <p>
                                        <a :href=`/threads/${result.channel.slug}/${result.slug}`>
                                            <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                        </a>
                                    </p>
                                </template>
                            </ais-results>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-default mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <ais-search-box>
                                <ais-input placeholder="Search threads" :autofocus="true" class="form-control"></ais-input>
                            </ais-search-box>
                        </div>
                    </div>
                    <div class="card card-default mb-4">
                        <div class="card-header">Filter by channel</div>
                        <div class="card-body">
                            <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
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
        </ais-index>
    </div>
@endsection