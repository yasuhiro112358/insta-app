<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user_a = $this->user->findOrFail($id);
        $comments = $user_a->comments()->orderBy('created_at', 'desc')->take(5)->get();


        return view('user.profiles.show')
            ->with('user', $user_a)
            ->with('comments', $comments);
    }

    public function edit()
    {
        return view('user.profiles.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,' . Auth::user()->id,
            // adding: unique:<table>,<column>
            // update: unique:<table>,<column>,<id>
            'introduction' => 'max:100'
        ]);

        $user_id = Auth::user()->id;
        $user = $this->user->findOrFail($user_id);

        $img_obj = $request->avatar;
        if ($img_obj !== null) {
            // $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
            $data_uri = $this->generateDataUri($img_obj);
            $user->avatar = $data_uri;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        $user->save();

        return view('user.profiles.show')->with('user', $user);
        // redirectに直す
    }

    // Private Functions
    private function generateDataUri($img_obj)
    {
        $img_extension = $img_obj->extension();
        $img_contents = file_get_contents($img_obj);
        $base64_img = base64_encode($img_contents);

        $data_uri = 'data:image/' . $img_extension . ';base64,' . $base64_img;

        return $data_uri;
    }

    public function followers($id)
    {
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.followers')
            ->with('user', $user_a);
    }

    public function following($id)
    {
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.following')
            ->with('user', $user_a);
    }

    public function updatePassword(Request $request){
        // check old password
        $user_a = $this->user->findOrFail(Auth::user()->id);
        if (!Hash::check($request->old_password, $user_a->password)) {
            // return with validation error
            return redirect()->back()
                ->with('old_password_error', 'Incorrect current password.');
        }

        // validate if old and new password are the same
        if ($request->old_password == $request->new_password) {
            // return with validation error
            return redirect()->back()
                ->with('new_password_error', 'New password cannot be the same as old.');
        }

        // confirm new password
        $request->validate([
            'new_password' => 'required|min:8|confirmed'
        ],[
            'new_password.confirmed' => 'Confirm Password does NOT match with New Password.'
        ]);

        $user_a->password = Hash::make($request->new_password);
        $user_a->save();

        return redirect()->back()
            ->with('success_message', 'Password changed successfully!');
    }
}
