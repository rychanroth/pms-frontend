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
        $response = Http::post("{$this->baseUrl}/login/", [
            'username' => $username,
            'password' => $password,
        ]);

        return $response;
    }
}