<?php
namespace App\Services;

use GuzzleHttp\Client;

class NgrokService
{
    public static function getTunnelUrl()
    {
        try {
            $client = new Client();
            $response = $client->get('http://127.0.0.1:4040/api/tunnels');
            $data = json_decode($response->getBody(), true);
            foreach ($data['tunnels'] as $tunnel) {
                if ($tunnel['proto'] === 'https') {
                    return $tunnel['public_url'];
                }
            }
        } catch (\Exception $e) {
            return config('app.url'); // Fallback to localhost in dev
        }
    }
}
