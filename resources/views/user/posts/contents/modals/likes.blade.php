<div class="modal fade" id="liked-post{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h1 class="h4 m-0">Users liked this post</h1>

                <button type="button" data-bs-dismiss="modal" class="border-0 bg-white">
                    <i class="fa-solid fa-xmark text-primary icon-sm"></i>
                </button>
            </div>

            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($post->likes as $like)
                        <li class="list-group-item border-0 d-flex align-items-center">
                            {{-- Avatar --}}
                            @if ($like->user->avatar)
                                <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                            {{-- Username --}}
                            <p class="text-bold m-0 ms-3">{{ $like->user->name }}</p>

                            {{-- Follow/Unfollow --}}
                            @if ($like->user->id == Auth::user()->id)
                                {{-- Show nothing --}}
                            @elseif(!$like->user->authIsFollowing())
                                <form action="{{ route('follow.store', $like->user->id) }}" method="post" class="d-block ms-auto">
                                    @csrf

                                    <button type="submit" class="btn p-0 text-primary">Follow</button>
                                </form>
                            @else
                                <form action="{{ route('follow.destroy', $like->user->id) }}" method="post" class="d-block ms-auto">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn p-0 text-secondary">Unfollow</button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
