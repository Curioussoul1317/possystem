@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Banners</h1>
        <a href="{{ route('banners.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Banner
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">Title</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($banners as $banner)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">
                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="w-20 h-20 object-cover">
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $banner->title }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ Str::limit($banner->description, 100) }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('banners.show', $banner) }}" class="text-blue-500 hover:text-blue-700 mx-2">
                                    View
                                </a>
                                <a href="{{ route('banners.edit', $banner) }}" class="text-yellow-500 hover:text-yellow-700 mx-2">
                                    Edit
                                </a>
                                <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 mx-2" 
                                            onclick="return confirm('Are you sure you want to delete this banner?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-center">No banners found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $banners->links() }}
    </div>
</div>
@endsection