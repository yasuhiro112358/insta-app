<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function create()
    {
        $all_categories = $this->category->all();

        return view('user.posts.create')
            ->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'required|max:1048|mimes:jpeg,jpg,png,gif',
        ]);

        $this->post->description = $request->description;

        // $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));

        // Image objectの取得
        $img_obj = $request->image;
        // Image objectをbase64形式の文字列（URI）に変換 (Private Function↓)
        $data_uri = $this->generateDataUri($img_obj);
        // DBへの格納場所を指示
        $this->post->image = $data_uri;

        $this->post->user_id = Auth::user()->id;

        $this->post->save();

        // 最新のレコードのIDを取得
        $post_id = $this->post->id;

        $category_posts = [];
        foreach ($request->categories as $category_id) {
            // $category_posts[] = ['category_id' => $category_id];
            $category_posts[] = [
                'category_id' => $category_id,
                'post_id' => $post_id // あえて明示
            ];
        }
        $this->post->categoryPosts()->createMany($category_posts);
        // この$this->postは->save()直後なので、最新のレコードのIDを持つ。
        // Post model hasMany categoryPosts modelのリレーションを使って、対象をPivot Tableから複数選択し、複数のレコードを一括保存する

        return redirect()->route('home');
    }

    public function show($id)
    {
        $post_a = $this->post->findOrFail($id);

        return view('user.posts.show')
            ->with('post', $post_a);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);
        $all_categories = $this->category->all();

        $selected_categories = [];
        foreach ($post->categoryPosts as $category_post) {
            $selected_categories[] = $category_post->category_id;
        }

        return view('user.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpeg,jpg,png,gif',
        ]);

        $post = $this->post->findOrFail($id);

        $post->description = $request->description;

        $img_obj = $request->image;
        if ($img_obj !== null) {
            // $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));

            // Image objectの取得
            $img_obj = $request->image;
            // Image objectをbase64形式の文字列（URI）に変換 (Private Function↓)
            $data_uri = $this->generateDataUri($img_obj);
            // DBへの格納場所を指示
            $post->image = $data_uri;
        }

        $post->user_id = Auth::user()->id;
        $post->save();

        // Update Pivot
        $post->categoryPosts()->delete(); // 関係する全てのcategoryを削除

        $category_posts = [];
        foreach ($request->categories as $category_id) {
            $category_posts[] = [
                'category_id' => $category_id,
                'post_id' => $id // あえて明示
            ];
        }
        $post->categoryPosts()->createMany($category_posts);

        return redirect()->route('post.show', $id);
    }

    public function destroy($id)
    {
        $post_a = $this->post->findOrFail($id);
        $post_a->forceDelete(); // for db with soft delete

        return redirect()->route('home');
    }

    // ==== Private Functions ====
    private function generateDataUri($img_obj)
    {
        $img_extension = $img_obj->extension();
        $img_contents = file_get_contents($img_obj);
        $base64_img = base64_encode($img_contents);

        $data_uri = 'data:image/' . $img_extension . ';base64,' . $base64_img;

        return $data_uri;
    }
}
