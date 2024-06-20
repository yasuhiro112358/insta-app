@extends('layouts.app')

@section('title', $user->name)

@section('content')
    {{-- Header --}}
    @include('user.profiles.header')

    <div class="row justify-content-center">
        <div class="col-4">
            {{-- Followers --}}
            @if ($user->followers->isNotEmpty())
                <h3 class="h5 text-muted mb-3 text-center">Followers</h3>

                {{-- loop --}}
                @foreach ($user->followers as $follower)
                {{-- ここでの$followは$follower --}}
                    <div class="row mb-3 align-items-center">
                        {{-- Avatar --}}
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $follower->followerUser->id) }}">
                                @if ($follower->followerUser->avatar)
                                    <img src="{{ $follower->followerUser->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        {{-- Name --}}
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $follower->followerUser->id) }}"
                                class="text-decoration-none fw-bold text-dark">{{ $follower->followerUser->name }}</a>
                        </div>
                        {{-- Button --}}
                        <div class="col-auto">
                            @if ($follower->followerUser->id != Auth::user()->id)
                                {{-- @if ($follow->follower->isFollowing()) --}}
                                @if ($follower->followerUser->authIsFollowing())
                                    {{-- Following / Unfollow --}}
                                    <form action="{{ route('follow.destroy', $follower->followerUser->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 text-outline-secondary">Following</button>
                                    </form>
                                @else
                                    {{-- Follow --}}
                                    <form action="{{ route('follow.store', $follower->followerUser->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn p-0 text-primary">Follow</button>
                                    </form>
                                @endif
                            @else
                                {{-- Show nothing --}}
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-muted h5">
                    No followers yet.
                </p>
            @endif
        </div>
    </div>
@endsection
