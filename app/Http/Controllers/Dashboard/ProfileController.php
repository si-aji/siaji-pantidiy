<?php

namespace App\Http\Controllers\Dashboard;

use Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('content.dashboard.profile.index');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();

        return redirect()->route('dashboard.profile.index')->with([
            'action' => 'Profile Update',
            'message' => 'Profile successfully updated'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'password' => ['required', 'string', 'confirmed', 'min:5'],
            'old_password' => ['required', 'string']
        ]);
        if(!Hash::check($request->old_password, $user->password)){
            return response()->json([
                'errors' => [
                    'old_password' => "Old Password didn't match"
                ]
            ], 422);
        } else if(Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'password' => "Cannot use current password as new password"
                ]
            ], 422);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'action' => 'Password Update',
            'message' => 'Password successfully updated'
        ]);
    }
}
