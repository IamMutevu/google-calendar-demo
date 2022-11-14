<?php
include 'session_head.php';
include 'classes/GoogleCloudApi.php';

$apiObject = new GoogleCloudApi();
// $user_id = "264";

if (! isset($_GET['code'])) {
    $auth_url = $apiObject->getAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} 
else if (isset($_GET['error']) && $_GET['error'] == "access_denied") {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] .PATH .'/access_denied.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
} 
else {
    $access_token = $apiObject->retrieveStoredAccessToken($user_id);
    if($access_token == null){
        $access_token = $apiObject->getAccessToken($_GET['code']);
        $apiObject->storeAccessToken($user_id, $access_token, $_GET['code']);

        echo json_encode($access_token, JSON_PRETTY_PRINT) ."<br>";
        echo gettype($access_token) ."<br>";
    }

    // echo $apiObject->addEventBackup($access_token);
    // header('Location: dashboard.php?success=Event created successfully');
} 