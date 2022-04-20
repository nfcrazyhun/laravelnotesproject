<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated.');
    }

    public function delete(Request $request, UserService $userService)
    {
        // Get the user
        $user = Auth::user();

        // Log the user out
        Auth::logout();

        // Delete the user (note that softDeleteUser() should return a boolean for below)
        $deleted = $userService->GDPRdelete($user);

        if ($deleted) {
            // User was deleted successfully, redirect to login
            return redirect()->route('home');
        } else {
            // User was NOT deleted successfully, so log them back into your application! Could also use: Auth::loginUsingId($user->id);
            Auth::login($user);

            // Redirect them back with some data letting them know it failed (or handle however you need depending on your setup)
            return back()->with('success', 'Failed to delete your profile');
        }
    }
}
