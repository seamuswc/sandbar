<!DOCTYPE html>
<html lang="en">
<head>
    <title>Real Estate Listings</title>
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
            flex-grow: 1; /* Make the map take up remaining space */
        }

        /* Header Styles */
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 20px; /* Increased padding for larger header */
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px; /* Increase font size */
        }

        header .logo {
            font-size: 30px; /* Increased logo font size */
            font-weight: bold;
        }

        header .logo img {
            height: 50px; /* Increased logo height */
            vertical-align: middle;
        }

        header .contact-info {
            font-size: 18px; /* Increased contact info font size */
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
            width: 28px; /* Increased icon size */
            height: 28px;
            margin-left: 10px;
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
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            text-align: center;
        }

        .modal img {
            width: 100%;
            max-width: 600px;
            height: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
                font-size: 16px; /* Slightly smaller for mobile */
            }

            header .logo, header .contact-info {
                margin: 10px 0;
            }

            #map {
                height: 300px;
            }

            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="logo.png" alt="Company Logo"> Real Estate
        </div>
        <div class="contact-info">
            <span>Phone: +66 61 724 6882</span>
            <a>
                <img src="{{ asset('images/line.png') }}" alt="Line Icon">
            </a>
            <a>
                <img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp Icon">
            </a>
        </div>
    </header>

    <!-- Map -->
    <div id="map"></div>

    <!-- Modal to show image -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="Property Image">
        </div>
    </div>

    <script>
       function initMap() {
           

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15, // Adjust the zoom level as needed
                center: { lat: 12.9164, lng: 100.8622 } // Pratamnak Hill, Pattaya
            });


            // Fetch properties from Laravel (passed as a JS object)
            var properties = @json($properties);

            // Group properties by lat/lng
            var groupedProperties = {};

            properties.forEach(function (property) {
                var latLngKey = property.lat + ',' + property.lng;

                if (!groupedProperties[latLngKey]) {
                    groupedProperties[latLngKey] = [];
                }
                groupedProperties[latLngKey].push(property);
            });

            // Loop through each group of properties and create markers
            Object.keys(groupedProperties).forEach(function (latLngKey) {
                var propertiesInSameLocation = groupedProperties[latLngKey];

                // Use the lat/lng of the first property in the group
                var firstProperty = propertiesInSameLocation[0];
                var latLng = { lat: parseFloat(firstProperty.lat), lng: parseFloat(firstProperty.lng) };

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: firstProperty.title
                });

                var infoWindowContent = '';  // No space at the top of the popup

                propertiesInSameLocation.forEach(function (property, index) {
                    // Add new empty line only between different properties
                    if (index > 0) {
                        infoWindowContent += '<br>';  // Add a line break between properties
                    }
                    // Check if the property has images and the images array is defined
                    if (property.images && property.images.length > 0) {
                        var imageUrl = "{{ asset('storage/') }}" + '/' + property.images[0].image_url; // Use the first image for now

                        // Open image popup when title is clicked
                        infoWindowContent += '<div style="font-size: 16px; font-weight: bold; cursor: pointer;" onclick="openImageModal(\'' + imageUrl + '\')">' + 
                                                property.title + 
                                            '</div>' +
                                            '<div style="font-size: 14px; font-weight: bold;">' + 
                                                'Price: ' + property.price + ' | ' +
                                                'Size: ' + property.size + ' sqm' +
                                            '</div>';
                    } else {
                        // No images available, display a placeholder or skip the image logic
                        infoWindowContent += '<div style="font-size: 16px; font-weight: bold; cursor: pointer;" onclick="openImageModal(\'placeholder.jpg\')">' + 
                                                property.title + 
                                            '</div>' +
                                            '<div style="font-size: 14px; font-weight: bold;">' + 
                                                'Price: ' + property.price + ' | ' +
                                                'Size: ' + property.size + ' sqm' +
                                            '</div>';
                    }
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: infoWindowContent
                });

                // Add click event listener to the marker
                marker.addListener('click', function () {
                    infoWindow.open(map, marker);
                });
            });
        }

        // Function to open the modal and display the image
        function openImageModal(imageSrc) {
            var modal = document.getElementById('imageModal');
            var modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;  // Set the image source to the clicked property's image
            modal.style.display = "block";  // Display the modal
        }

        // Close modal functionality
        var modal = document.getElementById('imageModal');
        var closeModal = document.getElementsByClassName('close')[0];

        // Close the modal when clicking on the 'x'
        closeModal.onclick = function() {
            modal.style.display = "none";
        };

        // Close the modal when clicking outside the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>

    <!-- Include Google Maps API -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVdAS-3mrNYARIDmqn2dP1tG1Khqv5GoM&callback=initMap">
    </script>
</body>
</html>
