<style>
    .modal {
        /* overflow-y: scroll; */
    }

    .modal-body {
        overflow-y: scroll;
        max-height: 350px;
        /* position: absolute;
        top: 65px; */
    }
</style>

<div class="modal fade" id="user{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header border-secondary">
                <h4 class="h5 text-secondary m-0">
                    Recent Comments
                </h4>
            </div>

            <div class="modal-body">
                @forelse ($comments as $comment)
                    <div class="border border-primary rounded p-3 mb-3">
                        <p>{{$comment->body}}</p>
                        <hr>
                        <p class="m-0">Replied to <a href="{{route('post.show', $comment->post->id)}}" class="text-decoration-none">{{$comment->post->user->name}}'s post</a></p>
                    </div>
                @empty
                    no recent comment
                @endforelse
            </div>
            <div class="modal-footer border-0 d-flex justify-content-end">
                <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-secondary">Close</button>
            </div>
        </div>
    </div>
</div>
