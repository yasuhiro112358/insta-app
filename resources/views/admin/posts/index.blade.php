@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    {{-- search --}}
    <form action="{{ route('admin.posts') }}" method="get">
        <div class="row mb-3">
            <div class="col-3 ms-auto">
                <input type="text" name="search" value="{{$search}}" placeholder="search..." id="" class="form-control bg-white">
            </div>
        </div>
    </form>

    <table class="table border table-hover align-middle bg-white text-secondary">
        <thead class="table-primary text-secondary text-uppercase small">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    {{-- ID --}}
                    <td>
                        {{ $post->id }}
                    </td>
                    {{-- Image --}}
                    <td>
                        <a href="{{ route('post.show', $post->id) }}">
                            <img src="{{ $post->image }}" alt="" class="d-block mx-auto image-lg">
                        </a>
                    </td>
                    {{-- Categories --}}
                    <td>
                        {{-- categories --}}
                        @forelse ($post->categoryPosts as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</div>
                        @empty
                            <div class="badge bg-dark">Uncategorized</div>
                        @endforelse
                    </td>
                    {{-- Owner --}}
                    <td>
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                            {{ $post->user->name }}
                        </a>
                    </td>
                    {{-- Created at --}}
                    <td>{{ date('Y-m-d H:i:s', strtotime($post->created_at)) }}</td>
                    {{-- Status --}}
                    <td>
                        @if ($post->trashed())
                            <i class="fa-solid fa-circle-minus"></i> Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i> Visible
                        @endif
                    </td>
                    {{-- Menu --}}
                    <td>
                        {{-- @if ($post->id != Auth::user()->id) --}}
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="dropdown-menu">
                                @if ($post->trashed())
                                    {{-- Make it visible --}}
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#activate-post{{ $post->id }}">
                                        <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                    </button>
                                @else
                                    {{-- Make it hidden --}}
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deactivate-post{{ $post->id }}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                    </button>
                                @endif
                            </div>
                        </div>

                        @include('admin.posts.actions')
                        {{-- @endif --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="7">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Link --}}
    {{ $posts->links() }}
@endsection
