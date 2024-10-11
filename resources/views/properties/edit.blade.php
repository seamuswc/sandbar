@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Edit Property</h1>

    <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-lg font-semibold mb-2">Title</label>
            <input type="text" name="title" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ $property->title }}" required>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="block text-lg font-semibold mb-2">Price</label>
            <input type="text" name="price" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ $property->price }}" required>
        </div>

        <!-- Size (sqm) -->
        <div class="mb-4">
            <label for="size" class="block text-lg font-semibold mb-2">Size (sqm)</label>
            <input type="number" name="size" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ $property->size }}" required>
        </div>

        <!-- Latitude, Longitude (Optional) -->
        <div class="mb-4">
            <label for="lat_lng" class="block text-lg font-semibold mb-2">Latitude, Longitude (optional)</label>
            <input type="text" id="lat_lng" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. 35.68860418172183, 139.70958618971363">
        </div>

        <!-- Latitude -->
        <div class="mb-4">
            <label for="lat" class="block text-lg font-semibold mb-2">Latitude</label>
            <input type="number" name="lat" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ $property->lat }}" required>
        </div>

        <!-- Longitude -->
        <div class="mb-4">
            <label for="lng" class="block text-lg font-semibold mb-2">Longitude</label>
            <input type="number" name="lng" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ $property->lng }}" required>
        </div>

        <!-- Building Name -->
        <div class="mb-4">
            <label for="building" class="block text-lg font-semibold mb-2">Building Name</label>
            <input type="text" name="building" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ $property->building }}" required>
        </div>

        <!-- Upload New Images (Optional) -->
        <div class="mb-4">
            <label for="images" class="block text-lg font-semibold mb-2">Upload New Images (optional)</label>
            <input type="file" name="images[]" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" multiple>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-lg font-semibold mb-2">Description</label>
            <textarea name="description" rows="8" class="form-input w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter property description" required></textarea>
        </div>

        <!-- Update Button -->
        <div class="flex justify-center">
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                Update Property
            </button>
        </div>
    </form>
</div>
@endsection
