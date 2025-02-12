@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Banner Details</h1>
        <a href="{{ route('banners.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to List
        </a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-6">
            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="max-w-full h-auto mb-4">
            
            <div class="mb-4">
                <h2 class="text-xl font-bold mb-2">Title</h2>
                <p>{{ $banner->title }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-bold mb-2">Description</h2>
                <p>{{ $banner->description }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-bold mb-2">Created At</h2>
                <p>{{ $banner->created_at->format('F d, Y H:i:s') }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-bold mb-2">Last Updated</h2>
                <p>{{ $banner->updated_at->format('F d, Y H:i:s') }}</p>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('banners.edit', $banner) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Are you sure you want to delete this banner?')">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection