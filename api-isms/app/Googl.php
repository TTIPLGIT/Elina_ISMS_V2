<?php

namespace App;

use Google_Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth;
use Illuminate\Support\Facades\log;

class Googl
{
    public function client()
    {
        $userID = (auth()->check()) ? auth()->user()->id : 1;
        
        // Log::error($userID);
        $workspace_email = DB::Select("select workspace_email from users where id=$userID");
        $workspace_email = $workspace_email[0]->workspace_email;
        // $email = ($userID!=="")? $workspace_email:'aathish.mani@1daymaidservices.com'; //Replace with the Auth Email
        $email = 'anvitha-itservices@elinaservices.in'; //Replace with the Auth Email
        // $email = 'aathish.mani@1daymaidservices.com';
        // Log::error($workspace_email);
        $client = new Google_Client();
        $jsonKey = storage_path('elina_calendar.json');
        $client->setApplicationName('iCalEvent');
        $client->setScopes(['https://www.googleapis.com/auth/calendar']);
        $client->setAuthConfig($jsonKey);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setApprovalPrompt('force');
        $client->useApplicationDefaultCredentials();
        $client->setSubject($email);
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $client->setAccessToken($token);
        return $client;
    }

    public function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('iCalEvent');
        $client->setScopes(['https://www.googleapis.com/auth/admin.directory.user']);
        $client->setAuthConfig(storage_path('elina_calendar.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setApprovalPrompt('force');
        $client->useApplicationDefaultCredentials();
        $client->setSubject('anvitha-itservices@elinaservices.in'); //Replace with Google Workspace Admin Email
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $client->setAccessToken($token);
        return $client;
    }
}
