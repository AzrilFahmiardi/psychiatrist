<?php

use Google\Client;
use Google\Service\Calendar;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setScopes([Calendar::CALENDAR, 'email', 'profile']); // Add the required scope

        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }
}
