<div class="row py-2">
    <div class="col">
        <div class="row">
            <div class="col">
                {{-- Commenter --}}
                <a href="{{ route('profile.show', $comment->user_id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                &nbsp;
                <span class="fw-light">{{ $comment->body }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p class="text-muted xsmall d-inline-block m-0">
                    {{ date('D, M d Y', strtotime($post->created_at)) }}</p>

                @if ($comment->user_id == Auth::user()->id)
                    {{-- Delete Button --}}
                    &middot;
                    <form action="{{route('comment.destroy',$comment->id )}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-danger border-0 bg-white p-0">Delete</a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
