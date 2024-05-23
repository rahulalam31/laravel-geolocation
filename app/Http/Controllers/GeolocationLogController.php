<?php

namespace App\Http\Controllers;

use App\Interfaces\GeolocationServiceInterface;
use App\Models\GeolocationLog;
use Illuminate\Http\Request;

class GeolocationLogController extends Controller
{
    protected $geoService;

    public function __construct(GeolocationServiceInterface $geoService)
    {
        $this->geoService = $geoService;
    }

    public function index(Request $request)
    {
        $ip = $request->input('ip', $request->ip());
        $geoData = $this->geoService->getGeolocation($ip);

        // dd($geoData);
        if ($geoData) {
            return view('welcome', [
                'ip' => $ip,
                'country' => $geoData['country_name'],
                'region' => $geoData['state_prov'],
                'city' => $geoData['city'],
                'latitude' => $geoData['latitude'],
                'longitude' => $geoData['longitude'],
            ]);
        }

        return view('welcome', ['error' => 'Unable to fetch geolocation data.']);
    }

    public function store(Request $request)
    {
        $ip = $request->ip();
        $geoData = $this->geoService->getGeolocation($ip);

        if ($geoData) {
            GeolocationLog::create([
                'ip_address' => $ip,
                'country' => $geoData['country'],
                'region' => $geoData['region'],
                'city' => $geoData['city'],
                'latitude' => $geoData['latitude'],
                'longitude' => $geoData['longitude'],
            ]);
        }

        return response()->json(['message' => 'Geolocation data stored successfully.']);
    }
}
