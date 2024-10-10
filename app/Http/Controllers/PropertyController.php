<?php
namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{

    public function showMap()
    {
        // Get all properties with their associated images
        $properties = Property::with('images')->get();
       return view('index', compact('properties'));
    }

    // Display all properties for all users
    public function index()
    {
       // Get all properties with their associated images
        $properties = Property::with('images')->get();
       return view('properties.index', compact('properties'));
    }

    // Show the form to create a new property
    // Show the form for creating a new property
    public function create()
    {
        return view('properties.create');
    }

    // Store a newly created property in the database
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required',
            'size' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'building' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Image validation
        ]);

        // Create the property
        $property = Property::create($request->only(['title', 'price', 'size', 'lat', 'lng', 'building']));

        // Handle the image uploads if there are any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('property_images', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => str_replace('public/', 'storage/', $path),
                ]);
            }
        }

        return redirect()->route('properties.index')->with('success', 'Property added successfully!');
    }

    // Show the form to edit a property
    public function edit($id)
    {
        // Find the property by its ID
        $property = Property::findOrFail($id);
        return view('properties.edit', compact('property'));
    }

    // Update an existing property
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required',
            'size' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'building' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Find the property and update it
        $property = Property::findOrFail($id);
        $property->update($request->only(['title', 'price', 'size', 'lat', 'lng', 'building']));

        // Handle image uploads if new images are uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/property_images');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => str_replace('public/', 'storage/', $path),
                ]);
            }
        }

        return redirect()->route('properties.index')->with('success', 'Property updated successfully!');
    }

    // Delete a property
    public function destroy($id)
    {
        // Find the property by its ID and delete it
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully!');
    }
}
