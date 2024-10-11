<?php
namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 



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

    public function show($id)
    {
        // Fetch the property by ID
        $property = Property::with('images')->findOrFail($id);

        // Return the view with the property data
        return view('properties.show', compact('property'));
    }

    // Show the form to create a new property
    public function create()
    {
        return view('properties.create');
    }

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif' // Image validation
        ]);

        // Create the property
        $property = Property::create($request->only(['title', 'price', 'size', 'lat', 'lng', 'building']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store image in 'storage/app/public/property_images'
                $path = $image->store('property_images', 'public');
                
                // Save the relative path (without 'storage/') to the database
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => $path,  // Store 'property_images/filename.jpg'
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        // Find the property and update it
        $property = Property::findOrFail($id);
        $property->update($request->only(['title', 'price', 'size', 'lat', 'lng', 'building']));

        // Handle new image uploads if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image
                $path = $image->store('property_images', 'public');
                
                // Save the relative path
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => $path,  // Store 'property_images/filename.jpg'
                ]);
            }
        }

        return redirect()->route('properties.index')->with('success', 'Property updated successfully!');
    }


    public function destroy($id)
    {
        // Start logging
        Log::info("Starting the deletion process for property ID: {$id}");

        // Find the property by its ID
        $property = Property::findOrFail($id);
        Log::info("Found property: " . $property->title);

        // Delete all associated images from storage and database
        foreach ($property->images as $image) {
            Log::info("Processing image ID: {$image->id}, URL: {$image->image_url}");

            // Get the relative path stored in the database (e.g., 'property_images/filename.jpg')
            $filePath = $image->image_url;  // Use the exact path stored in the database
            Log::info("Attempting to delete file at path: {$filePath}");

            // Check if the file exists in storage
            if (Storage::exists($filePath)) {
                // Delete the image file from 'storage/app/public/property_images'
                Storage::delete($filePath);
                Log::info("Deleted file: {$filePath}");
            } else {
                Log::warning("File not found: {$filePath}");
            }
            

            // Delete the image record from the database
            $image->delete();
            Log::info("Deleted image record from the database for image ID: {$image->id}");
        }

        // Delete the property itself
        $property->delete();
        Log::info("Deleted property with ID: {$property->id}");

        return redirect()->route('properties.index')->with('success', 'Property and associated images deleted successfully!');
    }

}
