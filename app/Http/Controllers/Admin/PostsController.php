<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index(Request $request)
    {

        if ($request->search) {
            $posts = $this->post->where('description', 'LIKE', '%'.$request->search.'%')->orderBy('created_at', 'desc')
                ->withTrashed()->paginate(10);
        } else {
            $posts = $this->post->orderBy('created_at', 'desc')
                ->withTrashed()->paginate(10);
            // paginate(n)
            // withTrashed - show all records, including soft-deleted
        }


        return view('admin.posts.index')
            ->with('posts', $posts)
            ->with('search', $request->search);
    }

    public function deactivate($id)
    {
        $this->post->destroy($id);

        return redirect()->back();
    }

    public function activate($id)
    {
        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }
}
