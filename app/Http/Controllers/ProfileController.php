<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('orderItems.product')->orderBy('created_at', 'desc')->get();
        return view('profile', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $data = $request->except(['profile_image', '_token', '_method']);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && File::exists(public_path('assets/uploads/avatars/' . $user->profile_image))) {
                File::delete(public_path('assets/uploads/avatars/' . $user->profile_image));
            }
            
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/uploads/avatars'), $filename);
            $data['profile_image'] = $filename;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}
