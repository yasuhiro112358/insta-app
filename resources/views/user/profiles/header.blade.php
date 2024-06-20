<div class="row mb-5">
    <div class="col-4">
        @if ($user->avatar)
            <button data-bs-toggle="modal" data-bs-target="#user{{ $user->id }}" class="border-0 bg-transparent">
                <img src="{{ $user->avatar }}" alt="" class="rounded-circle image-lg d-block mx-auto">
            </button>

            @include('user.profiles.modals.recent-comments')
        @else
            <i class="fa-solid fa-circle-user icon-lg text-secondary d-block text-center"></i>
        @endif
    </div>
    <div class="col">
        <div class="row mb-3">
            <div class="col-auto">
                <h2 class="display-6 mb-0">{{ $user->name }}</h2>
            </div>
            <div class="col align-self-center">
                @if ($user->id == Auth::user()->id)
                    {{-- Edit profile --}}
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary">Edit Profile</a>
                @else
                    {{-- @if ($user->isFollowing()) --}}
                    @if ($user->authIsFollowing())
                        {{-- unfollow/following --}}
                        <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-secondary">Following</button>
                        </form>
                    @else
                        {{-- Follow --}}
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Follow</button>
                        </form>
                    @endif
                @endif

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->posts->count() }}</span>
                    {{ $user->posts->count() == 1 ? 'post' : 'posts' }}
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->followers->count() }}</span>
                    {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->followings->count() }}</span> following
                </a>
            </div>
        </div>

        <p class="fw-bold">{{ $user->introduction }}</p>
    </div>
</div>
