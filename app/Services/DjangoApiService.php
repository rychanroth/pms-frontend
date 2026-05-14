<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DjangoApiService
{
    public $baseUrl;

    public function __construct()
    {
        // Change this to match your Django local server URL!
        $this->baseUrl = 'http://127.0.0.1:8000/api';
    }

    public function login($username, $password)
    {
        return Http::post("{$this->baseUrl}/login/", [
            'username' => $username,
            'password' => $password,
        ]);
    }

    private function withToken()
    {
        $token = session('api_token');
        return Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ]);
    }

    public function get($endpoint)
    {
        return $this->withToken()->get("{$this->baseUrl}/{$endpoint}");
    }

    public function post($endpoint, $data)
    {
        return $this->withToken()->post("{$this->baseUrl}/{$endpoint}", $data);
    }
}