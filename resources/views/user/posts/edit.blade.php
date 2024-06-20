@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{route('post.update', $post->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <label for="categories" class="form-label fw-bold">
            Category
            <span class="fw-light">( up to 3 )</span>
        </label>
        <div>
            @forelse ($all_categories as $category)
                <div class="form-check form-check-inline">
                    @if (in_array($category->id, $selected_categories))
                        <input type="checkbox" name="categories[]" class="form-check-input" id="{{ $category->name }}"
                            value="{{ $category->id }}" checked>
                    @else
                        <input type="checkbox" name="categories[]" class="form-check-input" id="{{ $category->name }}"
                            value="{{ $category->id }}">
                    @endif
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
            class="form-control">{{ old('description', $post->description) }}</textarea>
        @error('description')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        {{-- Image --}}
        <label for="image" class="form-label fw-bold mt-3">Image</label>
        {{-- Show Image --}}
        <img src="{{ $post->image }}" alt="" class="w-50 d-block img-thumbnail mb-3">
        {{-- Input --}}
        <input type="file" name="image" id="image" class="form-control">
        <p class="form-text">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Max size is 1048 KB
        </p>
        @error('image')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn btn-warning px-4 mt-4">Save</button>
    </form>
@endsection
