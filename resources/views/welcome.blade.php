<!DOCTYPE html>
<html>

<head>
    <title>Geolocation Info</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        .container {
            margin: auto;
            width: 50%;
            border: 3px solid green;
            padding: 10px;
        }

        #map {
            height: 300px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST" action="/">
            @csrf
            <input type="text" name="ip" placeholder="Enter IP Address" required>
            <button type="submit">Get Geolocation</button>
        </form>

        @if (isset($geoData))
            <p>IP Address: {{ $geoData->ip_address }}</p>
            <p>Country: {{ $geoData->country }}</p>
            <p>Region: {{ $geoData->region }}</p>
            <p>City: {{ $geoData->city }}</p>
            <p>Latitude: {{ $geoData->latitude }}</p>
            <p>Longitude: {{ $geoData->longitude }}</p>

            <div id="map"></div>
            <script>
                var map = L.map('map').setView([{{ $geoData->latitude }}, {{ $geoData->longitude }}], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                L.marker([{{ $geoData->latitude }}, {{ $geoData->longitude }}]).addTo(map)
                    .bindPopup('Location: {{ $geoData->city }}, {{ $geoData->region }}, {{ $geoData->country }}')
                    .openPopup();
            </script>
        @else
            <p>{{ $error }}</p>
        @endif

    </div>

</body>

</html>
