<!DOCTYPE html>
<html lang="en">
<head>
    <title>Real Estate Listings</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="{{ asset('images/gold_logo_text.png') }}" alt="Company Logo"> 
        </div>
        
        <!-- Map Links -->
        <div class="map-links">
        <div class="map-links">
            <a onclick="zoomToLocation(12.9495, 100.8875, 15)">North</a> <!-- Updated coordinate for North Pattaya -->
            <a onclick="zoomToLocation(12.9352, 100.8985, 15)">Central</a> <!-- Updated coordinate for Central Pattaya -->
            <a onclick="zoomToLocation(12.9242, 100.8786, 15)">South</a> <!-- Updated coordinate for South Pattaya -->
            <a onclick="zoomToLocation(12.9179, 100.8551, 15)">Pratumnak</a> <!-- Updated coordinate for Pratumnak Hill -->
            <a onclick="zoomToLocation(12.8900, 100.8700, 14)">Jomtien</a> <!-- Southeast Jomtien -->
        </div>

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
        function zoomToLocation(lat, lng, zoom) {
            map.setCenter({ lat: lat, lng: lng });
            map.setZoom(zoom);
        }
    </script>

    <!-- Include Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVdAS-3mrNYARIDmqn2dP1tG1Khqv5GoM&callback=initMap"></script>
</body>
</html>
