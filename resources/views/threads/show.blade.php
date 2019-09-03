@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                        </span>
                        @can ('update', $thread)
                            <form action="{{ $thread->path() }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-link">Delete Thread</button>
                            </form>
                        @endcan    
                    </div>
    
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            <br>

            @foreach ($replies as $reply)
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <h6  class="flex">
                                <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a>
                                said {{ $reply->created_at->diffForHumans() }}...
                            </h6>
                            <div>
                                <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
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
                <br>
            @endforeach

            {{ $replies->links() }}

        @if (auth()->check())
            <form method="POST" action="{{ $thread->path() . '/replies' }}" >
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body"class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                </div>

                <button type="submit" class="btn btn-default">Post</button>
            </form>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>    
        @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This Thread was published {{ $thread->created_at->diffForHumans() }} by
                    <a href="">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
