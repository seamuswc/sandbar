<!DOCTYPE html>
<html lang="en">
<head>
    <title>Real Estate Listings</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #map {
            height: 500px;
            width: 100%;
            flex-grow: 1;
        }

        /* Header Styles */
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
        }

        header .logo {
            font-size: 30px;
            font-weight: bold;
        }

        header .logo img {
            height: 60px;
            width: 200px;
            vertical-align: middle;
        }

        header .map-links {
            display: flex;
            gap: 15px; /* Adds spacing between links */
            font-size: 18px;
        }

        header .map-links a {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
        }

        header .contact-info {
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        header .contact-info span {
            margin-right: 15px;
        }

        header .contact-info a {
            color: #fff;
            margin-left: 15px;
            text-decoration: none;
        }

        header .contact-info img {
            width: 28px;
            height: 28px;
            margin-left: 10px;
        }

        /* Hide Map Links on Mobile */
        @media (max-width: 768px) {
            .map-links {
                display: none;
            }

            header {
                flex-direction: column;
                text-align: center;
                font-size: 16px;
            }

            #map {
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="{{ asset('images/gold_logo_text.png') }}" alt="Company Logo"> 
        </div>
        
        <!-- Map Links -->
        <div class="map-links">
            <a onclick="zoomToLocation(12.9495, 100.8875)">North Pattaya</a> <!-- Updated coordinate for North Pattaya -->
            <a onclick="zoomToLocation(12.9352, 100.8985)">Central Pattaya</a> <!-- Updated coordinate for Central Pattaya -->
            <a onclick="zoomToLocation(12.9242, 100.8786)">South Pattaya</a> <!-- Updated coordinate for South Pattaya -->
            <a onclick="zoomToLocation(12.9179, 100.8551)">Pratumnak Hill</a> <!-- Updated coordinate for Pratumnak Hill -->
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
            <span class="phone-number">+66 61 724 6882</span>
            <a href="https://line.me/ti/p/mGH5q9eE4F">
                <img src="{{ asset('images/line.png') }}" alt="Line Icon">      
            </a>
            <a href="https://wa.me/+66617246882">
                <img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp Icon">
            </a>
        </div>
    </header>

    <!-- Map -->
    <div id="map"></div>

    <script>
        let map;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: { lat: 12.9164, lng: 100.8722 },
                gestureHandling: 'greedy',
                mapTypeControl: false
            });

            const properties = @json($properties);
            const groupedProperties = {};
            properties.forEach((property) => {
                const latLngKey = `${property.lat},${property.lng}`;
                if (!groupedProperties[latLngKey]) {
                    groupedProperties[latLngKey] = [];
                }
                groupedProperties[latLngKey].push(property);
            });

            Object.keys(groupedProperties).forEach((latLngKey) => {
                const propertiesInSameLocation = groupedProperties[latLngKey];
                const firstProperty = propertiesInSameLocation[0];
                const latLng = { lat: parseFloat(firstProperty.lat), lng: parseFloat(firstProperty.lng) };

                const bunnyIcon = {
                    url: "{{ asset('images/rabbit2.png') }}",
                    scaledSize: new google.maps.Size(30, 30)
                };

                const marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: firstProperty.title,
                    icon: bunnyIcon
                });

                let infoWindowContent = '';
                propertiesInSameLocation.forEach((property, index) => {
                    if (index > 0) infoWindowContent += '<br>';
                    let propertyUrl = "{{ route('properties.show', ':id') }}".replace(':id', property.id);
                    infoWindowContent += `<a href="${propertyUrl}" target="_blank" style="font-size: 16px; font-weight: bold;">${property.title}</a>
                                          <div style="font-size: 14px; font-weight: bold;">
                                              Price: ${property.price} | Size: ${property.size} sqm
                                          </div>`;
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: infoWindowContent
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
            });
        }

        // Function to zoom and center the map at a given latitude and longitude
        function zoomToLocation(lat, lng) {
            map.setCenter({ lat: lat, lng: lng });
            map.setZoom(15); // Adjust the zoom level as needed
        }
    </script>

    <!-- Include Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVdAS-3mrNYARIDmqn2dP1tG1Khqv5GoM&callback=initMap"></script>
</body>
</html>
