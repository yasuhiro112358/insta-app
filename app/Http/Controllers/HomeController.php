<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->search) {
            # result
            $home_posts = $this->post->where('description', 'LIKE', '%' . $request->search . '%')->latest()->get();
        } else {
            // regular
            $all_posts = $this->post->latest()->get();

            $home_posts = [];
            foreach ($all_posts as $post) {
                if (
                    $post->user->authIsFollowing() ||
                    $post->user_id == Auth::user()->id
                ) {
                    $home_posts[] = $post;
                }
            }
        }

        return view('user.home')
            ->with('all_posts', $home_posts)
            ->with('suggested_users', $this->getSuggestedUsers(''))
            ->with('search', $request->search);
    }

    // Suggested Users
    public function getSuggestedUsers()
    // public function getSuggestedUsers($search)
    {
        // if ($search == '') {
            $all_users = $this->user->all()->except(Auth::user()->id);
            // ->except(primary_key)
        // } else {
        //     $all_users = $this->user->where('name', 'LIKE', '%' . $search . '%')->except(Auth::user()->id);
        // }


        $suggested = [];
        $count = 0;
        foreach ($all_users as $user) {
            if (
                !$user->authIsFollowing() &&
                $count < 10
            ) {
                $suggested[] = $user;
                $count++;
            }
        }

        return $suggested;
    }

    public function getSuggestedUsersSearched($search)
    // public function getSuggestedUsers($search)
    {
        // if ($search == '') {
            $all_users = $this->user->where('name', 'LIKE', '%'.$search.'%')->get()->except(Auth::user()->id);
            // ->except(primary_key)
        // } else {
        //     $all_users = $this->user->where('name', 'LIKE', '%' . $search . '%')->except(Auth::user()->id);
        // }


        $suggested = [];
        $count = 0;
        foreach ($all_users as $user) {
            if (
                !$user->authIsFollowing() &&
                $count < 10
            ) {
                $suggested[] = $user;
                $count++;
            }
        }

        return $suggested;
    }

    public function suggestedUsers(Request $request)
    {
        if ($request->search) {
            $suggested_users = $this->getSuggestedUsersSearched($request->search);
        } else {
            $suggested_users = $this->getAllSuggestedUsers();
        }

        return view('user.suggested-users')
            ->with('suggested_users', $suggested_users);
    }

    public function getAllSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        // ->except(primary_key)

        $suggested_users = [];
        foreach ($all_users as $user) {
            if (!$user->authIsFollowing()) {
                $suggested_users[] = $user;
            }
        }

        return $suggested_users;
    }
}
