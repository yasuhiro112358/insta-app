{{-- Delete --}}
<div class="modal fade" id="delete-category{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="h5 text-danger">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete <span class="fw-bold">{{ $category->name }}</span> category? <br><br>
                    This action will all the posts under this category. Post without a category will fall under
                    Uncategorized.
                </p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit --}}
<div class="modal fade" id="edit-category{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h4 class="h5 text-warining">
                    <i class="fa-solid fa-pen-to-square"></i>Edit Category
                </h4>
            </div>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    {{-- Input --}}
                    <div class="mb-3">
                        <input type="text" class="form-control" name="update_name"
                            value="{{ old('update_name', $category->name) }}" placeholder="Input new caregory name">
                        @error('update_name')
                            <p class="mb-0 text-danger small">{{ $message }}</p>
                        @enderror
                        {{-- <p class="small text-danger">{{ $message }}</p> --}}
                    </div>
                </div>
                {{-- Buttons --}}
                <div class="modal-footer border-0">

                    <button type="button" data-bs-dismiss="modal"
                        class="btn btn-sm btn-outline-warning">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
