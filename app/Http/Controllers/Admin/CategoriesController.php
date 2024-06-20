<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->orderBy('name')
            // ->withTrashed()
            ->paginate(10);
        // paginate(n)
        // withTrashed - show all records, including soft-deleted

        return view('admin.categories.index')
            ->with('categories', $categories);
    }

    public function store(Request $request){
        $request->validate([
            'add_name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = $request->add_name;

        $this->category->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->category->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'update_name' => 'required|max:50|unique:categories,name'
        ]);

        $category = $this->category->findOrFail($id);
        $category->name = $request->update_name;
        $category->save();

        return redirect()->back();
    }


}
