<!DOCTYPE html>
<html>

<head>
    <title>Geolocation Info</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <form method="GET" action="/">
        <input type="text" name="ip" placeholder="Enter IP Address" required>
        <button type="submit">Get Geolocation</button>
    </form>

    @if (isset($error))
        <p>{{ $error }}</p>
    @else
        <p>IP Address: {{ $ip }}</p>
        <p>Country: {{ $country }}</p>
        <p>Region: {{ $region }}</p>
        <p>City: {{ $city }}</p>
        <p>Latitude: {{ $latitude }}</p>
        <p>Longitude: {{ $longitude }}</p>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map)
            .bindPopup('Location: {{ $city }}, {{ $region }}, {{ $country }}')
            .openPopup();
    </script>
    @endif

</body>

</html>
