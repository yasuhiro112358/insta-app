@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    <div class="row justify-content-center">
        <div class="col-4">
            @if ($user->followings->isNotEmpty())
                <h3 class="h5 text-muted mb-3 text-center">Following</h3>

                {{-- loop --}}
                @foreach ($user->followings as $following)
                    <div class="row mb-3 align-items-center">
                        {{-- Avatar --}}
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $following->followedUser->id) }}">
                                @if ($following->followedUser->avatar)
                                    <img src="{{ $following->followedUser->avatar }}" alt=""
                                        class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        {{-- Name --}}
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $following->followedUser->id) }}"
                                class="text-decoration-none fw-bold text-dark">{{ $following->followedUser->name }}</a>
                        </div>
                        {{-- Button --}}
                        <div class="col-auto">
                            @if ($following->followedUser->id != Auth::user()->id)
                                {{-- @if ($following->followed->isFollowing()) --}}
                                @if ($following->followedUser->authIsFollowing())
                                    {{-- Following / Unfollow --}}
                                    <form action="{{ route('follow.destroy', $following->followedUser->id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 text-outline-secondary">Following</button>
                                    </form>
                                @else
                                    {{-- Follow --}}
                                    <form action="{{ route('follow.store', $following->followedUser->id) }}" method="post">
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
                    Not following anyone yet.
                </p>
            @endif
        </div>
    </div>
@endsection
