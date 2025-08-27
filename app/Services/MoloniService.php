<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MoloniService
{
    protected $baseUrl;
    protected $accessToken;
    protected $companyId;

    public function __construct()
    {
        $this->baseUrl = config('services.moloni.api');
        $this->companyId = config('services.moloni.company_id');
        $this->accessToken = $this->authenticate();
    }

    protected function authenticate()
    {
        $response = Http::asForm()->post($this->baseUrl . '/oauth/grant', [
            'client_id' => config('services.moloni.client_id'),
            'client_secret' => config('services.moloni.client_secret'),
            'grant_type' => 'client_credentials',
        ]);

        if ($response->failed()) {
            throw new \Exception('Error al autenticar con Moloni: ' . $response->body());
        }

        return $response->json()['access_token'];
    }

    public function getCompany()
    {
        $response = Http::withToken($this->accessToken)
            ->get($this->baseUrl . '/companies');

        if ($response->failed()) {
            throw new \Exception('Error al obtener empresa: ' . $response->body());
        }

        return $response->json();
    }
}
