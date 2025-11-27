<?php

namespace App\Classes;
use Illuminate\Support\Facades\Log;
class EmailSch
{


    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */


    function getClient()
    {
        $client = new \Google_Client();
      
        Log::error("1");
        $client->setApplicationName('Calendar API Test');
        Log::error("2");
        $client->setScopes(['https://www.googleapis.com/auth/calendar']);
        // $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        Log::error("3");
        $client->setAuthConfig(public_path('client_secret.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        Log::error("4");
        // Load previously authorized token from a file, if it exists.
        // and refresh tokens, and is created automatically when the authorization flow completes for the first time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            Log::error("12");
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        Log::error("5");
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                Log::error(json_encode($authUrl));
                header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                Log::error("8");
                // Check Param on redirected URL, for ?code=#############  
                // you have to copy only ?code= $_GET parms data and paste in console
                $authCode = trim(fgets(STDIN)); // Get code after Authentication

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }

            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }

            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}
