<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ListUploadedImages extends Command
{
    // The name and signature of the console command
    protected $signature = 'images:list';

    // The console command description
    protected $description = 'List all uploaded images from property_images directory';

    // Execute the console command
    public function handle()
    {
        // Specify the directory where images are physically stored
        $directory = 'property_images'; // No need for 'storage/' prefix since we're using 'public' disk

        // Get all files in the directory
        $files = Storage::disk('public')->files($directory);

        // Filter to include only image files
        $images = array_filter($files, function ($file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        // Display only the file names
        if (empty($images)) {
            $this->info('No images found.');
        } else {
            $this->info('Uploaded Images:');
            foreach ($images as $image) {
                $this->line(basename($image)); // Display only the file name
            }
        }

        return 0;
    }
}
