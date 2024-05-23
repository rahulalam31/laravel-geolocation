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
        // dd($request);
        $geoData = $this->geoService->getGeolocation($ip);

        if ($geoData) {
            return view('welcome', compact('geoData'));

        } else{
            return view('welcome', ['error' => 'Invalid Ip address.']);
        }


        return view('welcome', ['error' => 'Unable to fetch geolocation data.']);
    }

    public function store(Request $request)
    {
        // dd($request->ip);
        $ip = $request->ip;
        $geoData = $this->geoService->getGeolocation($ip);
        // dd($geoData);

        if (isset($geoData)) {
            $geoData = GeolocationLog::create([
                'ip_address' => $ip,
                'country' => $geoData['country_name'],
                'region' => $geoData['state_prov'],
                'city' => $geoData['city'],
                'latitude' => $geoData['latitude'],
                'longitude' => $geoData['longitude'],
            ]);

            return view('welcome', compact('geoData'));

        }

        // return response()->json(['message' => 'Geolocation data stored successfully.']);
    }
}
