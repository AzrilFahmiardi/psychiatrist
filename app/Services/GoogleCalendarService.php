<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use App\Models\User;

class GoogleCalendarService
{
    protected $client;
    protected $service;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->client = new Google_Client();
        
        // Ambil token yang tersimpan
        $token = json_decode($user->google_token, true);
        
        if ($token) {
            $this->client->setAccessToken($token);
            
            // Jika token kadaluarsa dan ada refresh token
            if ($this->client->isAccessTokenExpired() && isset($token['refresh_token'])) {
                $newToken = $this->client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
                $user->google_token = json_encode($newToken);
                $user->save();
            }
        }

        $this->service = new Google_Service_Calendar($this->client);
    }

    public function listEvents($calendarId = 'primary', $optParams = [])
    {
        try {
            $results = $this->service->events->listEvents($calendarId, $optParams);
            return $results->getItems();
        } catch (\Exception $e) {
            return [];
        }
    }
}