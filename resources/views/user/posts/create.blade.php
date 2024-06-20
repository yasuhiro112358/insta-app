@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="categories" class="form-label fw-bold">
            Category
            <span class="fw-light">( up to 3 )</span>
        </label>
        <div>
            @forelse ($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="categories[]" class="form-check-input" id="{{ $category->name }}"
                        value="{{ $category->id }}">
                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                </div>
            @empty
                <span class="font-italic">No categories yet.</span>
            @endforelse
        </div>
        @error('categories')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <label for="description" class="form-label fw-bold mt-3">Description</label>
        <textarea name="description" id="description" cols="" rows="3" placeholder="What's on your mind"
            class="form-control">{{ old('description') }}</textarea>
        @error('description')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror


        <label for="image" class="form-label fw-bold mt-3">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <p class="form-text">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Max size is 1048 KB
        </p>
        @error('image')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror


        <button type="submit" class="btn btn-primary px-4 mt-4">Post</button>
    </form>
@endsection
