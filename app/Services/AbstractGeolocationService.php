<?php

namespace App\Services;

use App\Interfaces\GeolocationServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AbstractGeolocationService implements GeolocationServiceInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.abstractapi.key');
    }

    public function getGeolocation(string $ip)
    {
        return Cache::remember("geolocation_{$ip}", 3600, function () use ($ip) {
            try {
                $response = Http::get("https://api.ipgeolocation.io/ipgeo?apiKey={$this->apiKey}&ip_address={$ip}");

                if ($response->successful()) {
                    \Log::info('API Response', ['response' => $response->json()]);
                    return $response->json();
                } else {
                    \Log::error('API Error', ['response' => $response->body()]);
                }
            } catch (\Exception $e) {
                \Log::error('API Exception', ['message' => $e->getMessage()]);
            }

            return null;
        });
    }
}
