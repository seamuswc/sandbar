@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Property Listings</h1>

    <a href="{{ route('properties.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add New Property</a>

    @if($properties->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p>No properties available. Click "Add New Property" to create your first listing.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="py-2 px-4 border">Title</th>
                        <th class="py-2 px-4 border">Price</th>
                        <th class="py-2 px-4 border">Size (sqm)</th>
                        <th class="py-2 px-4 border">Location</th>
                        <th class="py-2 px-4 border">Building</th>
                        <th class="py-2 px-4 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($properties as $property)
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border">
                                <a href="{{ route('properties.show', $property->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $property->title }}
                                </a>
                            </td>
                            <td class="py-2 px-4 border">{{ $property->price }}</td>
                            <td class="py-2 px-4 border">{{ $property->size }} sqm</td>
                            <td class="py-2 px-4 border">{{ $property->lat }}, {{ $property->lng }}</td>
                            <td class="py-2 px-4 border">{{ $property->building }}</td>
                            <td class="py-2 px-4 border text-center">
                                <a href="{{ route('properties.edit', $property->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-black py-1 px-3 rounded text-sm mx-1">Edit</a>
                                <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-black py-1 px-3 rounded text-sm mx-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
