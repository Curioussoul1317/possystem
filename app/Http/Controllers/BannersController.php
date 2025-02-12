<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\banners;
use Illuminate\Support\Facades\Storage;
class BannersController extends Controller
{
      /**
     * Display a listing of banners
     */
    public function index()
    {
        $banners = banners::latest()->paginate(10);
        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created banner
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Store the image
            $imagePath = $request->file('image')->store('banners', 'public');
            
            // Create banner with image path
            banners::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'image' => $imagePath
            ]);

            return redirect()->route('banners.index')
                ->with('success', 'Banner created successfully.');
        }

        return back()->with('error', 'Please upload an image.');
    }

    /**
     * Display the specified banner
     */
    public function show(banners $banners)
    {
        return view('banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified banner
     */
    public function edit(banners $banners)
    {
        return view('banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner
     */
    public function update(Request $request, banners $banners)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update banner data
        $banner->title = $validated['title'];
        $banner->description = $validated['description'];

        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = $imagePath;
        }

        $banner->save();

        return redirect()->route('banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified banner
     */
    public function destroy(banners $banners)
    {
        // Delete the image file
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        // Delete the banner record
        $banner->delete();

        return redirect()->route('banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    /**
     * API method to get all banners
     */
    public function apiIndex()
    {
        $banners = banners::latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $banners
        ]);
    }

    /**
     * API method to store banner
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            
            $banner = banners::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'image' => $imagePath
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Banner created successfully',
                'data' => $banner
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Please upload an image'
        ], 400);
    }
}
