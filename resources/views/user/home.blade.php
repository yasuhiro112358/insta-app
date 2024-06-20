@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        {{-- Main Content --}}
        <div class="col-8">
            {{-- Posts --}}
            @if ($search)
                <h2 class="h4 text-muted mb-4">Search results for '<span class="fw-bold">{{ $search }}</span>'</h2>
            @endif
            @forelse ($all_posts as $post)
                <div class="card mb-4">
                    @include('user.posts.contents.title')

                    <div class="container p-0">
                        <a href="{{ route('post.show', $post->id) }}">
                            <img src="{{ $post->image }}" alt="" class="w-100">
                        </a>
                    </div>

                    <div class="card-body">
                        @include('user.posts.contents.body')

                        {{-- comments --}}
                        @if ($post->comments->isNotEmpty())
                            <hr class="my-3">

                            @foreach ($post->comments->take(3) as $comment)
                                @include('user.posts.contents.comments.list-item')
                            @endforeach

                            @if ($post->comments->count() > 3)
                                <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">
                                    Veiw all {{ $post->comments->count() }} comments
                                </a>
                            @endif
                        @endif

                        @include('user.posts.contents.comments.create')
                    </div>
                </div>
            @empty
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
                </div>
            @endforelse
        </div>

        {{-- Side bar --}}
        <div class="col-4">
            {{-- user info --}}
            <div class="row align-items-center bg-white py-3 shadow-sm mb-5 rounded-3">
                <div class="col-auto">
                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>

                <div class="col ps-0">
                    <a href="{{ route('profile.show', Auth::user()->id) }}"
                        class="text-decoration-none text-dark fw-bold d-block">
                        {{ Auth::user()->name }}
                    </a>
                    <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- suggestions --}}
            @if ($suggested_users)
                <div class="row mb-3">
                    {{-- Suggestions For You --}}
                    <div class="col">
                        <p class="text-secondary fw-bold">Suggestions For You</p>
                    </div>
                    {{-- See all --}}
                    <div class="col-auto">
                        <a href="{{ route('suggested-users') }}" class="text-decoration-none fw-bold text-dark">See all</a>
                    </div>
                </div>

                @foreach ($suggested_users as $user)
                    <div class="row mb-3 align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $user->id) }}"
                                class="text-decoration-none text-dark fw-bold">
                                {{ $user->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn p-0 text-primary">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
            @endif
        </div>
    </div>
@endsection
