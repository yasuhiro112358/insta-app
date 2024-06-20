@if (!$post->trashed())
    {{-- Deactivate --}}
    <div class="modal fade" id="deactivate-post{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header border-danger">
                    <h4 class="h5 text-danger">
                        <i class="fa-solid fa-eye-slash"></i> Hide Post
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to hide this post?
                    </p>
                    {{-- @if ($post->image) --}}
                    <img src="{{ $post->image }}" alt="" class="image-lg mb-3">
                    {{-- @else
                            <i class="fa-solid fa-circle-user text-secondary icon-sm align-middle"></i>
                        @endif --}}
                    <p class="fw-bold">{{ $post->description }}</p>

                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.posts.deactivate', $post->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-bs-dismiss="modal"
                            class="btn btn-sm btn-outline-danger">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger">Hide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Activate --}}
    <div class="modal fade" id="activate-post{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-primary">
                <div class="modal-header border-primary">
                    <h4 class="h5 text-primary">
                        <i class="fa-solid fa-eye"></i>Unhide Post
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to unhide this post?
                    </p>
                    {{-- @if ($user->avatar) --}}
                    <img src="{{ $post->image }}" alt="" class="image-lg mb-3">
                    {{-- @else
                            <i class="fa-solid fa-circle-user text-secondary icon-sm align-middle"></i>
                        @endif --}}
                    <p class="fw-bold">{{ $post->description }}</p>

                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.posts.activate', $post->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <button type="button" data-bs-dismiss="modal"
                            class="btn btn-sm btn-outline-primary">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary">Unhide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
