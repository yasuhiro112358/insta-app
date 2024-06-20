@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    {{-- Input --}}
    <form action="{{ route('admin.categories.store') }}" method="post">
        @csrf

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <input type="text" class="form-control bg-white" name="add_name" id="" placeholder="Add a category...">
                    @error('add_name')
                        <p class="mb-0 text-danger small">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>Add
                </button>
            </div>
        </div>
    </form>

    <table class="table border table-hover align-middle bg-white text-warning">
        <thead class="table-warning text-secondary text-uppercase small">
            <tr>
                <th>#</th>
                <th>NAME</th>
                <th>COUNT</th>
                <th>LAST UPDATED</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    {{-- ID --}}
                    <td>
                        {{ $category->id }}
                    </td>
                    {{-- NAME --}}
                    <td>
                        {{ $category->name }}
                    </td>
                    {{-- Count --}}
                    <td>
                        {{ $category->categoryPosts()->count() }}
                    </td>
                    {{-- last update --}}
                    <td>
                        {{ date('Y-m-d H:i:s', strtotime($category->updated_at)) }}
                    </td>
                    {{-- buttons --}}
                    <td>
                        {{-- Update --}}
                        {{-- <div class="dropdown-item d-inline-block"> --}}
                        <button class="btn btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#edit-category{{ $category->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        {{-- </div> --}}

                        {{-- Delete --}}
                        {{-- <div class="dropdown-item d-inline-block"> --}}
                        <button class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#delete-category{{ $category->id }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @include('admin.categories.actions')
                        {{-- </div> --}}

                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">No Categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Link --}}
    {{ $categories->links() }}
@endsection
