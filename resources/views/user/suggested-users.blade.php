@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
    <div class="row">
        <div class="col-5 mx-auto">
            {{-- Search --}}
            <form action="{{route('suggested-users')}}" method="get" class="mb-4">
                <input type="text" name="search" placeholder="Search names..." id="" class="form-control form-control">
            </form>

            <h1 class="h3">Suggested</h1>

            {{-- suggestions --}}
            @if ($suggested_users)
                @foreach ($suggested_users as $user)
                    <div class="row mb-3 align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            {{-- Name --}}
                            <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $user->name }}
                            </a>
                            {{-- Email --}}
                            <p class="text-muted m-0"> {{ $user->email }}</p>
                            {{-- Status --}}
                            @if ($user->userIsFollowingAuth())
                                {{-- Follows you --}}
                                <p class="text-muted">Follows you</p>
                            @elseif ($user->followers()->count() == 0)
                                {{-- No Followers --}}
                                <p class="text-muted">No followers yet</p>
                            {{-- @elseif ($user->followers()->count() == 1) --}}
                                {{-- # of Follower --}}
                                {{-- <p class="text-muted">{{ $user->followers()->count() }} follower</p> --}}
                            {{-- @else --}}
                                {{-- # of Followers --}}
                                {{-- <p class="text-muted">{{ $user->followers()->count() }} followers</p> --}}
                            @else
                                <p class="text-muted">
                                    {{ $user->followers()->count() }}&nbsp;{{ $user->followers()->count() == 1 ? 'follower' : 'followers'}}
                                </p>
                            @endif
                        </div>

                        {{-- Follow button --}}
                        <div class="col-auto">
                            {{-- Follow (All suggested are not followed) --}}
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="text-primary border-0 bg-light">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
            @endif

        </div>
    </div>
@endsection
