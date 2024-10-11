<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .property-container {
            margin: 50px auto;
            max-width: 900px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .property-container h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .property-images {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .property-images img {
            width: 250px;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .property-images img:hover {
            transform: scale(1.05);
        }

        .property-info {
            margin-top: 20px;
        }

        .property-info h2 {
            font-size: 26px;
            color: #555;
            margin-bottom: 15px;
        }

        .property-info p {
            font-size: 18px;
            color: #666;
            line-height: 1.6;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .property-container {
                padding: 20px;
            }

            .property-images img {
                width: 200px;
                height: 150px;
            }

            .property-info h2 {
                font-size: 22px;
            }

            .property-info p {
                font-size: 16px;
            }
        }

    </style>
</head>
<body>
    <div class="property-container">
        <!-- Property Title -->
        <h1>{{ $property->title }}</h1>

        <!-- Property Images Slider -->
        <div class="property-images">
            @foreach($property->images as $image)
                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Property Image">
            @endforeach
        </div>

        <!-- Property Info -->
        <div class="property-info">
            <p><strong>Price:</strong> {{ $property->price }}</p>
            <p><strong>Size:</strong> {{ $property->size }} sqm</p>
            <p><strong>Building:</strong> {{ $property->building }} sqm</p>
            <p>{{ $property->description }}</p>
        </div>
    </div>
</body>
</html>
