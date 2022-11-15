<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once 'DatabaseConnection.php';
define("PATH", "/google-cloud");

use Carbon\Carbon;

class GoogleCloudApi{
    public function getAuthUrl(){
        $client = $this->setupClient();
        $auth_url = $client->createAuthUrl();
        return $auth_url;
    }

    public function getAccessToken($code){
        $client = $this->setupClient();
        $client->authenticate($code);
        $access_token = $client->getAccessToken();
        return $access_token;
    }

    private function setupClient(){
        $client = new Google\Client();
        $client->setAuthConfig(__DIR__ .'/../env/client_secret.json');
        $client->addScope(Google\Service\Drive::DRIVE_METADATA_READONLY);
        $client->addScope(Google\Service\Calendar::CALENDAR);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] .PATH .'/authenticate.php');
        $client->setAccessType('offline'); 
        $client->setIncludeGrantedScopes(true);   
        $client->setPrompt('consent');

        return $client;
    }

    private function setupClientConfigured(){
        $client = new Google\Client();
        $client->setAuthConfig(__DIR__ .'/../env/client_secret.json');
        $client->addScope(Google\Service\Drive::DRIVE_METADATA_READONLY);
        $client->addScope(Google\Service\Calendar::CALENDAR);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] .PATH .'/authenticate.php');
        $client->setAccessType('offline'); 
        $client->setIncludeGrantedScopes(true);   
        $client->setPrompt('none');

        return $client;
    }

    public function storeAccessToken($user_id, $access_token, $code){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("INSERT INTO `user_access_tokens`(access_token, code, user_id, created_at, updated_at) VALUES(?, ?, ?, ?, ?)");
        $query->execute(array(json_encode($access_token), $code, $user_id, date("d-m-Y H:i"), date("d-m-Y H:i")));
        $connection = null;
    }

    public function retrieveStoredAccessToken($user_id){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("SELECT user_access_tokens.access_token FROM user_access_tokens WHERE user_id = ?");
        $query->execute(array($user_id));
        $connection = null;
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function deleteStoredAccessToken($user_id, $refresh_token){
        $client = $this->setupClientConfigured();
        $access_token = $client->refreshToken($refresh_token);

        $client->setAccessToken($access_token);
        $client->revokeToken();

        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("DELETE FROM user_access_tokens WHERE user_id = ?");
        $query->execute(array($user_id));
        $connection = null;
    }

    public function test($access_token){
        $client = $this->setupClient();
        $client->setAccessToken($access_token);
        $drive = new Google\Service\Drive($client);
        $files = $drive->files->listFiles(array())->getItems();
        return json_encode($files);
    }

    public function testCalendar($access_token){
        $client = $this->setupClient();
        $client->setAccessToken($access_token);

        $service = new Google\Service\Calendar($client);
        $calendar = $service->events->get('primary');

        return json_encode($calendar->getSummary());
    }

    public function addEventBackup($access_token){
        $client = $this->setupClient();
        $client->setAccessToken($access_token);

        $service = new Google\Service\Calendar($client);

        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Phoebe Demo',
            'location' => 'Property Agents Network Office',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
                'dateTime' => '2022-11-19T09:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ),
            'end' => array(
                'dateTime' => '2022-11-19T17:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ),
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => array(
                array('email' => 'lpage@example.com'),
                array('email' => 'sbrin@example.com'),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        printf('Event created: %s\n', $event->htmlLink);

    }

    public function addEvent($refresh_token, $event_details){
        $client = $this->setupClientConfigured();
        $access_token = $client->refreshToken($refresh_token);

        $client->setAccessToken($access_token);
        $service = new Google\Service\Calendar($client);


        try {
            $start_date = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($event_details['start_date'])))->subHours('2')->format(DateTime::ISO8601);
            $stop_date = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($event_details['stop_date'])))->subHours('2')->format(DateTime::ISO8601);
    
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $event_details['title'],
                'location' => $event_details['location'],
                'description' => $event_details['description'],
                'start' => array(
                    'dateTime' => $start_date,
                    'timeZone' => 'Africa/Nairobi',
                ),
                'end' => array(
                    'dateTime' => $stop_date,
                    'timeZone' => 'Africa/Nairobi',
                ),
                'attendees' => array(
                    array('email' => $event_details['attendee'],
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'email', 'minutes' => 24 * 60),
                        array('method' => 'popup', 'minutes' => 10),
                    ),
                ),
            )));
    
            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event);
            
            header('Location: dashboard.php?success=Event created successfully');
        } catch (\Throwable $th) {
            header('Location: dashboard.php?error=An error occurred');
        }

    }

    public function getEvents($refresh_token){
        $client = $this->setupClientConfigured();

        $access_token = $client->refreshToken($refresh_token);

        $client->setAccessToken($access_token);

        $service = new Google\Service\Calendar($client);

        $events = $service->events->listEvents('primary');
        // $events_array = (array)$events;
        // $sorted_events = ksort($events_array);
        // return json_decode(json_encode($sorted_events));
        return $events;
    }

    private function addScopes($client){
        $client->addScope(Google\Service\Drive::DRIVE_METADATA_READONLY);
    }
}