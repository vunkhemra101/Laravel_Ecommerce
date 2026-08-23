<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/uploads/banners'), $filename);
        }

        Banner::create([
            'image' => $filename,
            'is_active' => $request->has('is_active') ? 'active' : 'inactive',
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
    }

    public function toggle($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = $banner->is_active == 'active' ? 'inactive' : 'active';
        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner status updated');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && File::exists(public_path('assets/uploads/banners/' . $banner->image))) {
            File::delete(public_path('assets/uploads/banners/' . $banner->image));
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted');
    }
}
