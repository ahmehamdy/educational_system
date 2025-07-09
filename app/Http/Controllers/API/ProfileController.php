<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data' => $request->user(),
            'message' => 'Profile fetched successfully',
        ], 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|unique:users,phone,' . $user->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== 'def.jpg' && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $image->getClientOriginalExtension();

            $path = $image->storeAs('profile_images', $filename, 'public');
            $data['image'] = $path;
        }

        $user->update($data);

        return response()->json([
            'status' => 200,
            'data' => $user,
            'message' => 'Profile updated successfully',
        ]);
    }



    public function changePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Current password is incorrect',
            ], 401);
        }

        $user->password = bcrypt($data['new_password']);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Password changed successfully',
        ]);
    }




    public function deleteAccount(Request $request)
    {
        $user = $request->user();


        $data = $request->validate([
            'password' => 'required'
        ]);


        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Incorrect password',
            ], 401);
        }

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Account deleted successfully',
        ]);
    }
}
