<!DOCTYPE html>
<html>
<head>
    <title>Real Estate Listings with Image Popup</title>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .swiper-container {
            width: 100%;
            height: 300px;
        }
        .swiper-slide img {
            width: 100%;
            height: auto;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <!-- Include Swiper.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

</head>
<body>
    <h1>Real Estate Listings with Image Popup</h1>
    <div id="map"></div>

    <!-- Modal to show image slider -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="swiper-container">
                <div class="swiper-wrapper" id="swiper-wrapper">
                    <!-- Swiper slides will be dynamically added here -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: { lat: 35.6895, lng: 139.6917 }
        });

        // Fetch properties from Laravel (passed as a JS object)
        var properties = @json($properties);

        // Modal and close button
        var modal = document.getElementById('myModal');
        var closeModal = document.getElementsByClassName('close')[0];

        // Close the modal when clicking on the 'x'
        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Group properties by lat/lng
        var groupedProperties = {};

        properties.forEach(function(property) {
            var latLngKey = property.lat + ',' + property.lng;

            if (!groupedProperties[latLngKey]) {
                groupedProperties[latLngKey] = [];
            }
            groupedProperties[latLngKey].push(property);
        });

        // Loop through each group of properties and create markers
        Object.keys(groupedProperties).forEach(function(latLngKey) {
            var propertiesInSameLocation = groupedProperties[latLngKey];

            // Use the lat/lng of the first property in the group
            var firstProperty = propertiesInSameLocation[0];
            var latLng = { lat: parseFloat(firstProperty.lat), lng: parseFloat(firstProperty.lng) };

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: firstProperty.title
            });

            // Create a single info window for the grouped properties
            var infoWindowContent = "Available!";// = '<h3>Properties at this location:</h3>';

            propertiesInSameLocation.forEach(function(property) {
                infoWindowContent += '<h4>' + property.title + '</h4>' +
                                     '<p>Price: ' + property.price + '<br>' +
                                     'Size: ' + property.size + ' sqm</p>';
            });

            var infoWindow = new google.maps.InfoWindow({
                content: infoWindowContent
            });

            // Add click event listener to the marker
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
        });
    }
</script>


    <!-- Include Swiper.js JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Google Maps API -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVdAS-3mrNYARIDmqn2dP1tG1Khqv5GoM&callback=initMap">
    </script>
</body>
</html>
